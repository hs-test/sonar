<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','appBootstrap'], //,'appBootstrap'
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'admin/auth/login',
    'components' => [
        'appBootstrap' => [
            'class' => 'frontend\components\AppBootstrap'
        ],
        'import' => [
            'class' => 'frontend\components\ImportComponent',
        ],
        'user' => [
            'class' => 'components\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => FALSE,
            'authTimeout' => 900,
            'loginUrl' => ['/admin/auth/login'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
//        'errorHandler' => [
//            'errorAction' => 'app/error',
//        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<slug>' => 'home/inner'
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'admin*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'admin' => 'app.php'
                    ],
                ],
            ],
        ],
        'amazons3' => [
            'class' => 'components\AmazonS3'
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'dashboard/index',
            'viewPath' => '@app/modules/admin/views',
            'layoutPath' => '@app/modules/admin/views/layouts',
            'layout' => 'main',
            'controllerMap' => [
            ],
        ],
    ],
    'params' => $params,
];
