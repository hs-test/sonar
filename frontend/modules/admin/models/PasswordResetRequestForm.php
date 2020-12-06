<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 * 
 * @author Pawan Kumar
 */
class PasswordResetRequestForm extends Model
{

    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such username.'
            ],
        ];
    }

    public function sendEmailOrSms()
    {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'username' => $this->username,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(true, ['password_reset_token'])) {
                return false;
            }
        }

        //Send Token in Email Or mobile number
        try {
            if (!empty($user->email)) {
                Yii::$app->email->sendResetPassword($user->id);
            }

            if (!empty($user->mobile)) {
                $url = Yii::$app->urlManager->createAbsoluteUrl(['/admin/auth/reset-password', 'token' => $user->password_reset_token]);
                Yii::$app->sms->send($user->mobile, Yii::t('app', 'reset.password.link', ['url' => $url]) , NULL , NULL ,  \common\models\MessageLog::SENT_TYPE_RESET,$user->id);
            }
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }

        return true;
    }

}
