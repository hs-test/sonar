<?php

namespace common\models;

use Yii;
use common\models\base\MessageLog as BaseMessageLog;

/**
 * Description of MessageLog
 *
 * @author Ravi Sikarwar
 */
class MessageLog extends BaseMessageLog
{

    const SENT_TYPE_CREATION = 1;
    const SENT_TYPE_RESEND = 2;
    const SENT_TYPE_RESET = 3;
    
    const IS_MSG_SENT_SUCCESS = 1;
    const IS_MSG_SENT_FAILED = '-1';

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
            \components\behaviors\GuidBehavior::className()
        ];
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
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

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid =:guid', [':guid' => $params['guid']]);
        }

        if (isset($params['customerId'])) {
            $modelAQ->andWhere($tableName . '.customer_id =:customerId', [':customerId' => $params['customerId']]);
        }

        if (isset($params['grievanceId'])) {
            $modelAQ->andWhere($tableName . '.grievance_id =:grievanceId', [':grievanceId' => $params['grievanceId']]);
        }

        if (isset($params['messageId'])) {
            $modelAQ->andWhere($tableName . '.message_id =:messageId', [':messageId' => $params['messageId']]);
        }

        if (isset($params['grievance_no'])) {
            $modelAQ->andWhere($tableName . '.grievance_no =:grievance_no', [':grievance_no' => $params['grievance_no']]);
        }

        if (isset($params['type'])) {
            $modelAQ->andWhere($tableName . '.type =:type', [':type' => $params['type']]);
        }

        if (isset($params['applicationStatus'])) {
            $modelAQ->andWhere($tableName . '.application_status =:applicationStatus', [':applicationStatus' => $params['applicationStatus']]);
        }

        if (isset($params['messageStatus'])) {
            $modelAQ->andWhere($tableName . '.is_msg_sent =:messageStatus', [':messageStatus' => $params['messageStatus']]);
        }

        // join with state
        if (isset($params['joinWithState']) && in_array($params['joinWithState'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithState']}('state', 'state.code = grievance.state_code');

            // join with district 
        }
        if (isset($params['joinWithDistrict']) && in_array($params['joinWithDistrict'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithDistrict']}('district', 'district.code = grievance.district_code');

            // join with block
        }
        if (isset($params['joinWithVillage']) && in_array($params['joinWithVillage'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithVillage']}('village', 'village.code = grievance.village_code');
        }

        // join with customer

        if (isset($params['joinWithCustomer']) && in_array($params['joinWithCustomer'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithCustomer']}('customer', 'customer.id = grievance.customer_id');
        }

        // join with grievance type

        if (isset($params['joinWithType']) && in_array($params['joinWithType'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithType']}('type', 'type.id = grievance.type');
        }

        if (isset($params['stateCode'])) {
            $modelAQ->andWhere($tableName . '.state_code =:state_code', [':state_code' => $params['stateCode']]);
        }

        if (isset($params['discomNodalNotNull']) && $params['discomNodalNotNull']) {

            $modelAQ->andWhere($tableName . '.discom_nodal_id IS NOT NULL');
        }

        if (isset($params['discomNodalNull']) && $params['discomNodalNull']) {
            $modelAQ->andWhere($tableName . '.discom_nodal_id IS NULL');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        if (isset($params['lessCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at <=:lessCreatedAt', [':lessCreatedAt' => $params['lessCreatedAt']]);
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
    
    public static function saveMessageLog($grievanceId, $params = [])
    {
        try {
            $model = new MessageLog;
            $model->isNewRecord = TRUE;
            $model->grievance_id = $grievanceId;
            $model->discom_nodal_id = (isset($params['discomNodalId']) && $params['discomNodalId'] > 0) ? $params['discomNodalId'] : NULL;
            $model->send_type = (isset($params['sendType']) && in_array($params['sendType'], [self::SENT_TYPE_CREATION, self::SENT_TYPE_RESEND])) ? $params['sendType'] : NULL;
            $model->mobile_no = $params['mobile'];
            $model->message = $params['message'];
            $model->date = date('Y-m-d');
            $model->is_msg_sent = $params['is_msg_sent'];
            $model->logs = $params['logs'];
            $model->created_by = $params['userId'];


            if ($model->save(FALSE)) {
                return TRUE;
            }
        }
        catch (\Exception $ex) {
            throw $ex;
        }
        return FALSE;
    }

}
