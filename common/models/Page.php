<?php

namespace common\models;

use common\models\base\Page as BasePage;

/**
 * Description of Page
 *
 * @author Amardeep Singh
 */
class Page extends BasePage {
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => [
                        'created_at',
                        'updated_at'
                    ],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ]
            ],
            \components\behaviors\GuidBehavior::className()
        ];
    }

    /*
     * Custom Rules apart from Base Class
     * 
     */

    public function rules() {
        $rules = parent::rules();
        return $rules;
    }

    public function beforeValidate() {
        parent::beforeValidate();

        // followin line is just for testing
        $this->display_order = 1;

        return TRUE;
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        

        if ($this->getIsNewRecord()) {
            
            $slug = \yii\helpers\Inflector::slug($this->title, '-');
            
            $slugCount = self::findBySlug($slug,['count'=>'count']);
            
            if($slugCount){
                $slug .= '-'.++$slugCount;
            }
            
            $this->slug = $slug;
            $this->created_by = \Yii::$app->user->id;
        } else {
            $this->updated_by = \Yii::$app->user->id;
        }

        return true;
    }

    private static function findByParams($params = []) {
        

        $query = self::find();
        $table = self::tableName();

        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $query->select($params['selectCols']);
        } else {
            $query->select($table . '.*');
        }

        if (isset($params['guid'])) {
            $query->andWhere($table . '.guid =:guid', [':guid' => $params['guid']]);
        }

        if (isset($params['idNotEqualsTo']) && (int) $params['idNotEqualsTo'] > 0) {
            $query->andWhere($table . '.id != :idNotEqualsTo', [':idNotEqualsTo' => (int) $params['idNotEqualsTo']]);
        }

        if (isset($params['slug'])) {
            $query->andWhere($table . '.slug =:slug ', [':slug' => $params['slug']]);
        }
        
        if (isset($params['status'])) {
            $query->andWhere($table . '.status =:status ', [':status' => $params['status']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($query, $params);
    }

    public static function findAllPages($params = []) {
        return self::findByParams();
    }

    public static function findByGuid($guid, $params = []) {

        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }

    public static function findBySlug($slug, $params = []) {

        return self::findByParams(\yii\helpers\ArrayHelper::merge(['slug' => $slug], $params));
    }

    public static function getPageDropdown($params = []) {
        $queryParams = [
            'selectCols' => [
                'page.id', 'page.title'
            ],
            'resultCount' => 'all',
        ];

        $pageModel = self::findByParams(\yii\helpers\ArrayHelper::merge($queryParams, $params));
        return \yii\helpers\ArrayHelper::map($pageModel, 'id', 'title');
    }

}
