<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "company_detail".
 *
 * @property int $id
 * @property int $company_id
 * @property string $contact_person
 * @property string $contact_no
 * @property string $email
 * @property string $address
 * @property int $created_on
 *
 * @property Company $company
 */
class CompanyDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'created_on'], 'integer'],
            [['contact_person', 'email'], 'required'],
            [['contact_person'], 'string', 'max' => 75],
            [['contact_no'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 150],
            [['email'], 'unique'],
            [['contact_no'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'contact_person' => 'Contact Person',
            'contact_no' => 'Contact No',
            'email' => 'Email',
            'address' => 'Address',
            'created_on' => 'Created On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
