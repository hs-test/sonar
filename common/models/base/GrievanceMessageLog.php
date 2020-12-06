<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_message_log".
 *
 * @property int $id
 * @property int $grievance_id
 * @property string $subject
 * @property int $message_id
 * @property string $message
 * @property int $created_by
 * @property int $created_on
 *
 * @property User $createdBy
 * @property Grievance $grievance
 * @property MessageTemplate $message0
 * @property GrievanceMessageLogDetail[] $grievanceMessageLogDetails
 */
class GrievanceMessageLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_message_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'subject', 'message_id'], 'required'],
            [['grievance_id', 'message_id', 'created_by', 'created_on'], 'integer'],
            [['message'], 'string'],
            [['subject'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['grievance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grievance::className(), 'targetAttribute' => ['grievance_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageTemplate::className(), 'targetAttribute' => ['message_id' => 'id']],
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
            'subject' => 'Subject',
            'message_id' => 'Message ID',
            'message' => 'Message',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
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
    public function getGrievance()
    {
        return $this->hasOne(Grievance::className(), ['id' => 'grievance_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage0()
    {
        return $this->hasOne(MessageTemplate::className(), ['id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceMessageLogDetails()
    {
        return $this->hasMany(GrievanceMessageLogDetail::className(), ['grievance_message_log_id' => 'id']);
    }
}
