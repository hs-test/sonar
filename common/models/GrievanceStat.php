<?php

namespace common\models;

use Yii;
use common\models\base\GrievanceStat as BaseGrievanceStat;

/**
 * Description of Grievance
 *
 * @author Ravi Sikarwar
 */
class GrievanceStat extends BaseGrievanceStat
{

    const TYPE_GRIEVANCE = 'grievance';
    const TYPE_CDSL = 'cdsl';
    const TYPE_NSDL = 'nsdl';
    const TYPE_AMOUNT = 'amount';
    const TYPE_VR = 'vr';
    const TYPE_DR = 'dr';
    const TYPE_APPROVED = 'approved';
    const TYPE_PAID = 'paid';
    const TYPE_UNDERPROCESS = 'underprocess';
    const TYPE_VR_REJECTED = 'vrrejected';
    const TYPE_DISCRIPENCY_REJECTED = 'discripancyrejected';
    const TYPE_SCAN_IMPORT = 'scan';
    const TYPE_REVIEW_IMPORT = 'review';

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

     

    public function beforeValidate()
    {
        return parent::beforeValidate();
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

        // join with state
        if (isset($params['joinWithState']) && in_array($params['joinWithState'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithState']}('state', 'state.code = grievance.state_code');
        }

        if (isset($params['inOperator']) && !empty($params['inOperator'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
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

        //echo $modelAQ->createCommand()->rawSql;die;
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

}
