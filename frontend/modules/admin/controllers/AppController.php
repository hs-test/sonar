<?php

namespace app\modules\admin\controllers; 

use Yii;
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
    
    public function behaviors()
    {
//        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@']
//                    ],
//                ],
//            ],
//        ];
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!\common\models\User::checkSessionHijackingPreventions(\common\models\User::BACKEND_LOGIN_KEY, \common\models\User::BACKEND_FIXATION_COOKIE)) {
                        Yii::$app->user->logout();
                        return false;
                    }
                    if ($this->isUserHasPermissionRights()) {
                        return TRUE;
                    }
                },
                    ],
                ],
            ],
        ];
    }

    private function isUserHasPermissionRights()
    {
        if (\Yii::$app->user->isGuest) {
            return FALSE;
        }
        $controller = Yii::$app->controller->id;
        $userRole = Yii::$app->user->identity->role_id;
        if ($userRole == \common\models\User::ROLE_SUPERADMIN) {
            return TRUE;
        }

        $accessAllowed = false;
        if (strstr($controller, '/') !== false) {
            $controllerArr = explode('/', $controller);
            $controller = end($controllerArr);
        }

        $permission = Yii::$app->params['adminSidebar'];

        foreach ($permission as $key => $sidebar) {

            $url = explode('/', $sidebar['routeUrl']);
            $routeUrl = array_filter($url);
            $actionUrl = $routeUrl[2];

            if ($controller === 'dashboard' || $controller == 'user') {
                $accessAllowed = TRUE;
            }
            if (isset($sidebar['allowedRoles'])) {
                foreach ($sidebar['allowedRoles'] as $role) {
                    if ($userRole == $role && $actionUrl == $controller) {
                        $accessAllowed = TRUE;
                        break;
                    }
                }
            }
        }

        return $accessAllowed;
    }

    public function setSuccessMessage($message)
    {
        Yii::$app->session->setFlash('success', $message);
    }

    public function setErrorMessage($message)
    {
        Yii::$app->session->setFlash('error', $message);
    }

}