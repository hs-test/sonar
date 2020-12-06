<?php

namespace common\models;

use common\models\base\FinancialYear as BaseFinancialYear;
use components\behaviors\FileuploadBehavior;
use Yii;

class FinancialYear extends BaseFinancialYear
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_YES = 1;
    const RECORD_DELETED_NO = 0;
    /**
     * @inheritdoc
     */
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
        ];
    }
    
    
    public function beforeSave($insert)
    {
        $this->from_date = (isset($this->from_date) && !empty($this->from_date)) ? date('Y-m-d', strtotime($this->from_date)) : null;
        $this->to_date = (isset($this->to_date) && !empty($this->to_date)) ? date('Y-m-d', strtotime($this->to_date)) : null;
        

        return parent::beforeSave($insert);
    }
    
    public static function findByParams($params = [])
    {
        $modelAQ = static::find();
        
        //Table columns to return in results, string or array
        if(isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select('financial_year.*');
        }
        
        // integer only
        if(isset($params['code'])) {
            $modelAQ->andWhere('financial_year.code = :code', [':code' => (int)$params['code']]);
        }
        
        // string only
        if(isset($params['guid'])) {
            $modelAQ->andWhere('financial_year.guid = :guid', [':guid' => $params['guid']]);
        }
        
        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }   
    
    public static function findByCode($code, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['code' => $code], $params));
    }
    
    public static function getFinancialYearList($financialYearCode = NULL, $params = [])
    {
        $financialYearList = [];
        $params['returnAll'] = true;
        if ($financialYearCode) {
            $params['code'] = $financialYearCode;
        }
        $params['orderBy'] = ['name' => SORT_ASC];
        $financialYearModel = self::findByParams($params);

        foreach ($financialYearModel as $financialYear):
            $financialYearList[trim($financialYear['code'])] = trim($financialYear['name']);
        endforeach;

        return $financialYearList;
    }

}
