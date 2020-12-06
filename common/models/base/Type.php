<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "type".
 *
 * @property int $id
 * @property string $title
 * @property string $guid
 * @property int $parent_id
 * @property int $created_at
 *
 * @property Type $parent
 * @property Type[] $types
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'guid'], 'required'],
            [['parent_id', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['guid'], 'string', 'max' => 36],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'guid' => 'Guid',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Type::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['parent_id' => 'id']);
    }
}
