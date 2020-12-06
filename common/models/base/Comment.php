<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $grievance_id
 * @property int $grievance_log_id
 * @property string $comment
 * @property int $created_by
 * @property int $created_at
 *
 * @property User $createdBy
 * @property GrievanceLog $grievanceLog
 * @property Grievance $grievance
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id'], 'required'],
            [['grievance_id', 'grievance_log_id', 'created_by', 'created_at'], 'integer'],
            [['comment'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['grievance_log_id'], 'exist', 'skipOnError' => true, 'targetClass' => GrievanceLog::className(), 'targetAttribute' => ['grievance_log_id' => 'id']],
            [['grievance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grievance::className(), 'targetAttribute' => ['grievance_id' => 'id']],
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
            'grievance_log_id' => 'Grievance Log ID',
            'comment' => 'Comment',
            'created_by' => 'Created By',
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
    public function getGrievanceLog()
    {
        return $this->hasOne(GrievanceLog::className(), ['id' => 'grievance_log_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievance()
    {
        return $this->hasOne(Grievance::className(), ['id' => 'grievance_id']);
    }
}
