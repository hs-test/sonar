<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $guid
 * @property string $mobile
 * @property string $email
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property Grievance[] $grievances
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'mobile'], 'required'],
            [['mobile', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['guid'], 'string', 'max' => 36],
            [['email'], 'string', 'max' => 50],
            [['guid'], 'unique'],
            [['mobile'], 'unique'],
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
            'mobile' => 'Mobile',
            'email' => 'Email',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['customer_id' => 'id']);
    }
}
