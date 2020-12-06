<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);
$domain = (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
return [

    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'applicationUrl' => 'http://' . $domain,
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'amazons3' => [
            'class' => 'components\AmazonS3'
        ],
        'email'=>[
           'class' => 'components\Email' 
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => FALSE,
            'loginUrl' => null
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'sms' => [
            'class' => 'components\Sms',
            'apiUrl' => 'http://redoxsms.co.in',
            'username' => 'CSCSPV',
            'password' => '',
            'apiKey' => '6cc8c13a6eXX',
            'senderId' => 'CSCSPV',
            'type' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
