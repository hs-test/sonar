<?php

namespace common\models;

use common\models\base\Company as BaseCompany;
use components\behaviors\FileuploadBehavior;
use Yii;

class Company extends BaseCompany
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
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['name','cin_no']
            ],
        ];
    }

    public static function findByParams($params = [])
    {
        $modelAQ = static::find();

        //Table columns to return in results, string or array
        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select('company.*');
        }

        // integer only
        if (isset($params['id'])) {
            $modelAQ->andWhere('company.id = :id', [':id' => (int) $params['id']]);
        }
        // string only
        if (isset($params['guid'])) {
            $modelAQ->andWhere('company.guid = :guid', [':guid' => $params['guid']]);
        }
        
        if (isset($params['cin'])) {
            $modelAQ->andWhere('company.cin_no = :cin', [':cin' => $params['cin']]);
        }

        // join with company info
        if (isset($params['joinWithCompanyInfo']) && in_array($params['joinWithCompanyInfo'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithCompanyInfo']}('company_detail', 'company_detail.company_id = company.id');
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }   
    
    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }
    
    public static function findByCIN($cinNo, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['cin' => $cinNo], $params));
    }
    
    public static function getCompanyList($companyId = NULL, $params = [])
    {
        $companyList = [];
        $params['returnAll'] = true;
        if ($companyId) {
            $params['id'] = $companyId;
        }
        $params['orderBy'] = ['name' => SORT_ASC];
        $companies = self::findByParams($params);

        foreach ($companies as $company):
            $companyList[$company['id']] = (isset($params['returnCinNo'])) ? strtoupper(trim($company['cin_no'])) : strtoupper($company['name']);
        endforeach;

        return $companyList;
    }

}
