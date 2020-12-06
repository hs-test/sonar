<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "grievance".
 *
 * @property int $id
 * @property string $guid
 * @property int $financial_year
 * @property int $company_id
 * @property int|null $dh_id
 * @property string $srn_no
 * @property string $posting_date
 * @property string $applicant_name
 * @property string|null $applicant_address
 * @property int|null $applicant_std_code
 * @property int|null $applicant_phone
 * @property int|null $applicant_mobile
 * @property string|null $applicant_email
 * @property int $requested_shares
 * @property float $requested_nominal_share_amount
 * @property float $requested_total_amount
 * @property string|null $security_depository_type
 * @property string|null $rack_no
 * @property int|null $approved_shares
 * @property float|null $approved_amount
 * @property int|null $refund_shares
 * @property float|null $refund_amount
 * @property string|null $refund_share_date
 * @property string|null $refund_amount_date
 * @property string|null $approved_rejected_date
 * @property string|null $applicant_bank_account_no
 * @property string|null $applicant_bank_name
 * @property string|null $applicant_bank_branch
 * @property string|null $applicant_micr_code
 * @property string|null $applicant_dmat_account_no
 * @property int $status 0-pending
 * @property int|null $pay_status
 * @property string|null $import_depository_type
 * @property int|null $is_amount_import
 * @property int|null $is_viewed
 * @property int|null $is_review
 * @property int|null $is_scan
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property int|null $created_on
 * @property int|null $modified_on
 * @property int|null $new_status
 *
 * @property Company $company
 * @property User $createdBy
 * @property User $dh
 * @property FinancialYear $financialYear
 * @property GrievanceActivityLog[] $grievanceActivityLogs
 * @property GrievanceAssignLog[] $grievanceAssignLogs
 * @property GrievanceCcComment[] $grievanceCcComments
 * @property GrievanceMessageLog[] $grievanceMessageLogs
 * @property GrievanceScanReview[] $grievanceScanReviews
 * @property User $modifiedBy
 */
class Grievance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grievance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guid', 'financial_year', 'company_id', 'srn_no', 'posting_date', 'applicant_name', 'requested_shares', 'requested_nominal_share_amount', 'requested_total_amount'], 'required'],
            [['financial_year', 'company_id', 'dh_id', 'applicant_std_code', 'applicant_phone', 'applicant_mobile', 'requested_shares', 'approved_shares', 'refund_shares', 'status', 'pay_status', 'is_amount_import', 'is_viewed', 'is_review', 'is_scan', 'created_by', 'modified_by', 'created_on', 'modified_on', 'new_status'], 'integer'],
            [['posting_date', 'refund_share_date', 'refund_amount_date', 'approved_rejected_date'], 'safe'],
            [['requested_nominal_share_amount', 'requested_total_amount', 'approved_amount', 'refund_amount'], 'number'],
            [['security_depository_type', 'import_depository_type'], 'string'],
            [['guid'], 'string', 'max' => 40],
            [['srn_no', 'applicant_name'], 'string', 'max' => 50],
            [['applicant_address', 'applicant_email', 'applicant_bank_name'], 'string', 'max' => 255],
            [['rack_no'], 'string', 'max' => 30],
            [['applicant_bank_account_no'], 'string', 'max' => 20],
            [['applicant_bank_branch'], 'string', 'max' => 200],
            [['applicant_micr_code', 'applicant_dmat_account_no'], 'string', 'max' => 100],
            [['guid'], 'unique'],
            [['srn_no'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['dh_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['dh_id' => 'id']],
            [['financial_year'], 'exist', 'skipOnError' => true, 'targetClass' => FinancialYear::className(), 'targetAttribute' => ['financial_year' => 'code']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modified_by' => 'id']],
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
            'financial_year' => 'Financial Year',
            'company_id' => 'Company ID',
            'dh_id' => 'Dh ID',
            'srn_no' => 'Srn No',
            'posting_date' => 'Posting Date',
            'applicant_name' => 'Applicant Name',
            'applicant_address' => 'Applicant Address',
            'applicant_std_code' => 'Applicant Std Code',
            'applicant_phone' => 'Applicant Phone',
            'applicant_mobile' => 'Applicant Mobile',
            'applicant_email' => 'Applicant Email',
            'requested_shares' => 'Requested Shares',
            'requested_nominal_share_amount' => 'Requested Nominal Share Amount',
            'requested_total_amount' => 'Requested Total Amount',
            'security_depository_type' => 'Security Depository Type',
            'rack_no' => 'Rack No',
            'approved_shares' => 'Approved Shares',
            'approved_amount' => 'Approved Amount',
            'refund_shares' => 'Refund Shares',
            'refund_amount' => 'Refund Amount',
            'refund_share_date' => 'Refund Share Date',
            'refund_amount_date' => 'Refund Amount Date',
            'approved_rejected_date' => 'Approved Rejected Date',
            'applicant_bank_account_no' => 'Applicant Bank Account No',
            'applicant_bank_name' => 'Applicant Bank Name',
            'applicant_bank_branch' => 'Applicant Bank Branch',
            'applicant_micr_code' => 'Applicant Micr Code',
            'applicant_dmat_account_no' => 'Applicant Dmat Account No',
            'status' => 'Status',
            'pay_status' => 'Pay Status',
            'import_depository_type' => 'Import Depository Type',
            'is_amount_import' => 'Is Amount Import',
            'is_viewed' => 'Is Viewed',
            'is_review' => 'Is Review',
            'is_scan' => 'Is Scan',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
            'new_status' => 'New Status',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Dh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDh()
    {
        return $this->hasOne(User::className(), ['id' => 'dh_id']);
    }

    /**
     * Gets query for [[FinancialYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinancialYear()
    {
        return $this->hasOne(FinancialYear::className(), ['code' => 'financial_year']);
    }

    /**
     * Gets query for [[GrievanceActivityLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceActivityLogs()
    {
        return $this->hasMany(GrievanceActivityLog::className(), ['grievance_id' => 'id']);
    }

    /**
     * Gets query for [[GrievanceAssignLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceAssignLogs()
    {
        return $this->hasMany(GrievanceAssignLog::className(), ['grievance_id' => 'id']);
    }

    /**
     * Gets query for [[GrievanceCcComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceCcComments()
    {
        return $this->hasMany(GrievanceCcComment::className(), ['grievance_id' => 'id']);
    }

    /**
     * Gets query for [[GrievanceMessageLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceMessageLogs()
    {
        return $this->hasMany(GrievanceMessageLog::className(), ['grievance_id' => 'id']);
    }

    /**
     * Gets query for [[GrievanceScanReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrievanceScanReviews()
    {
        return $this->hasMany(GrievanceScanReview::className(), ['grievance_id' => 'id']);
    }

    /**
     * Gets query for [[ModifiedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }
}
