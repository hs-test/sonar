<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_log".
 *
 * @property int $id
 * @property int $grievance_id
 * @property int $media_id
 * @property string $document_type
 * @property int $application_status
 * @property int $eligibility_status
 * @property int $created_by
 * @property int $created_at
 *
 * @property Comment[] $comments
 * @property User $createdBy
 * @property Grievance $grievance
 * @property Media $media
 */
class GrievanceLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'application_status', 'eligibility_status'], 'required'],
            [['grievance_id', 'media_id', 'application_status', 'eligibility_status', 'created_by', 'created_at'], 'integer'],
            [['document_type'], 'string', 'max' => 30],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['grievance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grievance::className(), 'targetAttribute' => ['grievance_id' => 'id']],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grievance_id' => 'Grievance ID',
            'media_id' => 'Media ID',
            'document_type' => 'Document Type',
            'application_status' => 'Application Status',
            'eligibility_status' => 'Eligibility Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['grievance_log_id' => 'id']);
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
    public function getGrievance()
    {
        return $this->hasOne(Grievance::className(), ['id' => 'grievance_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
