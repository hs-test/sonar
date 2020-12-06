<?php

namespace common\models;

use common\models\base\GrievanceActivityComment as BaseGrievanceActivityComment;

/**
 * Description of GrievanceActivityComment
 *
 * @author Ravi Sikarwar
 */
class GrievanceActivityComment extends BaseGrievanceActivityComment
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
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['comment']
            ],
        ];
    }

    public static function findByGrievanceActivityId($grievanceActivityId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['grievanceActivityId' => $grievanceActivityId], $params));
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

        if (isset($params['grievanceActivityId'])) {
            $modelAQ->andWhere($tableName . '.grievance_activity_id =:grievanceActivityId', [':grievanceActivityId' => $params['grievanceActivityId']]);
        }

        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }
        
        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'grievance_activity_comment.created_by = user.id');
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

}
