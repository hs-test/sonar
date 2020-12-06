<?php

namespace common\models;

use Yii;
use common\models\base\GrievanceMessageLogDetail as BaseGrievanceMessageLogDetail;

/**
 * Description of GrievanceAssignLog
 *
 * @author Ravi Sikarwar
 */
class GrievanceMessageLogDetail extends BaseGrievanceMessageLogDetail
{

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on'],
                ]
            ],
        ];
    }
    
    public function init()
    {
        $this->created_by = \Yii::$app->user->id;
        return parent::init();
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGrievanceId($grievanceId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['grievanceId' => $grievanceId], $params));
    }

    private static function findByParams($params = [])
    {
        $modelAQ = self::find();
        $tableName = self::tableName();

        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select($tableName . '.*');
        }

        if (isset($params['id'])) {
            $modelAQ->andWhere($tableName . '.id =:id', [':id' => $params['id']]);
        }

        if (isset($params['grievanceId'])) {
            $modelAQ->andWhere($tableName . '.grievance_id =:grievanceId', [':grievanceId' => $params['grievanceId']]);
        }

        if (isset($params['applicationStatus'])) {
            $modelAQ->andWhere($tableName . '.grievance_status =:grievanceStatus', [':grievanceStatus' => $params['grievanceStatus']]);
        }

        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }

        if (isset($params['inOperator']) && !empty($params['inOperator'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
        }

        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'grievance_assign_log.created_by = user.id');

            if (isset($params['joinWithRole']) && in_array($params['joinWithRole'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
                $modelAQ->{$params['joinWithRole']}('role', 'role.id = user.role_id');
            }
        }
        if (isset($params['joinWithPreviousDealing']) && in_array($params['joinWithPreviousDealing'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithPreviousDealing']}('user previousDealingHead', 'grievance_assign_log.prv_dh_id = previousDealingHead.id');
        }
        if (isset($params['joinWithNewDealing']) && in_array($params['joinWithNewDealing'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithNewDealing']}('user newDealingHead', 'grievance_assign_log.new_dh_id = newDealingHead.id');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public function saveLogs($grievanceId, $messageLogId, $sendType)
    {

        $grievanceModel = Grievance::findById($grievanceId, [
                    'selectCols' => ['grievance.applicant_name', 'grievance.applicant_email', 'grievance.company_id'],
        ]);
        if (empty($grievanceModel)) {
            return FALSE;
        }

        try {

            switch ($sendType) {
                case GrievanceMessageLog::SENT_TYPE_APPLICANT:
                    $model = new GrievanceMessageLogDetail();
                    $model->grievance_message_log_id = $messageLogId;
                    $model->status = 1;
                    $model->receiver_name = $grievanceModel['applicant_name'];
                    $model->type = strtoupper(GrievanceMessageLog::SENT_TYPE_APPLICANT);
                    if (!$model->save()) {
                        return $model->getErrors();
                    }
                    // send mail
                    if (!empty($grievanceModel['applicant_email'])) {
                        $params = [
                            'name' => $grievanceModel['applicant_name'],
                            'email' => $grievanceModel['applicant_email'],
                        ];
                        Yii::$app->email->sendEmail($messageLogId, $params);
                    }

                    break;
                case GrievanceMessageLog::SENT_TYPE_COMPANY:

                    $companyParams = [
                        'selectCols' => ['company_detail.contact_person', 'company_detail.email'],
                        'joinWithCompanyInfo' => 'innerJoin',
                        'resultCount' => 'all'
                    ];

                    $companyModel = Company::findById($grievanceModel['company_id'], $companyParams);

                    if (empty($companyModel)) {
                        throw new \components\exceptions\AppException("Sorry, Company users not found.");
                        return FALSE;
                    }
                    foreach ($companyModel as $company) {

                        $model = new GrievanceMessageLogDetail();
                        $model->grievance_message_log_id = $messageLogId;
                        $model->status = 1;
                        $model->receiver_name = $company['contact_person'];
                        $model->type = strtoupper(GrievanceMessageLog::SENT_TYPE_COMPANY);
                        if (!$model->save()) {
                            return $model->getErrors();
                        }
                        // send mail
                        if (!empty($company['email'])) {

                            $params = [
                                'name' => $company['contact_person'],
                                'email' => $company['email'],
                            ];
                            Yii::$app->email->sendEmail($messageLogId, $params);
                        }
                    }

                    break;
                case GrievanceMessageLog::SENT_TYPE_BOTH:

                    // save appicant data
                    $applicantModel = new GrievanceMessageLogDetail();
                    $applicantModel->grievance_message_log_id = $messageLogId;
                    $applicantModel->status = 1;
                    $applicantModel->receiver_name = $grievanceModel['applicant_name'];
                    $applicantModel->type = strtoupper(GrievanceMessageLog::SENT_TYPE_APPLICANT);
                    $applicantModel->save();
                    //send mail to applicant
                    if (!empty($grievanceModel['applicant_email'])) {
                        $params = [
                            'name' => $grievanceModel['applicant_name'],
                            'email' => $grievanceModel['applicant_email'],
                        ];
                        Yii::$app->email->sendEmail($messageLogId, $params);
                    }
                    // save company model
                    $companyParams = [
                        'selectCols' => ['company_detail.contact_person', 'company_detail.email'],
                        'joinWithCompanyInfo' => 'innerJoin',
                        'resultCount' => 'all'
                    ];

                    $companyModel = Company::findById($grievanceModel['company_id'], $companyParams);

                    if (empty($companyModel)) {
                        throw new \components\exceptions\AppException("Sorry, Company users not found.");
                        return FALSE;
                    }
                    foreach ($companyModel as $company) {

                        $companyModel = new GrievanceMessageLogDetail();
                        $companyModel->grievance_message_log_id = $messageLogId;
                        $companyModel->status = 1;
                        $companyModel->receiver_name = $company['contact_person'];
                        $companyModel->type = strtoupper(GrievanceMessageLog::SENT_TYPE_COMPANY);
                        $companyModel->save();
                        //send mail to applicant
                        if (!empty($companyModel['email'])) {
                            $params = [
                                'name' => $company['contact_person'],
                                'email' => $company['email'],
                            ];
                            Yii::$app->email->sendEmail($messageLogId, $params);
                        }
                    }

                    break;

                default:
                    break;
            }

            return TRUE;
        }
        catch (\Exception $ex) {
            throw $ex;
        }
        return FALSE;
    }

}
