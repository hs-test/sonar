<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Role;
use yii\base\Model;

/**
 * Description of UpdateStatusForm
 *
 * @author Ravi
 */
class UpdateStatusForm extends Model
{

    public $grievance_id;
    public $grievance_guid;
    public $grievance_activity_id;
    public $grievance_status;
    public $srn_no;
    public $security_depository_type;
    public $date;
    public $description;
    public $comments;
    public $additional_comment;
    public $approved_shares;
    public $approved_amount;
    public $pay_status;
    public $created_by;
    public $modified_by;
   

    const SCENARIO_USER_DISPATCH_EXECUTIVE = 'dispatch-executive';
    const SCENARIO_USER_DEALING_HEAD = 'dealing-head';
    const SCENARIO_USER_ACCOUNTANT = 'accountant';

    public function init()
    {
        $this->created_by = \Yii::$app->user->id;
        $this->modified_by = \Yii::$app->user->id;
        $this->date = date('Y-m-d');

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grievance_status'], 'required'],
            [['approved_shares','pay_status'], 'integer'],
            [['approved_amount'], 'number'],
            [['date', 'description', 'srn_no', 'security_depository_type', 'additional_comment'], 'string'],
            [['date', 'description'], 'required', 'on' => self::SCENARIO_USER_DISPATCH_EXECUTIVE],
            ['comments', 'required', 'when' => function ($model) {
                    return ($model->grievance_status == \common\models\Grievance::REJECTED || $model->grievance_status == \common\models\Grievance::DISCREPANCY) ? TRUE : FALSE;
                },
                'whenClient' => "function (attribute, value) {
                  return ($('#updatestatusform-grievance_status').val() == '" . \common\models\Grievance::REJECTED . "' || $('#updatestatusform-grievance_status').val() == '" . \common\models\Grievance::DISCREPANCY . "') ? true : false;
            }"],
//            ['refund_shares', 'required', 'when' => function ($model) {
//                    return ($model->grievance_status == \common\models\Grievance::APPROVED) ? TRUE : FALSE;
//                },
//                'whenClient' => "function (attribute, value) {
//                  return ($('#updatestatusform-grievance_status').val() == '" . \common\models\Grievance::APPROVED . "') ? true : false;
//            }"],
//            ['refund_amount', 'required', 'when' => function ($model) {
//                    return ($model->grievance_status == \common\models\Grievance::APPROVED) ? TRUE : FALSE;
//                },
//                'whenClient' => "function (attribute, value) {
//                  return ($('#updatestatusform-grievance_status').val() == '" . \common\models\Grievance::APPROVED . "') ? true : false;
//            }"],
            ['comments', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_shares' => 'No of Shares',
            'refund_amount' => 'Share Amount',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'password',
            'verifypassword' => 'Verify Password',
            'state_code' => 'State',
            'district_code' => 'District',
            'village_code' => 'Village',
            'block_code' => 'Block',
            'mobile' => 'Mobile number',
            'type' => 'Type',
            'comments' => 'Type',
            'additional_comment' => 'Additional Comment'
        ];
    }
    
    public function save()
    {
        $grievance_guid = $this->grievance_guid;
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            
            if(empty($grievance_guid)){
               return false; 
            }
            
            $grievanceModel = \common\models\Grievance::find()
                    ->where('guid=:guid', [':guid' => $grievance_guid])
                    ->one();
            if (empty($grievanceModel)) {
                return false;
            }

            $grievanceActivityModel = new \common\models\GrievanceActivityLog();
            $grievanceActivityModel->loadDefaultValues(TRUE);
            $grievanceActivityModel->attributes = $this->attributes;
            $grievanceActivityModel->grievance_id = $grievanceModel->id;
            $grievanceActivityModel->date = (isset($this->date)) ? date('Y-m-d', strtotime($this->date)) : date('Y-m-d');
            $grievanceActivityModel->comments = isset($this->comments) && !empty($this->comments) ? preg_replace('!\r?\n!', "", json_encode(['comments' => $this->comments])) : null;
            if (in_array($this->grievance_status, [
                        \common\models\Grievance::PAID,
                        \common\models\Grievance::APPROVED,
                        \common\models\Grievance::DISCREPANCY,
                        \common\models\Grievance::REJECTED
                    ])) {
                $grievanceActivityModel->is_msg_sent = \common\models\GrievanceActivityLog::IS_MESSAGE_SENT_YES;
            }
            
            if ($this->grievance_status == \common\models\Grievance::PAID) {
                if (empty($grievanceModel->refund_share_date) && empty($grievanceModel->refund_amount_date)) {
                    throw new \components\exceptions\AppException("Refund share date and refund amount date can'nt be empty.");
                }
                $refundShareDate = strtotime($grievanceModel->refund_share_date);
                $refundAmountDate = strtotime($grievanceModel->refund_amount_date);
                $paidDate = $refundShareDate;
                if ($paidDate < $refundAmountDate) {
                    $paidDate = $refundAmountDate;
                }
                $grievanceActivityModel->date = date('Y-m-d', $paidDate);
            }

            if (!$grievanceActivityModel->save()) {
                $this->addErrors($grievanceActivityModel->getErrors());
                $transaction->rollBack();
                return false;
            }
            $this->grievance_activity_id = $grievanceActivityModel->id;
            // update status of grievance
            $paystatus = 0;
            if (isset($this->approved_shares) && !empty($this->approved_shares)) {
                $paystatus = 1;
            }
            if (isset($this->approved_amount) && !empty($this->approved_amount)) {
                $paystatus = 2;
            }
            if (isset($this->approved_shares) && !empty($this->approved_shares) && isset($this->approved_amount) && !empty($this->approved_amount)) {
                $paystatus = 3;
            }
            if (isset($paystatus) && !empty($paystatus)) {
                $grievanceModel->pay_status = $paystatus;
            }

            $grievanceModel->status = $this->grievance_status;
            $grievanceModel->modified_by = $this->modified_by;
            $grievanceModel->security_depository_type = isset($this->security_depository_type) && !empty($this->security_depository_type) ? $this->security_depository_type : NULL;
            $grievanceModel->approved_shares = isset($this->approved_shares) && !empty($this->approved_shares) ? $this->approved_shares : NULL;
            $grievanceModel->approved_amount = isset($this->approved_amount) && !empty($this->approved_amount) ? $this->approved_amount : NULL;
            if (!$grievanceModel->save(TRUE, ['status', 'pay_status', 'modified_by', 'transaction_number', 'security_depository_type', 'approved_shares', 'approved_amount','modified_on'])) {
                $this->addErrors($grievanceModel->getErrors());
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;
        }
        catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }

        return false;
    }

}
