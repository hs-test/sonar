<?php

namespace common\models;

use common\models\base\ListType as BaseListType;
use Yii;

class ListType extends BaseListType
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_YES = 1;
    const RECORD_DELETED_NO = 0;
    
    //const TYPE_DISCREPANCY = 'DISCREPANCY';
    const TYPE_REJECTION = 'REJECTION';
    const TYPE_CC_COMMENTS = 'COMMENTS';
    const TYPE_KYC = 'KYC';
    const TYPE_FORM = 'FORM';
    const TYPE_ENTITLEMENT = 'ENTITLEMENT'; //PROOF OF ENTITLEMENT';
    const TYPE_TRANSMISSION = 'TRANSMISSION';
    const TYPE_COMPANY_RELATED_DISCREPANCIES = 'COMPANY_DISCREPANCIES';
    const TYPE_SCAN_REVIEW = 'SCAN_REVIEWS';

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
                'attributes' => ['title','description']
            ],
        ];
    }
    
    public static function findByParams($params = [])
    {
        $modelAQ = static::find();
        $table = self::tableName();
        
        //Table columns to return in results, string or array
        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select($table . '.*');
        }

        // integer only
        if (isset($params['id'])) {
            $modelAQ->andWhere($table . '.id = :id', [':id' => (int) $params['id']]);
        }


        if (isset($params['category'])) {
            $modelAQ->andWhere($table . '.category = :category', [':category' => $params['category']]);
        }

        // string only
        if (isset($params['guid'])) {
            $modelAQ->andWhere($table . '.guid = :guid', [':guid' => $params['guid']]);
        }

        if (isset($params['status'])) {
            $modelAQ->andWhere($table . '.is_active = :status', [':status' => $params['status']]);
        }

        if (isset($params['isDeleted'])) {
            $modelAQ->andWhere($table . '.is_delete = :isDeleted', [':isDeleted' => $params['isDeleted']]);
        }
        
        if (isset($params['inOperator']) && !empty($params['inOperator']) && isset($params['inOperator']['column']) && !empty($params['inOperator']['column']) && isset($params['inOperator']['data']) && !empty($params['inOperator']['data'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
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

    public static function findByCategory($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['category' => $id], $params));
    }
    
    public static function getListTypeDropdown($params = [])
    {
        $queryParams = [
            'selectCols' => ['id', 'category', 'title', 'description'],
            'resultCount' => 'all',
            'status' => \common\models\caching\ModelCache::RECORD_IS_ACTIVE_YES,
            'isDeleted' => \common\models\caching\ModelCache::RECORD_IS_ACTIVE_NO,
            'orderBy' => ['list_type.title' => SORT_ASC]
        ];

        if (isset($params['categories']) && is_array($params['categories'])) {
            $queryParams['inOperator'] = [
                'column' => 'list_type.category',
                'data' => $params['categories']
            ];
        }
        else {

            $queryParams['category'] = $params['categories'];
        }

        $listModel = \common\models\ListType::findByParams(\yii\helpers\ArrayHelper::merge($queryParams, $params));
        $options = [];
        foreach ($listModel as $list) {

            if (isset($params['optionGroup']) && $params['optionGroup']) {
                $options[$list['category']][$list['description']] = $list['title'];
            }
            else {
                $options[$list['title']] = $list['title'];
            }
        }
        return $options;
    }

    public static function listDropDown()
    {
        return [
            self::TYPE_KYC => 'KYC',
            self::TYPE_FORM => 'FORM',
            self::TYPE_ENTITLEMENT => 'PROOF OF ENTITLEMENT',
            self::TYPE_TRANSMISSION => 'TRANSMISSION',
            self::TYPE_COMPANY_RELATED_DISCREPANCIES => 'COMPANY RELATED DISCREPANCIES',
            self::TYPE_REJECTION => 'REJECTION',
            self::TYPE_CC_COMMENTS => 'CALL CENTRE COMMENTS',
            self::TYPE_SCAN_REVIEW => 'SCAN & REVIEW',
        ];
    }

}
