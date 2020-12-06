<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_scan_review".
 *
 * @property int $id
 * @property int $grievance_id
 * @property string $type
 * @property string $date
 * @property string $reason
 * @property string|null $comment
 * @property int|null $created_by
 * @property int|null $created_on
 *
 * @property User $createdBy
 * @property Grievance $grievance
 */
class GrievanceScanReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_scan_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'type', 'date', 'reason'], 'required'],
            [['grievance_id', 'created_by', 'created_on'], 'integer'],
            [['type', 'reason', 'comment'], 'string'],
            [['date'], 'safe'],
            [['grievance_id', 'type'], 'unique', 'targetAttribute' => ['grievance_id', 'type']],
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
            'type' => 'Type',
            'date' => 'Date',
            'reason' => 'Reason',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Grievance]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievance()
    {
        return $this->hasOne(Grievance::className(), ['id' => 'grievance_id']);
    }
}
