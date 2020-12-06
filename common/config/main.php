<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => 'IEPF PORTAL',
    'timeZone' => 'Asia/Kolkata',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'on afterRequest' => function ($event) {
            if (\Yii::$app->id !== 'app-console') {
                 
                if (isset(\Yii::$app->response->headers)) {
                    $headers = \Yii::$app->response->headers;
                    $headers->add('X-FRAME-OPTIONS', 'SAMEORIGIN'); //avoid click jacking
                }
            }
        },
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php'
                    ],
                ],
            ],
        ],
        'ccAvenue' => [
            'class' => 'components\CcAvenue',
            'merchantId' => '218783',
            'accountName' => '',
            'accessCode' => 'AVSG02GG79AB07GSBA',
            'workingKey' => '0A83F0CF56D73A450D20432ED4283B62',
            'environment' => 'TEST'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'sms' => [
            'class' => 'components\Sms'
        ],
        'email'=>[
           'class' => 'components\Email' 
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                    'logVars' => ['_GET', '_POST'],
                ],
            ],
        ]
    ],
];
