<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

use Yii;
use common\models\base\Discom as BaseDiscom;

/**
 * Description of Discom
 *
 * @author Pawan
 */
class Discom extends BaseDiscom
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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

        if (isset($params['id']) && !empty($params['id'])) {
            $modelAQ->andWhere($tableName . '.id = :id', [':id' => $params['id']]);
        }

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid = :guid', [':guid' => $params['guid']]);
        }

        if (isset($params['discomCode'])) {
            $modelAQ->andWhere($tableName . '.discom_code = :discomCode', [':discomCode' => $params['discomCode']]);
        }

        // join with user
        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'user.discom_id = discom.id');

            // join with user
            if (isset($params['joinWithUserLocation']) && in_array($params['joinWithUserLocation'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
                $modelAQ->{$params['joinWithUserLocation']}('user_location', 'user_location.user_id = user.id');
            }

            if (isset($params['stateCode']) && !empty($params['stateCode'])) {
                //$modelAQ->andWhere(['IN', 'user_location.state_code', $params['inStateCode']]);
                $modelAQ->andWhere('user_location.state_code = :stateCode', [':stateCode' => $params['stateCode']]);
            }
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }
    
    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }

    public static function findByDiscomCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['discomCode' => $code], $params));
    }
    
    public static function getDiscomList($discomCode = null , $params =[])
    {
        $list = [];
        $params['returnAll'] = true;
        if ($discomCode !== null) {
            $params['discomCode'] = $discomCode;
        }
        if (isset($params['discomid']) && $params['discomid'] > 0) {
            $params['id'] = $params['discomid'];
        }
        $params['orderBy']=['discom_code' => SORT_ASC];

        $discoms = self::findByParams($params);
        foreach ($discoms as $discom):
            $list[$discom['id']] = strtoupper($discom['discom_code']);
        endforeach;

        return $list;
    }
    
    public static function findDiscomModel($params)
    {
        return self::findByParams($params);
    }

}
