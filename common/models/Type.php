<?php

namespace common\models;

use common\models\base\Type as BaseType;

/**
 * Description of Type
 *
 * @author Ravi Sikarwar
 */
class Type extends BaseType
{

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
            \components\behaviors\GuidBehavior::className()
        ];
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }
    
    public static function findByParentId($parentId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['parent_id' => $parentId], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
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

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid =:guid', [':guid' => $params['guid']]);
        }

        if (isset($params['parentNull']) && $params['parentNull']) {
            $modelAQ->andWhere($tableName . '.parent_id IS NULL');
        }


        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function getTypeList($params = [])
    {
        $params = [
            'selectCols' => ['type.id', 'type.title'],
            'resultFormat' => 'array',
            'resultCount' => 'all',
        ];
        $params['orderBy'] = ['name' => SORT_ASC];
        if (isset($params['parentNull'])) {
            $params['parentNull'] = TRUE;
        }

        $model = self::findByParams($params);

        $typeList = [];
        if (!empty($model)) {

            foreach ($model as $type) {

                $typeList[$type['id']] = strtoupper($type['title']);
            }
        }
        return $typeList;
    }
    
    public static function getParentChildTypeList()
    {
        $options = [];

        $parents = self::find()->where("parent_id IS NULL")->all();

        foreach ($parents as $id => $p) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id" => $p->id])->all();
            $child_options = [];
            foreach ($children as $child) {
                $child_options[$child->id] = $child->title;
            }
            $options[$p->title] = $child_options;
        }
        return $options;
    }
    
    public static function typeListDropDown()
    {
        $options = [];

        $typeModel = self::find()->where('status=:status', [':status' => caching\ModelCache::RECORD_IS_ACTIVE_YES])->asArray()->all();
        if (isset($typeModel) && !empty($typeModel)) {

            foreach ($typeModel as $type) {
                $options[$type['id']] = strtoupper($type['title']);
            }
        }

        return $options;
    }

    public static function buildTypeDropdown()
    {
        $dropdown = [];
        $rootType = self::find()->where("parent_id IS NULL")->all();
        foreach ($rootType as $id => $type) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id" => $type->id])->all();
            if (!empty($children)) {
                foreach ($children as $child) {
                    $dropdown[$type->title][$child->id] = $child->title;
                }
            }
            else {
                $dropdown[$type->id] = $type->title;
            }
        }
        return $dropdown;
    }

}