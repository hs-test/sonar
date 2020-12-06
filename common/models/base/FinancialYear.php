<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "financial_year".
 *
 * @property int $code
 * @property string $guid
 * @property string $name
 * @property string $from_date
 * @property string $to_date
 * @property int $is_active
 * @property int $is_delete
 * @property int $created_on
 * @property int $created_by
 * @property int $modified_on
 * @property int $modified_by
 *
 * @property User $createdBy
 * @property User $modifiedBy
 * @property Grievance[] $grievances
 */
class FinancialYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financial_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'guid', 'name', 'from_date', 'to_date'], 'required'],
            [['code', 'is_active', 'is_delete', 'created_on', 'created_by', 'modified_on', 'modified_by'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            ['from_date','validateDates'],
            [['guid'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 10],
            [['guid'], 'unique'],
            [['name'], 'unique'],
            [['code'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
        ];
    }
    
    public function validateDates(){
    if(strtotime($this->to_date) < strtotime($this->from_date)){
        $this->addError('from_date','Please give correct Start and End dates');
        $this->addError('to_date','Please give correct Start and End dates');
    }
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'guid' => 'Guid',
            'name' => 'Name',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'is_active' => 'Is Active',
            'is_delete' => 'Is Delete',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
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
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['financial_year' => 'code']);
    }
}
