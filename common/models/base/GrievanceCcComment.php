<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_cc_comment".
 *
 * @property int $id
 * @property int $grievance_id
 * @property string $comment
 * @property int $created_on
 * @property int $created_by
 *
 * @property User $createdBy
 * @property Grievance $grievance
 */
class GrievanceCcComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_cc_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'comment'], 'required'],
            [['grievance_id', 'created_on', 'created_by'], 'integer'],
            [['comment'], 'string'],
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
            'comment' => 'Comment',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
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
