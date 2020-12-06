<?php

namespace common\models;

use common\models\base\Block as BaseBlock;
use Yii;

class Block extends BaseBlock
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_NO = 0;
    const RECORD_DELETED_YES = 1;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            \components\behaviors\GuidBehavior::className()
        ];
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

        if (isset($params['code'])) {
            $modelAQ->andWhere($tableName . '.code = :code', [':code' => $params['code']]);
        }
        
        if (isset($params['stateCode'])) {
            $modelAQ->andWhere($tableName . '.state_code = :stateCode', [':stateCode' => $params['stateCode']]);
        }
        
        if (isset($params['districtCode'])) {
            $modelAQ->andWhere($tableName . '.district_code = :districtCode', [':districtCode' => $params['districtCode']]);
        }

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid = :guid', [':guid' => $params['guid']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['code' => $code], $params));
    }
    
    public static function findByDistrictCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['districtCode' => $code], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }

    public static function findBlockModel($guid)
    {
        if (($model = self::findByParams(['guid' => $guid, 'resultFormat' => caching\ModelCache::RETURN_TYPE_OBJECT])) !== null) {
            return $model;
        }
        else {
            throw new \Exception('Oops! We could not get data form data model. Here\'s the message we got:<br/><br/> Requested parameter is not valid.');
        }
    }

    public static function getBlockList($districtCode = NULL)
    {
        $blockList = $params = [];
        $params['returnAll'] = true;
        if ($districtCode) {
            $params['districtCode'] = $districtCode;
        }

        $blocks = self::findByParams($params);
        foreach ($blocks as $block):
            $blockList[$block['code']] = $block['name'];
        endforeach;

        return $blockList;
    }

}
