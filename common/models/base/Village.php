<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "village".
 *
 * @property int $code
 * @property string $guid
 * @property int $state_code
 * @property int $district_code
 * @property int $block_code
 * @property int $panchayat_code
 * @property string $name
 * @property int $status
 * @property int $is_deleted
 * @property int $created_by
 * @property int $updated_by
 * @property int $updated_at
 * @property int $created_at
 *
 * @property Grievance[] $grievances
 * @property Block $blockCode
 * @property User $createdBy
 * @property District $districtCode
 * @property Panchayat $panchayatCode
 * @property State $stateCode
 * @property User $updatedBy
 */
class Village extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'village';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'guid', 'state_code', 'district_code', 'name'], 'required'],
            [['code', 'state_code', 'district_code', 'block_code', 'panchayat_code', 'status', 'is_deleted', 'created_by', 'updated_by', 'updated_at', 'created_at'], 'integer'],
            [['guid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['guid'], 'unique'],
            [['state_code', 'district_code', 'block_code', 'panchayat_code', 'code'], 'unique', 'targetAttribute' => ['state_code', 'district_code', 'block_code', 'panchayat_code', 'code']],
            [['block_code'], 'exist', 'skipOnError' => true, 'targetClass' => Block::className(), 'targetAttribute' => ['block_code' => 'code']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['district_code'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_code' => 'code']],
            [['panchayat_code'], 'exist', 'skipOnError' => true, 'targetClass' => Panchayat::className(), 'targetAttribute' => ['panchayat_code' => 'code']],
            [['state_code'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_code' => 'code']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'state_code' => Yii::t('app', 'State Code'),
            'district_code' => Yii::t('app', 'District Code'),
            'block_code' => Yii::t('app', 'Block Code'),
            'panchayat_code' => Yii::t('app', 'Panchayat Code'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['village_code' => 'code']);
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
    public function getPanchayatCode()
    {
        return $this->hasOne(Panchayat::className(), ['code' => 'panchayat_code']);
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
}
