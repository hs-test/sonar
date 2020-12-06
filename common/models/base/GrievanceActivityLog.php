<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_activity_log".
 *
 * @property int $id
 * @property int $grievance_id
 * @property string $date
 * @property string $description
 * @property int $grievance_status
 * @property string $comments
 * @property string $additional_comment
 * @property int $is_msg_sent
 * @property int $created_by
 * @property int $created_on
 *
 * @property User $createdBy
 * @property Grievance $grievance
 */
class GrievanceActivityLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_activity_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'date', 'grievance_status'], 'required'],
            [['grievance_id', 'grievance_status', 'is_msg_sent', 'created_by', 'created_on'], 'integer'],
            [['date'], 'safe'],
            [['comments', 'additional_comment'], 'string'],
            [['description'], 'string', 'max' => 100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'date' => 'Date',
            'description' => 'Description',
            'grievance_status' => 'Grievance Status',
            'comments' => 'Comments',
            'additional_comment' => 'Additional Comment',
            'is_msg_sent' => 'Is Msg Sent',
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
}
