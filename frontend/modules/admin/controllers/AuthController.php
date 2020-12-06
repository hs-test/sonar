<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\LoginForm;
use common\models\PasswordResetRequestForm;
use app\modules\admin\models\ResetPasswordForm;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\modules\admin\controllers\AppController;

class AuthController extends AppController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
     /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 150,
                'height' => 70,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute('dashboard/index'));
        }
        
        \Yii::$app->view->params['bodyClass'] = 'login__Class';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute('dashboard/index'));
        }
        else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Url::toRoute('auth/login'));
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionForgot()
    {
        $model = new \app\modules\admin\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmailOrSms()) {
                Yii::$app->session->setFlash('success', 'Check your email or mobile for further instructions.');
                return $this->redirect(Url::toRoute('auth/login'));
            }
            else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for username provided.');
            }
        }
        \Yii::$app->view->params['bodyClass'] = 'login__Class';
        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }
    
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token, TRUE);
        }
        catch (\Exception $e) {
            throw new \components\exceptions\AppException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password has been reset successfully.');
            return $this->redirect(['login']);
        }

        \Yii::$app->view->params['bodyClass'] = 'login__Class';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
