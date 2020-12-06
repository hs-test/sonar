<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use yii\base\Model;

/**
 * Description of UserForm
 *
 * @author Azam
 */
class UserForm extends Model
{

    // user table attributes
    public $id;
    public $guid;
    public $name;
    public $username;
    public $role_id;
    public $password;
    public $verifypassword;
    public $email;
    public $mobile;
    public $status;
    public $created_by;
    public $updated_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'status', 'mobile'], 'required'],
            ['username', 'string', 'min' => 5, 'max' => 15],
            [['password', 'verifypassword'], 'required', 'on' => ['insert']],
            ['email', 'email'],
            ['mobile', 'safe'],
            ['mobile', 'match', 'pattern' => '/^\d{10}$/', 'message' => 'Must contain exactly 10 digits.'],
            ['password', 'string', 'min' => 6],
            ['name', 'trim'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z ]*$/', 'message' => 'Must contain only alphabets.'],
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
            'password' => 'Password',
            'verifypassword' => 'Verify Password',
        ];
    }

    public function save()
    {
        $id = (int) $this->id;
        $guid = $this->guid;
        if ($id > 0) {
            $model = User::find()
                    ->where('id=:id', [':id' => $id])
                    ->andWhere('guid=:guid', [':guid' => $guid])
                    ->one();
        }
        else {
            $model = new User();
            $model->loadDefaultValues(TRUE);
        }

        $model->attributes = $this->attributes;
        $model->setPassword($this->password);
        $model->generateAuthKey();

        try {
            $model->save(FALSE);
            $this->id = $model->id;
            return true;
        }
        catch (\Exception $ex) {
            $findByUsername = User::findByUsername($this->username);
            if ($findByUsername !== NULL) {
                $this->addError('username', 'Username already exists');
            }

            $findByEmail = User::findByEmail($this->email);
            if ($findByEmail !== NULL) {
                $this->addError('email', 'Email already exists');
            }

            return false;
        }
    }

    public static function getUser($guid)
    {
        $model = new UserForm;
        $data = User::find()
                        ->where('guid=:guid', [':guid' => $guid])
                        ->asArray()->one();

        $model->id = $data['id'];
        $model->guid = $data['guid'];
        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->status = $data['status'];
        $model->username = $data['username'];
        $model->mobile = $data['mobile'];
        $model->role_id = $data['role_id'];

        return $model;
    }

}
