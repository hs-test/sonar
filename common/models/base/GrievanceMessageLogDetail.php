<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_message_log_detail".
 *
 * @property int $id
 * @property int $grievance_message_log_id
 * @property string $type
 * @property string $receiver_name
 * @property int $status
 * @property int $created_by
 * @property int $created_on
 *
 * @property User $createdBy
 * @property GrievanceMessageLog $grievanceMessageLog
 */
class GrievanceMessageLogDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_message_log_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_message_log_id', 'type', 'receiver_name', 'status'], 'required'],
            [['grievance_message_log_id', 'status', 'created_by', 'created_on'], 'integer'],
            [['type'], 'string'],
            [['receiver_name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['grievance_message_log_id'], 'exist', 'skipOnError' => true, 'targetClass' => GrievanceMessageLog::className(), 'targetAttribute' => ['grievance_message_log_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grievance_message_log_id' => 'Grievance Message Log ID',
            'type' => 'Type',
            'receiver_name' => 'Receiver Name',
            'status' => 'Status',
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
    public function getGrievanceMessageLog()
    {
        return $this->hasOne(GrievanceMessageLog::className(), ['id' => 'grievance_message_log_id']);
    }
}
