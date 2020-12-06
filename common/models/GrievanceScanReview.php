<?php

namespace common\models;

use common\models\base\GrievanceScanReview as BaseGrievanceScanReview;

/**
 * Description of GrievanceScanReview
 *
 * @author Ravi Sikarwar
 */
class GrievanceScanReview extends BaseGrievanceScanReview
{

    const TYPE_SCAN = 'SCAN';
    const TYPE_REVIEW = 'REVIEW';
    
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
    
      
    public function rules()
    {
        $rules = parent::rules();
        $myRules = [

            ['date', 'validateDates'],
        ];

        return \yii\helpers\ArrayHelper::merge($rules, $myRules);
    }

    public function validateDates($attribute)
    {
        if (strtotime($this->date) > strtotime(date('Y-m-d'))) {
            $this->addError($attribute, "Date cannot be greater than current date");
        }
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
            $modelAQ->{$params['joinWithUser']}('user', $tableName . '.created_by = user.id');

            if (isset($params['joinWithRole']) && in_array($params['joinWithRole'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
                $modelAQ->{$params['joinWithRole']}('role', 'role.id = user.role_id');
            }
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

}
