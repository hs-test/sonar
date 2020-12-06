<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Description of AppController
 *
 * @author Pawan Kumar
 */
class AppController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

//    public function beforeAction($action)
//    {
//        \Yii::$app->response->redirect(\yii\helpers\Url::toRoute(['/admin/auth/login']), 301)->send();
//        exit;
//        return parent::beforeAction($action);
//        //return \Yii::$app->getResponse()->redirect(array(\yii\helpers\Url::to(['/admin'],302)));
//    }

}
