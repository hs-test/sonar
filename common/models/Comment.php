<?php

namespace common\models;

use common\models\base\Comment as BaseComment;

/**
 * Description of Comment
 *
 * @author Ravi Sikarwar
 */
class Comment extends BaseComment
{

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
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

        if (isset($params['grievanceId'])) {
            $modelAQ->andWhere($tableName . '.grievance_id =:grievanceId', [':grievanceId' => $params['grievanceId']]);
        }

        if (isset($params['stateCode'])) {
            $modelAQ->andWhere($tableName . '.state_code =:state_code', [':state_code' => $params['stateCode']]);
        }

        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'comment.created_by = user.id');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

}
