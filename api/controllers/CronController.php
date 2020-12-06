<?php

namespace api\controllers;

use common\models\User;

/**
 * Description of CronApiController
 *
 * @author Ravi Sikarwar
 */
class CronController extends \yii\rest\Controller
{

    public function beforeAction($action)
    {
        $parent = parent::beforeAction($action);
        $authTokenHeader = Yii::$app->request->getHeaders()->get('token');
        if ($authTokenHeader !== \Yii::$app->params['cronAuthToken']) {
            throw new \components\exceptions\AppException("invalid access");
        }
        return $parent;
    }

}
