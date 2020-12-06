<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance_assign_log".
 *
 * @property int $id
 * @property int $grievance_id
 * @property int $prv_dh_id
 * @property int $new_dh_id
 * @property int $created_on
 * @property int $created_by
 *
 * @property User $createdBy
 * @property Grievance $grievance
 * @property User $newDh
 * @property User $prvDh
 */
class GrievanceAssignLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance_assign_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grievance_id', 'prv_dh_id', 'new_dh_id'], 'required'],
            [['grievance_id', 'prv_dh_id', 'new_dh_id', 'created_on', 'created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['grievance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grievance::className(), 'targetAttribute' => ['grievance_id' => 'id']],
            [['new_dh_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['new_dh_id' => 'id']],
            [['prv_dh_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['prv_dh_id' => 'id']],
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
            'prv_dh_id' => 'Prv Dh ID',
            'new_dh_id' => 'New Dh ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewDh()
    {
        return $this->hasOne(User::className(), ['id' => 'new_dh_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrvDh()
    {
        return $this->hasOne(User::className(), ['id' => 'prv_dh_id']);
    }
}
