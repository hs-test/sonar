<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Vle;
use common\models\Role;
use yii\base\Model;

/**
 * Description of GrievanceForm
 *
 * @author Ravi
 */
class GrievanceForm extends Model
{

    // user table attributes
    public $customer_id;
    public $customer_guid;
    public $name;
    //public $gender;
    public $mobile;
    public $email;
    public $grievance_no;
    public $address;
    public $pincode;
    public $type;
    public $status;
    public $description_complaint;
    public $state_code;
    public $district_code;
    public $village_code;
    public $prefix;
    public $created_by;
    public $updated_by;

    public function init()
    {
        $this->created_by = \Yii::$app->user->id;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state_code', 'district_code', 'village_code', 'name', 'mobile', 'address', 'type', 'description_complaint', 'prefix'], 'required'],
            ['pincode', 'string', 'max' => 6, 'min' => 6],
            ['pincode', 'match','pattern' => '/^[0-9]{6}$/'],
            ['email', 'email'],
            ['name', 'trim'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z ]*$/', 'message' => 'Must contain only alphabets.'],
            ['mobile', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Must contain exactly 10 digits.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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
            'type' => 'Type'
        ];
    }
    
    public function save()
    {
        $customer_id = (int) $this->customer_id;
        $customer_guid = $this->customer_guid;
        $userId = (int) $this->created_by;

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            if ($customer_id > 0) {
                $model = \common\models\Customer::find()
                        ->where('id=:id', [':id' => $customer_id])
                        ->andWhere('guid=:guid', [':guid' => $customer_guid])
                        ->one();
            }
            else {
                $model = new \common\models\Customer();
                $model->loadDefaultValues(TRUE);
            }

            $model->attributes = $this->attributes;
            
            if (!$model->save()) {
                $this->addErrors($model->getErrors());
                $transaction->rollBack();
                return false;
            }

            // save grievance 
            $grievanceModel = new \common\models\Grievance();
            $grievanceModel->loadDefaultValues(TRUE);
            $this->customer_id = $model->id;
            $grievanceModel->attributes = $this->attributes;
            if (!$grievanceModel->save()) {
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

    public static function getVle($vle_guid)
    {
        $model = new VleForm;
        $vleData = Vle::find()
                        ->select('user.guid as user_guid, user.email,user.username, user.name, user.email,user.status, vle.*')
                        ->leftJoin('user', 'user.id = vle.user_id')
                        ->where('vle.guid=:vleGuid', [':vleGuid' => $vle_guid])
                        ->asArray()->one();

        $model->vle_id = $vleData['id'];
        $model->vle_guid = $vleData['guid'];
        $model->user_id = $vleData['user_id'];
        $model->user_guid = $vleData['user_guid'];
        $model->name = $vleData['name'];
        $model->email = $vleData['email'];
        $model->status = $vleData['status'];
        $model->phone = $vleData['phone'];
        $model->state_code = $vleData['state_code'];
        $model->district_code = $vleData['district_code'];
        $model->block_code = $vleData['block_code'];
        $model->panchayat_code = $vleData['panchayat_code'];
        $model->village_code = $vleData['village_code'];
        $model->omtid = $vleData['omtid'];

        return $model;
    }

    protected function sendMessage($model)
    {

        //nodal center user details
        $stateCode = $model->state_code;
        $userParams = [

            'selectCols' => ['user.email', 'user.mobile'],
            'joinWithUserLocation' => 'innerJoin',
            'stateCode' => $stateCode,
            'resultCount' => 'all'
        ];
        $userModel = User::findByRoleId([User::ROLE_RAC_NODAL_OFFICER, User::ROLE_DISCOM_NODAL_OFFICER], $userParams);

        $adminMobileNo = Yii::$app->user->identity->mobile;

        $template = Yii::$app->params['sms.template'];
        $messageTemplate = str_replace('{{grievance_no}}', $model->grievance_no, $template);
        $nodalTemplate = Yii::$app->params['sms.template.nodal'];
        $nodalGrievanceNoTemplate = str_replace('{{grievance_no}}', $model->grievance_no, $nodalTemplate);
        $nodalCustomerTemplate = str_replace('{{customer_name}}', $model->name, $nodalGrievanceNoTemplate);
        $nodalCustomerMobileTemplate = str_replace('{{customer_mobile}}', $model->customer->mobile, $nodalCustomerTemplate);
        $nodalCustomerEmailTemplate = str_replace('{{customer_email}}', $model->customer->email, $nodalCustomerMobileTemplate);
        $nodalCustomerAddressTemplate = str_replace('{{address}}', $model->address, $nodalCustomerEmailTemplate);
 
        Yii::$app->sms->send($model->customer->mobile, $messageTemplate);
        Yii::$app->sms->send($adminMobileNo, $messageTemplate);

        $params = [
            'name' => $model->name,
            'state' => $model->stateCode->name,
            'district' => $model->districtCode->name,
            'village' => $model->villageCode->name,
            'mobileNo' => $model->customer->mobile,
            'email' => $model->customer->email,
            'grievanceNo' => $model->grievance_no
        ];
        if (!empty($model->customer->email)) {

            $sendEmailGrievance = Yii::$app->email->sendWelcomeEmail($model->customer->email, $params);
        }
        $sendEmailAdmin = Yii::$app->email->sendWelcomeEmail(Yii::$app->user->identity->email, $params);
        
        if (empty($userModel)) {
            foreach ($userModel as $user) {
                if (!empty($user['mobile'])) {
                    Yii::$app->sms->send($user['mobile'], $nodalCustomerAddressTemplate);
                }
                if (!empty($user['email'])) {
                    Yii::$app->email->sendWelcomeEmail($user['email'], $params);
                }
            }
        }
    }

}
