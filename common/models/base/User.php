<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $guid
 * @property int $role_id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property int $status
 * @property int $allowed_grievance
 * @property int $allocated_grievance
 * @property int $is_last_allocated
 * @property int $is_limit_achieved
 * @property int $created_on
 * @property int $created_by
 * @property int $updated_on
 * @property int $updated_by
 *
 * @property Company[] $companies
 * @property FinancialYear[] $financialYears
 * @property FinancialYear[] $financialYears0
 * @property Grievance[] $grievances
 * @property Grievance[] $grievances0
 * @property Grievance[] $grievances1
 * @property GrievanceActivityComment[] $grievanceActivityComments
 * @property GrievanceActivityLog[] $grievanceActivityLogs
 * @property GrievanceAssignLog[] $grievanceAssignLogs
 * @property GrievanceAssignLog[] $grievanceAssignLogs0
 * @property GrievanceAssignLog[] $grievanceAssignLogs1
 * @property GrievanceCcComment[] $grievanceCcComments
 * @property GrievanceMessageLog[] $grievanceMessageLogs
 * @property GrievanceMessageLogDetail[] $grievanceMessageLogDetails
 * @property ListType[] $listTypes
 * @property ListType[] $listTypes0
 * @property Media[] $media
 * @property MessageTemplate[] $messageTemplates
 * @property Role $role
 * @property UserTargetLog[] $userTargetLogs
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'role_id', 'username', 'name', 'email', 'mobile'], 'required'],
            [['role_id', 'mobile', 'status', 'allowed_grievance', 'allocated_grievance', 'is_last_allocated', 'is_limit_achieved', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'integer'],
            [['guid'], 'string', 'max' => 40],
            [['username', 'name'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['guid'], 'unique'],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'role_id' => 'Role ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'allowed_grievance' => 'Allowed Grievance',
            'allocated_grievance' => 'Allocated Grievance',
            'is_last_allocated' => 'Is Last Allocated',
            'is_limit_achieved' => 'Is Limit Achieved',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancialYears()
    {
        return $this->hasMany(FinancialYear::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancialYears0()
    {
        return $this->hasMany(FinancialYear::className(), ['modified_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances()
    {
        return $this->hasMany(Grievance::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances0()
    {
        return $this->hasMany(Grievance::className(), ['dh_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievances1()
    {
        return $this->hasMany(Grievance::className(), ['modified_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceActivityComments()
    {
        return $this->hasMany(GrievanceActivityComment::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceActivityLogs()
    {
        return $this->hasMany(GrievanceActivityLog::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceAssignLogs()
    {
        return $this->hasMany(GrievanceAssignLog::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceAssignLogs0()
    {
        return $this->hasMany(GrievanceAssignLog::className(), ['new_dh_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceAssignLogs1()
    {
        return $this->hasMany(GrievanceAssignLog::className(), ['prv_dh_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceCcComments()
    {
        return $this->hasMany(GrievanceCcComment::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceMessageLogs()
    {
        return $this->hasMany(GrievanceMessageLog::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceMessageLogDetails()
    {
        return $this->hasMany(GrievanceMessageLogDetail::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListTypes()
    {
        return $this->hasMany(ListType::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListTypes0()
    {
        return $this->hasMany(ListType::className(), ['modified_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageTemplates()
    {
        return $this->hasMany(MessageTemplate::className(), ['modified_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTargetLogs()
    {
        return $this->hasMany(UserTargetLog::className(), ['user_id' => 'id']);
    }
}
