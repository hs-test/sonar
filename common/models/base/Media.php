<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string $guid
 * @property string $media_type
 * @property string $filename
 * @property string $filepath
 * @property string $cdn_path
 * @property int $created_by
 * @property int $created_on
 *
 * @property GrievanceStat[] $grievanceStats
 * @property User $createdBy
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'media_type'], 'required'],
            [['created_by', 'created_on'], 'integer'],
            [['guid'], 'string', 'max' => 40],
            [['media_type'], 'string', 'max' => 30],
            [['filename', 'filepath', 'cdn_path'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'media_type' => 'Media Type',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'cdn_path' => 'Cdn Path',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceStats()
    {
        return $this->hasMany(GrievanceStat::className(), ['media_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
