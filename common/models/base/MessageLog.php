<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "message_log".
 *
 * @property int $id
 * @property string $guid
 * @property int $grievance_id
 * @property int $discom_nodal_id
 * @property int $send_type
 * @property string $mobile_no
 * @property string $message
 * @property string $date
 * @property int $is_msg_sent
 * @property string $logs
 * @property int $created_by
 * @property int $created_at
 *
 * @property User $discomNodal
 * @property Grievance $grievance
 * @property User $createdBy
 */
class MessageLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid'], 'required'],
            [['grievance_id', 'discom_nodal_id', 'send_type', 'is_msg_sent', 'created_by', 'created_at'], 'integer'],
            [['message', 'logs'], 'string'],
            [['date'], 'safe'],
            [['guid'], 'string', 'max' => 36],
            [['mobile_no'], 'string', 'max' => 10],
            [['discom_nodal_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['discom_nodal_id' => 'id']],
            [['grievance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grievance::className(), 'targetAttribute' => ['grievance_id' => 'id']],
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
            'grievance_id' => 'Grievance ID',
            'discom_nodal_id' => 'Discom Nodal ID',
            'send_type' => 'Send Type',
            'mobile_no' => 'Mobile No',
            'message' => 'Message',
            'date' => 'Date',
            'is_msg_sent' => 'Is Msg Sent',
            'logs' => 'Logs',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscomNodal()
    {
        return $this->hasOne(User::className(), ['id' => 'discom_nodal_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
