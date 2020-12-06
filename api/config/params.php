<?php
$domain = (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
return [
    'AwsLambdaToken' => 'XholKUTJS87NQS239xgfzALSK913MBV7',
    'blockAttendanceMarkSchoolIds' => [
        12
    ],
    'staticHttpPath' => 'http://'.$domain.'/static',
    'fcm.apiAccessKey' => 'AIzaSyCzmg6OYk74enqXXyxY7E25hJrpVQM3kOM',
    'AuthToken'=>'AIzaSyCzmg6OYk74enq',
    'paytm' => [
        'live' => [
            'fees' => [
                'merchantId' => 'Congre27168571294504',
                'merchantKey' => 'c0Im@PB&Nyjem1%Z',
                'website' => 'CongregationWEB',
                'channelId' => 'WEB',
                'industryId' => 'PrivateEducation',
                'callBackUrl' => 'https://securegw.paytm.in/theia/paytmCallback'
            ],
            'registration' => [
                'merchantId' => 'SchoLK42641938089475',
                'merchantKey' => '@nXlSAwUg%Aj7SK!',
                'website' => 'SchoLKWEB',
                'channelId' => 'WEB',
                'industryId' => 'PrivateEducation'
            ]
        ],
        'dev' => [
            'fees' => [
                'merchantId' => 'TheCon71059887498634',
                'merchantKey' => 'A7L4STKTxwI%m!An',
                'channelId' => 'WAP',
                'website' => 'APPSTAGING',
                'industryId' => 'Retail',
                'callBackUrl' => 'https://pguat.paytm.com/paytmchecksum/paytmCallback.jsp'
            ]
        ]
    ],
    'enabled.payment.gateway' => 'dev',
    'icons' => [
        'birla' => [
            'feeIcon' => 'deploy/birla/images/bvn-logo.jpg',
        ],
        'columbas' => [
            'feeIcon' => 'deploy/columbas/images/columbas_fee_icon.png',
        ],
        'bhatnagar' => [
            'feeIcon' => 'deploy/birla/images/bis.png',
        ]
    ],
];
