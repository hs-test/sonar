<?php

namespace common\models;

use common\models\base\State as BaseState;
use Yii;

class State extends BaseState
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
            $modelAQ->andWhere($tableName . '.code =:code', [':code' => $params['code']]);
        }

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid =:guid', [':guid' => $params['guid']]);
        }
        
        if (isset($params['inStateCode'])) {
            $modelAQ->andWhere(['IN', 'state.code', $params['inStateCode']]);
        }
        
        if (isset($params['joinSurvey'])) {
            $modelAQ->leftJoin('survey', 'survey.state_code = state.code');
        }
        
         if (isset($params['status'])) {
            $modelAQ->andWhere($tableName . '.status =:status', [':status' => $params['status']]);
        }
        
        if (isset($params['joinVleFacilitation'])) {
            $modelAQ->leftJoin('vle_facilitation', 'vle_facilitation.state_code = state.code');
        }
        
        if (isset($params['joinVleHealthKitRegistration'])) {
            $modelAQ->leftJoin('vle_health_kit_registration', 'vle_health_kit_registration.state_code = state.code');
        }
        
        if (isset($params['joinRegistration']) && isset($params['registrationType'])) {
            $modelAQ->leftJoin('registration', 'registration.state_code = state.code AND registration.type = "'.$params['registrationType'].'"');
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['code' => $code], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }
    
    public static function findStateModel($guid)
    {
        if (($model = self::findByParams(['guid' => $guid, 'resultFormat' => caching\ModelCache::RETURN_TYPE_OBJECT])) !== null) {
            return $model;
        }
        else {
            throw new \Exception('Oops! We could not get data form data model. Here\'s the message we got:<br/><br/> Requested parameter is not valid.');
        }
    }

    public static function getStateList($stateId = NULL, $import = FALSE, $params =[])
    {
        $stateList = [];
        $params['returnAll'] = true;
        $params['orderBy'] = 'state.name';
        if (!empty($stateId)) {
            $params['code'] = $stateId;
        }
        $params['orderBy'] = ['name' => SORT_ASC];
        $params['status'] = caching\ModelCache::RECORD_IS_ACTIVE_YES;

        $states = self::findByParams($params);
             
        if($import) {
            foreach ($states as $state):
                $stateName = str_replace(' ', '', strtolower($state['name']));
                $stateList[$stateName] = $state['code'];
            endforeach;
        }
        else {
            foreach ($states as $state):
                $stateList[$state['code']] = strtoupper($state['name']);
            endforeach;
        }

        return $stateList;
    }
    
    public static function getStatesCovered($type)
    {
        $params = [
            'groupBy' => 'state.code',
            'orderBy' => 'state.name',
            'forceCache' => TRUE,
            'returnAll' => TRUE
        ];
        
        if($type == 'survey') {
            $params['selectCols'] = 'state.code, state.name, COUNT(survey.id) as total';
            $params['joinSurvey'] = 'leftJoin';
        }
        elseif($type == 'facilitation') {
            $params['selectCols'] = 'state.code, state.name, COUNT(vle_facilitation.id) as total';
            $params['joinVleFacilitation'] = 'leftJoin';
        }
        elseif($type == 'health_kit') {
            $params['selectCols'] = 'state.code, state.name, COUNT(vle_health_kit_registration.id) as total';
            $params['joinVleHealthKitRegistration'] = 'leftJoin';
        }
        else {
            $params['selectCols'] = 'state.code, state.name, COUNT(registration.id) as total';
            $params['joinRegistration'] = 'leftJoin';
            $params['registrationType'] = $type;
        }
        
        return self::findByParams($params);
    }
}
