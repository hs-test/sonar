<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vle".
 *
 * @property int $id
 * @property string $guid
 * @property int $parent_id
 * @property int $user_id
 * @property int $state_id
 * @property int $district_id
 * @property int $block_id
 * @property int $panchayat_id
 * @property int $village_id
 * @property string $omtid
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $is_facilitation_centre_assigned
 * @property string $facilitation_centre_id
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property Block $block
 * @property District $district
 * @property Panchayat $panchayat
 * @property State $state
 * @property User $user
 * @property Village $village
 */
class Vle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'state_id', 'district_id', 'block_id', 'panchayat_id', 'village_id', 'phone', 'is_facilitation_centre_assigned', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'phone', 'email'], 'required'],
            [['guid', 'omtid', 'name'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 100],
            [['facilitation_centre_id'], 'string', 'max' => 20],
            [['omtid'], 'unique'],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::className(), 'targetAttribute' => ['block_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['panchayat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Panchayat::className(), 'targetAttribute' => ['panchayat_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'parent_id' => 'Parent ID',
            'user_id' => 'User ID',
            'state_id' => 'State ID',
            'district_id' => 'District ID',
            'block_id' => 'Block ID',
            'panchayat_id' => 'Panchayat ID',
            'village_id' => 'Village ID',
            'omtid' => 'Omtid',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'is_facilitation_centre_assigned' => 'Is Facilitation Centre Assigned',
            'facilitation_centre_id' => 'Facilitation Centre ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanchayat()
    {
        return $this->hasOne(Panchayat::className(), ['id' => 'panchayat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}
