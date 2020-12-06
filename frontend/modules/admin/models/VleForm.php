<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Vle;
use common\models\Role;
use yii\base\Model;

/**
 * Description of VleForm
 *
 * @author Azam
 */
class VleForm extends Model
{

    // user table attributes
    public $user_id;
    public $user_guid;
    public $name;
    public $username;
    public $role_id;
    public $password;
    public $verifypassword;
    public $email;
    public $status;
    // vle table attributes
    public $vle_id;
    public $vle_guid;
    public $state_code;
    public $district_code;
    public $block_code;
    public $panchayat_code;
    public $village_code;
    public $omtid;
    public $pmgdishaid;
    public $phone;
    public $is_facilitation_centre_assigned;
    public $facilitation_centre_id;

    public $created_by;
    public $updated_by;
    public function init()
    {
        $this->role_id = Role::ROLE_VLE;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state_code', 'district_code', 'block_code', 'panchayat_code', 'village_code', 'omtid', 'name', 'phone', 'email', 'status','is_facilitation_centre_assigned'], 'required'],
            ['username', 'string', 'min' => 5, 'max' => 15],
            [['password', 'verifypassword'], 'required', 'on' => ['insert']],
            //['username', 'unique', 'targetClass' => User::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            ['email', 'email'],
            //['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email'], 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6],
            [['facilitation_centre_id'], 'string', 'max' => 20],
            ['name', 'trim'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z ]*$/', 'message' => 'Must contain only alphabets.'],
            ['phone', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Must contain exactly 10 digits.'],
            ['omtid', 'match', 'pattern' => '/^([a-zA-Z0-9]){12}$/', 'message' => 'Must contain exactly 12 characters.'],
            [['verifypassword'], 'compare', 'compareAttribute' => 'password', 'message' => 'Verify Password should exactly match Password'],
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
            'phone' => 'Mobile Number',
            'omtid' => 'CSC ID',
            'pmgdishaid' => 'PMGDISHA ID',
            'type' => 'Type'
        ];
    }

    public function save()
    {
        $id = (int) $this->vle_id;
        $guid = $this->vle_guid;
        $userId = (int) $this->user_id;
        $userGuid = $this->user_guid;

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            if ($id > 0) {
                $model = Vle::find()
                        ->where('id=:id', [':id' => $id])
                        ->andWhere('guid=:guid', [':guid' => $guid])
                        ->one();
            }
            else {
                $model = new Vle();
                $model->loadDefaultValues(TRUE);
            }

            $model->attributes = $this->attributes;            
            $this->username = $this->omtid;
            
            if ($model->save()) {

                $this->vle_id = $model->id;
                $this->vle_guid = $model->guid;

                //Create a Default User
                if ($id <= 0) {  //only on insert
                    $userModel = new User;
                    $newUserId = $userModel->saveUser($this->attributes);

                    if ($newUserId === FALSE) {
                        $this->addErrors($userModel->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                }
                else if ($userId > 0 && !empty($userGuid)) {
                    $userModel = User::findOne(['id' => $userId, 'guid' => $userGuid]);
                    $newUserId = $userModel->saveUser($this->attributes);
                    if ($newUserId === FALSE) {
                        $this->addErrors($userModel->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                }
                
                $model->user_id = $newUserId;
                $model->save();
            }
            else {
                $this->addErrors($model->getErrors());
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

}
