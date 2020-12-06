<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $guid
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property int $media_id
 * @property string $keywords
 * @property string $external_link
 * @property int $parent_id
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $target
 * @property int $display_order
 * @property int $updated_by
 * @property int $status
 * @property int $created_by
 * @property int $updated_at
 * @property int $created_at
 *
 * @property User $createdBy
 * @property Media $media
 * @property User $updatedBy
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'title'], 'required'],
            [['content', 'meta_description', 'target'], 'string'],
            [['media_id', 'parent_id', 'display_order', 'updated_by', 'status', 'created_by', 'updated_at', 'created_at'], 'integer'],
            [['guid'], 'string', 'max' => 50],
            [['slug', 'title', 'keywords', 'external_link', 'meta_title', 'meta_keywords'], 'string', 'max' => 255],
            [['guid'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'slug' => 'Slug',
            'title' => 'Title',
            'content' => 'Content',
            'media_id' => 'Media ID',
            'keywords' => 'Keywords',
            'external_link' => 'External Link',
            'parent_id' => 'Parent ID',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'target' => 'Target',
            'display_order' => 'Display Order',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
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
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
