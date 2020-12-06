<?php

namespace common\models;

use common\models\base\MessageTemplate as BaseMessageTemplate;

/**
 * Description of MessageTemplate
 *
 * @author Ravi Sikarwar
 */
class MessageTemplate extends BaseMessageTemplate
{
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_YES = 1;
    const RECORD_DELETED_NO = 0;
    
    const SERVICE_SRN_APPROVAL = 'APPROVAL';
    const SERVICE_SRN_SANCATION = 'SANCATION';
    const SERVICE_SRN_REJECTION = 'REJECTION';
    const SERVICE_SRN_DISCRIPANCY = 'DISCRIPANCY';
    const SERVICE_SRN_GAR = 'GAR';

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on', 'modified_on'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['modified_on'],
                ],
            ],
            \components\behaviors\GuidBehavior::className(),
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['title']
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
    
    public static function findByService($service, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['service' => $service], $params));
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
        
        if(isset($params['guid'])) {
            $modelAQ->andWhere($tableName.'.guid = :guid', [':guid' => $params['guid']]);
        }
        
        if(isset($params['template'])) {
            $modelAQ->andWhere($tableName.'.template = :template', [':template' => $params['template']]);
        }
        
         if (isset($params['service'])) {
            $modelAQ->andWhere($tableName . '.service = :service', [':service' => $params['service']]);
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

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }
    
    public static function buildTemplate($params = [])
    {
        $pattern = '{{%s}}';
        foreach ($params as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }
        return strtr($params['content'], $varMap);
    }

}
