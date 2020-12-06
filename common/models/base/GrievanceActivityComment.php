<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_activity_comment".
 *
 * @property int $id
 * @property int $grievance_activity_id
 * @property string $comment
 * @property int $created_by
 * @property int $created_on
 *
 * @property GrievanceActivityLog $grievanceActivity
 * @property User $createdBy
 */
class GrievanceActivityComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_activity_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_activity_id', 'comment'], 'required'],
            [['grievance_activity_id', 'created_by', 'created_on'], 'integer'],
            [['comment'], 'string'],
            [['grievance_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => GrievanceActivityLog::className(), 'targetAttribute' => ['grievance_activity_id' => 'id']],
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
            'grievance_activity_id' => 'Grievance Activity ID',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceActivity()
    {
        return $this->hasOne(GrievanceActivityLog::className(), ['id' => 'grievance_activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
