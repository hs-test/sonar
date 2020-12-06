<?php
namespace app\modules\admin\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $verifypassword;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($guid, $reset = false, $config = [])
    {
        if (empty($guid) || !is_string($guid)) {
            throw new InvalidParamException('Invalid User!');
        }
        
        if($reset) {
            $this->_user = User::findOne(['password_reset_token' => $guid]);
        } else {
            $this->_user = User::findOne(['guid' => $guid]);
        }
        
        if (!$this->_user) {            
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verifypassword', 'password'], 'required'],
            ['password', 'string', 'min' => 8],
            [['verifypassword'], 'compare', 'compareAttribute' => 'password', 'message' => 'Verify Password should exactly match Password'],
            ['password', 'checkPassword']
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

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
