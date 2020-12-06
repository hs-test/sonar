<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user_location".
 *
 * @property int $id
 * @property int $user_id
 * @property int $state_code
 * @property int $district_code
 *
 * @property District $districtCode
 * @property State $stateCode
 * @property User $user
 */
class UserLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'state_code'], 'required'],
            [['user_id', 'state_code', 'district_code'], 'integer'],
            [['user_id', 'state_code', 'district_code'], 'unique', 'targetAttribute' => ['user_id', 'state_code', 'district_code']],
            [['district_code'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_code' => 'code']],
            [['state_code'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_code' => 'code']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'state_code' => 'State Code',
            'district_code' => 'District Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrictCode()
    {
        return $this->hasOne(District::className(), ['code' => 'district_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStateCode()
    {
        return $this->hasOne(State::className(), ['code' => 'state_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
