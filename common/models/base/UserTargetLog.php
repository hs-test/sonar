<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user_target_log".
 *
 * @property int $user_id
 * @property int $month
 * @property int $year
 * @property string $date
 * @property int $allocated
 * @property int $created_on
 *
 * @property User $user
 */
class UserTargetLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_target_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'month', 'year', 'date', 'allocated'], 'required'],
            [['user_id', 'month', 'year', 'allocated', 'created_on'], 'integer'],
            [['date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'month' => 'Month',
            'year' => 'Year',
            'date' => 'Date',
            'allocated' => 'Allocated',
            'created_on' => 'Created On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
