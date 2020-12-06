<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "list_type".
 *
 * @property int $id
 * @property string $guid
 * @property string $category
 * @property string $title
 * @property int $display_order
 * @property string $description
 * @property int $is_active
 * @property int $is_delete
 * @property int $created_by
 * @property int $created_on
 * @property int $modified_by
 * @property int $modified_on
 *
 * @property User $createdBy
 * @property User $modifiedBy
 */
class ListType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'list_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'category', 'title', 'description'], 'required'],
            [['display_order', 'is_active', 'is_delete', 'created_by', 'created_on', 'modified_by', 'modified_on'], 'integer'],
            [['guid'], 'string', 'max' => 40],
            [['category'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 250],
            [['guid'], 'unique'],
            [['title'], 'unique'],
            [['description'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'category' => 'Category',
            'title' => 'Title',
            'display_order' => 'Display Order',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_delete' => 'Is Delete',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }
}
