<?php

namespace common\models;

use Yii;
use common\models\base\Grievance as BaseGrievance;

/**
 * Description of Grievance
 *
 * @author Ravi Sikarwar
 */
class Grievance extends BaseGrievance
{
    const PENDING = 0;
    const VR_ASSIGNED = 1;
    const DR_ASSIGNED = 2;
    const APPROVED = 3;
    const REJECTED = 4;
    const DISCREPANCY = 5;
    const PAID = 6;
    const UNDER_PROCESS = 7;
    
    const STATUS_SHARES_ONLY = 1;
    const STATUS_AMOUNT_ONLY = 2;
    const STATUS_BOTH = 3;
    const STATUS_PAID_SHARE = 4;
    const STATUS_PAID_AMOUNT = 5;
    const STATUS_PAID_BOTH = 6;
    const STATUS_PARTIAL_PAID_SHARES_ONLY = 7;
    const STATUS_PARTIAL_PAID_AMOUNT_ONLY = 8;

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on','modified_on'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_on'],
                ]
            ],
            \components\behaviors\GuidBehavior::className(),
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['srn_no','applicant_name','applicant_address','applicant_bank_name','applicant_bank_branch','applicant_micr_code','applicant_dmat_account_no']
            ],
        ];
    }

    
    public function rules()
    {
        $rules = parent::rules();
        $myRules = [

            [['rack_no'], 'required', 'on' => ['additional-detail']],
            [['security_depository_type'], 'required', 'on' => ['depository']],
            [['approved_share_date', 'import_depository_type'], 'safe'],
            [['approved_shares'], 'number'],
            [['refund_share_date', 'refund_amount_date'], 'validateDates'],
        ];

        return \yii\helpers\ArrayHelper::merge($rules, $myRules);
    }

    public function validateDates($attribute)
    {
        if (strtotime($this->$attribute) > strtotime(date('Y-m-d'))) {
            $this->addError($attribute, "{$attribute} cannot be greater than current date");
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
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

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid =:guid', [':guid' => $params['guid']]);
        }

        if (isset($params['customerId'])) {
            $modelAQ->andWhere($tableName . '.customer_id =:customerId', [':customerId' => $params['customerId']]);
        }

        if (isset($params['srnNo'])) {
            $modelAQ->andWhere($tableName . '.srn_no =:srnNo', [':srnNo' => $params['srnNo']]);
        }

        if (isset($params['dealingHeadId']) && $params['dealingHeadId'] > 0) {
            $modelAQ->andWhere($tableName . '.dh_id =:dealingHeadId', [':dealingHeadId' => $params['dealingHeadId']]);
        }

        if (isset($params['Notnull'])) {
            $modelAQ->andWhere($tableName . '.dh_id IS NOT NULL');
        }

        if (isset($params['status'])) {

            if (is_array($params['status']) && count($params['status']) > 0) {
                $modelAQ->andWhere(['IN', $tableName . '.status', $params['status']]);
            }
            else {
                $modelAQ->andWhere($tableName . '.status =:status', [':status' => $params['status']]);
            }
        }

        if (isset($params['discomId'])) {
            $modelAQ->andWhere($tableName . '.discom_id =:discomId', [':discomId' => $params['discomId']]);
        }

        if (isset($params['type'])) {
            $modelAQ->andWhere($tableName . '.type =:type', [':type' => $params['type']]);
        }

        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }

        if (isset($params['applicationStatus'])) {
            $modelAQ->andWhere($tableName . '.application_status =:applicationStatus', [':applicationStatus' => $params['applicationStatus']]);
        }

        if (isset($params['discomCode'])) {
            $modelAQ->andWhere('discom.discom_code =:discomCode', [':discomCode' => $params['discomCode']]);
        }
        
        if (isset($params['fromShareDate']) && !empty($params['fromShareDate'])) {
            $modelAQ->andWhere('grievance.refund_share_date >=:fromShareDate', [':fromShareDate' => $params['fromShareDate']]);
        }
        
        if (isset($params['toShareDate'])&& !empty($params['toShareDate'])) {
            $modelAQ->andWhere('grievance.refund_share_date <=:toShareDate', [':toShareDate' => $params['toShareDate']]);
        }
        
        if (isset($params['fromAmountDate'])&& !empty($params['fromAmountDate'])) {
            $modelAQ->andWhere('grievance.refund_amount_date >=:fromAmountDate', [':fromAmountDate' => $params['fromAmountDate']]);
        }
        
        if (isset($params['toAmountDate'])&& !empty($params['toAmountDate'])) {
            $modelAQ->andWhere('grievance.refund_amount_date <=:toAmountDate', [':toAmountDate' => $params['toAmountDate']]);
        }

        // join with user
        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'user.id = grievance.dh_id');
        }

        // join with grievance activity log
        if (isset($params['joinWithGrievanceActivityLog']) && in_array($params['joinWithGrievanceActivityLog'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithGrievanceActivityLog']}('grievance_activity_log', 'grievance_activity_log.grievance_id = grievance.id');

            if (isset($params['activityFromDate']) && !empty($params['activityFromDate'])) {
                $modelAQ->andWhere('grievance_activity_log.date >=:activityFromDate', [':activityFromDate' => $params['activityFromDate']]);
            }

            if (isset($params['activityFromDateStatus']) && !empty($params['activityFromDateStatus'])) {
                $modelAQ->andWhere('grievance_activity_log.date >= :activityFromDateStatus', [':activityFromDateStatus' => $params['activityFromDateStatus']]);
            }
            
            if (isset($params['activityToDate']) && !empty($params['activityToDate'])) {
                $modelAQ->andWhere('grievance_activity_log.date <= :activityToDate', [':activityToDate' => $params['activityToDate']]);
            }
            
            if (isset($params['notDate']) && !empty($params['notDate'])) {
                $modelAQ->andWhere('grievance_activity_log.date != :notDate', [':notDate' => $params['notDate']]);
            }
            
            if (isset($params['grievanceAndActivityLogStatus'])&& $params['grievanceAndActivityLogStatus']) {
                $modelAQ->andWhere('grievance.status = grievance_activity_log.grievance_status');
            }
        }
        
        if (isset($params['joinWithGrievanceMessageLog']) && in_array($params['joinWithGrievanceMessageLog'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithGrievanceMessageLog']}('grievance_message_log', 'grievance_message_log.grievance_id = grievance.id');
            
            if (isset($params['fromCreatedOn']) && !empty($params['fromCreatedOn'])) {
                $modelAQ->andWhere('DATE_FORMAT(FROM_UNIXTIME(grievance_message_log.created_on), "%Y-%m-%d") >= :fromCreatedOn', [':fromCreatedOn' => $params['fromCreatedOn']]);
            }
            
            if (isset($params['toCreatedOn']) && !empty($params['toCreatedOn'])) {
                $modelAQ->andWhere('DATE_FORMAT(FROM_UNIXTIME(grievance_message_log.created_on), "%Y-%m-%d") <= :toCreatedOn', [':toCreatedOn' => $params['toCreatedOn']]);
            }
        }

        // join with company
        if (isset($params['joinWithCompany']) && in_array($params['joinWithCompany'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithCompany']}('company', 'company.id = grievance.company_id');
        }

        if (isset($params['inOperator']) && !empty($params['inOperator'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
        }
        
        if (isset($params['notInOperator']) && !empty($params['notInOperator'])) {
            $modelAQ->andWhere(['NOT IN', $params['notInOperator']['column'], $params['notInOperator']['data']]);
        }


        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.posting_date >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        if (isset($params['lessCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.posting_date <=:lessCreatedAt', [':lessCreatedAt' => $params['lessCreatedAt']]);
        }

        if (isset($params['likeGrievanceNo'])) {
            $modelAQ->andFilterWhere(['like', 'grievance.grievance_no', $params['likeGrievanceNo']]);
        }
        
        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public function findByType($type, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['type' => $type], $params));
    }

    public static function findGrievance($params = [])
    {
        return self::findByParams($params);
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }

    public static function findBySrnNo($srnNo, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['srnNo' => $srnNo], $params));
    }
    
    public static function getGrievanceStatusArr($key = NULL, $showPending = FALSE, $flip = FALSE)
    {
        $status = [
            self::VR_ASSIGNED => 'FRESH CLAIM PENDING',
            self::DR_ASSIGNED => 'RESUBMITTED PENDING',
            self::APPROVED => 'APPROVED',
            self::REJECTED => 'REJECTED',
            self::DISCREPANCY => 'SENT FOR RESUBMISSION',
            self::PAID => 'PAID',
            self::UNDER_PROCESS => 'UNDER PROCESS',
        ];

        if ($showPending) {
            $status = \yii\helpers\ArrayHelper::merge([self::PENDING => 'VR NOT RECEIVED'], $status);
        }
        if ($flip) {

            $status = array_flip($status);
        }

        return isset($key) && !empty($key) ? $status[$key] : $status;
    }

    public static function allocateToDealingHead($grievanceId = NULL, $grievanceStatus = NULL)
    {
        $grievanceModel = Grievance::findById($grievanceId, ['selectCols' => ['grievance.status']]);

        if (empty($grievanceModel)) {
            throw new \components\exceptions\AppException('Something went wrong while assign dealing head.');
        }
        if ($grievanceStatus == self::VR_ASSIGNED) {

            \Yii::$app->db->createCommand("UPDATE `user` u SET is_limit_achieved = IF((SELECT COUNT(u1.id) AS userCount FROM (SELECT * FROM `user`) u1 WHERE u1.is_limit_achieved = 0 AND `u1`.`status` = 10 AND u1.role_id = 4) >  0 , `u`.is_limit_achieved, 0) WHERE `u`.`status` = 10 AND u.role_id = 4")->execute();

            $userParams = [
                'status' => User::STATUS_ACTIVE,
                'isLastAllocated' => User::IS_LAST_ALLOCATED_YES,
                'orderBy' => 'user.id',
                'isLimitAcheived' => 0,
                'notEmptyAllowedGrievance' => 0,
                'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT
            ];
            $fetchedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);

            if (empty($fetchedUserModel)) {
                $userParams = [
                    'status' => User::STATUS_ACTIVE,
                    'isLastAllocated' => User::IS_LAST_ALLOCATED_NO,
                    'limit' => 1,
                    'isLimitAcheived' => 0,
                    'notEmptyAllowedGrievance' => 0,
                    'orderBy' => 'user.id',
                    'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT
                ];
                $assignedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);
            }
            else {
                // fetch next dealing head
                $userParams = [
                    'status' => User::STATUS_ACTIVE,
                    'isLastAllocated' => User::IS_LAST_ALLOCATED_NO,
                    'nextDhUserId' => $fetchedUserModel->id,
                    'limit' => 1,
                    'isLimitAcheived' => 0,
                    'notEmptyAllowedGrievance' => 0,
                    'orderBy' => 'user.id',
                    'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT
                ];
                $assignedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);

                if (empty($assignedUserModel)) {
                    $userParams = [
                        'status' => User::STATUS_ACTIVE,
                        'isLastAllocated' => User::IS_LAST_ALLOCATED_NO,
                        'limit' => 1,
                        'isLimitAcheived' => 0,
                        'notEmptyAllowedGrievance' => 0,
                        'orderBy' => 'user.id',
                        'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT
                    ];
                    $assignedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);

                    if (empty($assignedUserModel)) {
                        $userParams = [
                            'status' => User::STATUS_ACTIVE,
                            'isLastAllocated' => User::IS_LAST_ALLOCATED_YES,
                            'limit' => 1,
                            'isLimitAcheived' => 0,
                            'notEmptyAllowedGrievance' => 0,
                            'orderBy' => 'user.id',
                            'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT
                        ];
                        $assignedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);
                    }
                }
            }

            $assignedUserModel->is_last_allocated = User::IS_LAST_ALLOCATED_YES;
            $assignedUserModel->allocated_grievance = $assignedUserModel->allocated_grievance + 1;

            $userTarget = User::findUserTarget($assignedUserModel->id, $params = [], date('m'));
            if (empty($userTarget)) {
                throw new \components\exceptions\AppException('Dealing head SRN not allocated.');
            }

            if ($assignedUserModel->allocated_grievance == $userTarget) {
                $assignedUserModel->is_limit_achieved = 1;
            }

            if (!$assignedUserModel->save()) {
                throw new \components\exceptions\AppException('Something went wrong while assign dealing head.');
            }

            if (!empty($fetchedUserModel)) {
                $fetchedUserModel->is_last_allocated = User::IS_LAST_ALLOCATED_NO;
                $fetchedUserModel->save(TRUE, ['is_last_allocated', 'allocated_grievance']);
            }

            Grievance::updateAll([
                'dh_id' => $assignedUserModel->id,
                    ], 'id =:id', [':id' => $grievanceId]);
        }
    }

    public static function allocateToDealingHead_old($grievanceId)
    {
        $grievanceModel = Grievance::findById($grievanceId, ['selectCols' => ['grievance.status']]);

        if (empty($grievanceModel)) {
            throw new \components\exceptions\AppException('Something went wrong while assign dealing head.');
        }
        if ($grievanceModel['status'] == self::PENDING) {

            $userParams = [
                'status' => User::STATUS_ACTIVE,
                'isLastAllocated' => User::IS_LAST_ALLOCATED_YES,
                'orderBy' => 'user.id',
                'resultFormat' => caching\ModelCache::RETURN_TYPE_OBJECT
            ];
            $fetchedUserModel = User::findByRoleId(Role::ROLE_DEALING_HEAD, $userParams);
        }
    }

    public static function roundRobin($teams)
    {

        if (count($teams) % 2 != 0) {
            array_push($teams, "bye");
        }
        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]["Home"] = $home[$j];
                $round[$i][$j]["Away"] = $away[$j];
            }
            if (count($home) + count($away) - 1 > 2) {
                $s = array_splice($home, 1, 1);
                $slice = array_shift($s);
                array_unshift($away, $slice);
                array_push($home, array_pop($away));
            }
        }
        return $round;
    }

    public static function getGrievanceCounter($params = [])
    {
        $queryParams = [
            'count' => TRUE,
        ];

        return Student::findByParams(\yii\helpers\ArrayHelper::merge($queryParams, $params));
    }

}
