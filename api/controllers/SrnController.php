<?php

namespace api\controllers;

use Yii;
use common\models\User;

/**
 * Description of SrnController
 *
 * @author Ravi Sikarwar
 */
class SrnController extends \yii\rest\Controller
{

    protected $success = 1;
    protected $failed = 0;

    public function beforeAction($action)
    {
        $parent = parent::beforeAction($action);
        $authTokenHeader = Yii::$app->request->getHeaders()->get('token');
        if ($authTokenHeader !== \Yii::$app->params['AuthToken']) {
            throw new \components\exceptions\AppException("invalid access");
        }
        return $parent;
    }

    public function actionDetail($srn)
    {
        if (!Yii::$app->request->isGet) {
            return $this->outputResponse($this->failed, ['message' => 'Invalid Request.']);
        }

        if (!isset($srn) || empty($srn)) {
            return $this->outputResponse($this->failed, ['message' => 'Oops! SRN No cannot be blank.']);
        }

        $srnModel = \common\models\Grievance::find()
                ->select(['a.srn_no as srn', 'a.status',
                    '(CASE WHEN a.status =0 THEN "VR NOT RECEIVED"
                WHEN a.status =1 THEN "FRESH CLAIM PENDING"
                WHEN a.status =2 THEN "RESUBMITTED PENDING"
                WHEN a.status =3 THEN "APPROVED"
                WHEN a.status =4 THEN "REJECTED"
                WHEN a.status =5 THEN "SENT FOR RESUBMISSION"
                WHEN a.status =6 THEN "PAID"
                WHEN a.status =7 THEN "UNDER PROCESS"
                END) AS statusText', 'DATE_FORMAT(b.date,"%d-%m-%Y") as date'
                ])
                ->from('grievance a')
                ->leftJoin('(SELECT MAX(`date`) `date`,grievance_id,grievance_status FROM grievance_activity_log GROUP BY grievance_activity_log.id) b', 'b.grievance_id = a.id AND b.grievance_status = a.status')
                ->where('a.srn_no=:srnNo', [':srnNo' => $srn])
                ->asArray()
                ->one();

        $srnData = [];
        if (empty($srnModel)) {
            return $this->outputResponse($this->failed, ['message' => 'Oops no record found for this SRN']);
        }

        return $this->outputResponse($this->success, [], $srnModel);
    }

    protected function outputResponse($status, $errors = [], $data = [])
    {
        return [
            'status' => $status,
            'errors' => $errors,
            'data' => $data
        ];
    }

}
