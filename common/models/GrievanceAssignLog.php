<?php

namespace common\models;

use common\models\base\GrievanceAssignLog as BaseGrievanceAssignLog;

/**
 * Description of GrievanceAssignLog
 *
 * @author Ravi Sikarwar
 */
class GrievanceAssignLog extends BaseGrievanceAssignLog
{

    public $srnNo;
    public $prefix;

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

}
