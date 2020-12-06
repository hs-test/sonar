<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property int $code
 * @property string $name
 * @property string $guid
 * @property int $state_code
 * @property int $status
 * @property int $is_deleted
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Block[] $blocks
 * @property User $createdBy
 * @property User $updatedBy
 * @property State $stateCode
 * @property Panchayat[] $panchayats
 * @property Village[] $villages
 * @property Vle[] $vles
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'state_code'], 'required'],
            [['code', 'state_code', 'status', 'is_deleted', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['guid'], 'string', 'max' => 40],
            [['code'], 'unique'],
            [['guid'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['state_code'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_code' => 'code']],
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
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['district_code' => 'code']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
    public function getPanchayats()
    {
        return $this->hasMany(Panchayat::className(), ['district_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['district_code' => 'code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVles()
    {
        return $this->hasMany(Vle::className(), ['district_code' => 'code']);
    }
}
