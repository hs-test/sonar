<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $guid
 * @property string $name
 * @property string $cin_no
 * @property string $depository
 * @property int $is_active
 * @property int $is_delete
 * @property int $created_by
 * @property int $created_on
 * @property int $modified_on
 * @property int $modified_by
 *
 * @property User $createdBy
 * @property CompanyDetail[] $companyDetails
 * @property Grievance[] $grievances
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'name', 'cin_no'], 'required'],
            [['depository'], 'string'],
            [['is_active', 'is_delete', 'created_by', 'created_on', 'modified_on', 'modified_by'], 'integer'],
            [['guid'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 100],
            [['cin_no'], 'string', 'max' => 25],
            [['cin_no'], 'unique'],
            [['guid'], 'unique'],
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
            'name' => 'Name',
            'cin_no' => 'Cin No',
            'depository' => 'Depository',
            'is_active' => 'Is Active',
            'is_delete' => 'Is Delete',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
            'modified_by' => 'Modified By',
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
    public function getCompanyDetails()
    {
        return $this->hasMany(CompanyDetail::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['company_id' => 'id']);
    }
}
