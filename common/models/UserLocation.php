<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

use Yii;
use common\models\base\UserLocation as BaseUserLocation;

/**
 * Description of UserLocation
 *
 * @author Pawan
 */
class UserLocation extends BaseUserLocation
{

    public static function primaryKey()
    {
        return ['user_id', 'state_code','district_code'];
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

        if (isset($params['userId'])) {
            $modelAQ->andWhere($tableName . '.user_id =:userId', [':userId' => $params['userId']]);
        }

        if (isset($params['stateCode'])) {
            $modelAQ->andWhere($tableName . '.state_code =:stateCode', [':stateCode' => $params['stateCode']]);
        }

        if (isset($params['districtCode'])) {
            $modelAQ->andWhere($tableName . '.district_code =:districtCode', [':districtCode' => $params['districtCode']]);
        }
        
         if (isset($params['joinUser'])) {
            $modelAQ->{$params['joinUser']}('user', 'user.id = user_location.user_id');
            if (isset($params['roleId'])) {
                $modelAQ->andWhere('user.role_id =:roleId', [':roleId' => $params['roleId']]);
            }
        }
        
        if (isset($params['joinState'])) {
            $modelAQ->{$params['joinState']}('state', 'state.code = user_location.state_code');
        }
        
        if (isset($params['joinDistrict'])) {
            $modelAQ->{$params['joinDistrict']}('district', 'district.code = user_location.district_code');
        }
        
        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }
    
    public static function findByUserId($userId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['userId' => $userId], $params));
    }

    public static function findByStateCode($stateCode, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['stateCode' => $stateCode], $params));
    }

    public static function findByDistrictCode($districtCode, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['districtCode' => $districtCode], $params));
    }
    
    public static function validateStateUser($stateCode, $roleId)
    {
        $params = [
            'stateCode' => $stateCode,
            'joinUser' => 'innerJoin',
            'roleId' => $roleId,
            'existOnly' => true
        ];

        return self::findByParams($params);
    }
    
    public static function validateStateDistrictUser($stateCode, $districtCode, $roleId)
    {
        $params = [
            'stateCode' => $stateCode,
            'districtCode' => $districtCode,
            'joinUser' => 'innerJoin',
            'roleId' => $roleId,
            'existOnly' => true
        ];

        return self::findByParams($params);
    }
    
    public static function getStateDistrictUser($stateCode, $districtCode, $roleId)
    {
        $params = [
            'stateCode' => $stateCode,
            'districtCode' => $districtCode,
            'joinUser' => 'innerJoin',
            'roleId' => $roleId
        ];

        return self::findByParams($params);
    }
    
    public function saveLocation($data)
    {
        try {
            $model = new UserLocation;
            $model->isNewRecord = true;
            $model->setAttributes($data);
            if ($model->save()) {
                return $model->id;
            }
        }
        catch (Exception $ex) {
            throw $ex;
        }
        return false;
    }

}
