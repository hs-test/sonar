<?php

namespace common\models;

use common\models\base\District as BaseDistrict;
use Yii;

class District extends BaseDistrict
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_NO = 0;
    const RECORD_DELETED_YES = 1;

    public $merchants;

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
        
        if (isset($params['inDistrictCode']) && !empty($params['inDistrictCode'])) {
            $modelAQ->andWhere(['IN', 'district.code', $params['inDistrictCode']]);
        }

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid = :guid', [':guid' => $params['guid']]);
        }
        
        if (isset($params['joinSurvey'])) {
            $modelAQ->leftJoin('survey', 'survey.district_code = district.code');
        }
        
        if (isset($params['joinVleFacilitation'])) {
            $modelAQ->leftJoin('vle_facilitation', 'vle_facilitation.district_code = district.code');
        }
        
        if (isset($params['joinVleHealthKitRegistration'])) {
            $modelAQ->leftJoin('vle_health_kit_registration', 'vle_health_kit_registration.district_code = district.code');
        }
        
        if (isset($params['joinRegistration']) && isset($params['registrationType'])) {
            $modelAQ->leftJoin('registration', 'registration.district_code = district.code  AND registration.type = "'.$params['registrationType'].'"');
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['code' => $code], $params));
    }
    
    public static function findByStateCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['stateCode' => $code], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }

    public static function findDistrictModel($guid)
    {
        if (($model = self::findByParams(['code' => $guid, 'resultFormat' => caching\ModelCache::RETURN_TYPE_OBJECT])) !== null) {
            return $model;
        }
        else {
            throw new \Exception('Oops! We could not get data form data model. Here\'s the message we got:<br/><br/> Requested parameter is not valid.');
        }
    }

    public static function getDistrictList($stateCode = NULL, $params =[])
    {
        $districtList =[];
        $params['returnAll'] = true;
        if ($stateCode) {
            $params['stateCode'] = $stateCode;
        }
        $params['orderBy'] = ['name' => SORT_ASC];
        $districts = self::findByParams($params);
        
        foreach ($districts as $district):
            $districtList[$district['code']] = strtoupper($district['name']);
        endforeach;

        return $districtList;
    }
    
    public static function getDistrictCovered($stateCode, $type)
    {
        $params = [
            'stateCode' => $stateCode,
            'groupBy' => 'district.code',
            'orderBy' => 'district.name',
            'forceCache' => TRUE,
            'returnAll' => TRUE
        ];
        
        if($type == 'survey') {
            $params['selectCols'] = 'district.code, district.name, COUNT(survey.id) as total';
            $params['joinSurvey'] = 'leftJoin';
        }
        elseif($type == 'facilitation') {
            $params['selectCols'] = 'district.code, district.name, COUNT(vle_facilitation.id) as total';
            $params['joinVleFacilitation'] = 'leftJoin';
        }
        elseif($type == 'health_kit') {
            $params['selectCols'] = 'district.code, district.name, COUNT(vle_health_kit_registration.id) as total';
            $params['joinVleHealthKitRegistration'] = 'leftJoin';
        }
        else {
            $params['selectCols'] = 'district.code, district.name, COUNT(registration.id) as total';
            $params['joinRegistration'] = 'leftJoin';
            $params['registrationType'] = $type;
        }
        
        return self::findByParams($params);
    }
}
