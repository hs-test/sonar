<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property int $code
 * @property string $guid
 * @property string $name
 * @property string $search_name
 * @property int $status
 * @property int $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Block[] $blocks
 * @property District[] $districts
 * @property Grievance[] $grievances
 * @property Panchayat[] $panchayats
 * @property UserLocation[] $userLocations
 * @property Village[] $villages
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'guid', 'name', 'search_name'], 'required'],
            [['code', 'status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['guid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 40],
            [['search_name'], 'string', 'max' => 2],
            [['code'], 'unique'],
            [['name'], 'unique'],
            [['guid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'guid' => Yii::t('app', 'Guid'),
            'name' => Yii::t('app', 'Name'),
            'search_name' => Yii::t('app', 'Search Name'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['state_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['state_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['state_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanchayats()
    {
        return $this->hasMany(Panchayat::className(), ['state_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLocations()
    {
        return $this->hasMany(UserLocation::className(), ['state_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['state_code' => 'code']);
    }
}
