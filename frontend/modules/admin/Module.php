<?php

namespace app\modules\admin;

use Yii;

/**
 * Description of Module
 *
 * @author Azam
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();

        if (!Yii::$app->user->isGuest) {
            Yii::$app->errorHandler->errorAction = '/admin/error/error';
        }

        Yii::$app->user->loginUrl = '/admin/auth/login';
        Yii::$app->defaultRoute = '/admin/dashboard/index';
    }

}
