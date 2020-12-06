<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\caching\ModelCache;

/**
 * Description of UserForm
 *
 * @author Pawan
 */
class UserForm extends \yii\base\Model
{
    public $id;
    public $guid;
    public $username;
    public $email;
    public $mobile;
    public $password;
    public $verifypassword;
    public $name;
     
   
    public $status;
    
    public $role_id;
    
    
    const SCENARIO_USER_UPDATE = 'update';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'mobile', 'status'], 'required'],
            [['password', 'verifypassword', 'role_id'], 'required', 'except' => self::SCENARIO_USER_UPDATE],
            
            [['id', 'role_id'], 'integer'],
            [['guid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 255],
            ['username', 'string', 'min' => 4, 'max' => 50],
            ['mobile', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Must contain exactly 10 digits.'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Username can only contain alphabets and numbers.'],
            ['email', 'email'],
            ['password', 'string', 'min' => 8],
            ['password', 'checkPassword'],            
            //['password', 'match','pattern'=>'#[0-9][A-Z]+#' , 'message' =>'Password must include at least one number and one capital letter!'],            
            [['verifypassword'], 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => 'Verify Password should exactly match Password'],
        ];
    }

    public function checkPassword($attribute, $params, $validator)
    {
        if (strlen($this->$attribute) < 8) {
            $this->addError('password', 'Password too short!.');
        }

        if (!preg_match("#[0-9]+#", $this->$attribute)) {

            $this->addError('password', 'Password must include at least one number!');
        }

        if (!preg_match("#[A-Z]+#", $this->$attribute)) {

            $this->addError('password', 'Password must include at least one capital letter!');
        }
    }

    public function attributeLabels()
    {
        $parentLabels = parent::attributeLabels();
        $attrs = [
            'role_id' => 'Role',
        ];

        return \yii\helpers\ArrayHelper::merge($parentLabels, $attrs);
    }

    public function save()
    {
        $userId = (int) $this->id;
        $userGuid = $this->guid;
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($userId > 0) {
                $model = User::findByGuid($userGuid, ['id' => $userId, 'resultFormat' => ModelCache::RETURN_TYPE_OBJECT]);
                if ($model === NULL) {
                    throw new \components\exceptions\AppException("Oops! You trying to access user model doesn't exist.");
                }
            }
            else {
                $model = new User;
                $model->loadDefaultValues(TRUE);
            }

            if (!$model->saveUser($this->attributes)) {
                $this->addErrors($model->getErrors());
                return FALSE;
            }
           
            $transaction->commit();
            return TRUE;
        }
        catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }
}
