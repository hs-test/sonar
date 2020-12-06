<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "panchayat".
 *
 * @property int $code
 * @property string $name
 * @property string $guid
 * @property int $state_code
 * @property int $district_code
 * @property int $block_code
 * @property int $status
 * @property int $is_deleted
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Block $blockCode
 * @property User $createdBy
 * @property District $districtCode
 * @property State $stateCode
 * @property User $updatedBy
 * @property Village[] $villages
 * @property Vle[] $vles
 */
class Panchayat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'panchayat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'state_code', 'district_code', 'block_code'], 'required'],
            [['code', 'state_code', 'district_code', 'block_code', 'status', 'is_deleted', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['guid'], 'string', 'max' => 40],
            [['code'], 'unique'],
            [['guid'], 'unique'],
            [['block_code'], 'exist', 'skipOnError' => true, 'targetClass' => Block::className(), 'targetAttribute' => ['block_code' => 'code']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['district_code'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_code' => 'code']],
            [['state_code'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_code' => 'code']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'guid' => Yii::t('app', 'Guid'),
            'state_code' => Yii::t('app', 'State Code'),
            'district_code' => Yii::t('app', 'District Code'),
            'block_code' => Yii::t('app', 'Block Code'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockCode()
    {
        return $this->hasOne(Block::className(), ['code' => 'block_code']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['panchayat_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVles()
    {
        return $this->hasMany(Vle::className(), ['panchayat_code' => 'code']);
    }
}
