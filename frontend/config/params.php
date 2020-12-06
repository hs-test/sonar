<?php

$domain = (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
$isHttps = (isset($_SERVER) && ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'))) ? TRUE : FALSE;

//cloudflare ssl
if (!$isHttps && isset($_SERVER) && isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false) {
    $isHttps = TRUE;
}

$httpProtocol = ($isHttps) ? 'https' : 'http';

return [
    'adminEmail' => 'admin@example.com',
    //'staticHttpPath' => $httpProtocol . '://' . $domain . '/static',
    'staticHttpPath' => 'https://d3qenpm2yi0vgp.cloudfront.net/static',
    'applicationEnv' => 'PROD',
    'is_ssl' => 1,
    'httpProtocol' => $httpProtocol,
    'cacheBustTimestamp' => 2020083101,
    'activeMenu' => '',
    'allowed.grievance' => 50,
    'adminSidebar' => [
        'dashboard' => [
            'iconClass' => 'fa fa-home',
            'routeUrl' => '/admin/dashboard/index',
            'text' => 'Dashboard',
        ],
//        'search' => [
//            'iconClass' => 'fa fa-search',
//            'routeUrl' => '/admin/grievance/search',
//            'text' => 'Search',
//            'allowedRoles' => [common\models\User::ROLE_ADMIN, common\models\User::ROLE_DISPATCH_EXECUTIVE, common\models\User::ROLE_DEALING_HEAD],
//        ],
        'grievance-import' => [
            'iconClass' => 'fa fa-cloud-upload',
            'routeUrl' => '/admin/grievance/cdsl-import',
            'text' => 'Depository Import',
            'allowedRoles' => [common\models\User::ROLE_ADMIN]
        ],
        'import' => [
            'iconClass' => 'fa fa-cloud-upload',
            'routeUrl' => '/admin/grievance/import',
            'text' => 'Import',
            'allowedRoles' => [common\models\User::ROLE_ADMIN, common\models\User::ROLE_DISPATCH_EXECUTIVE,common\models\User::ROLE_DEALING_HEAD]
        ],
        'grievance' => [
            'iconClass' => 'fa fa-briefcase',
            'routeUrl' => '/admin/grievance/index',
            'text' => 'SRN',
            'allowedRoles' => [common\models\User::ROLE_DISPATCH_EXECUTIVE, common\models\User::ROLE_DEALING_HEAD, common\models\User::ROLE_CALLCENTER_EXECUTIVE, common\models\User::ROLE_CALLCENTER_SUPERVISOR, common\models\User::ROLE_ACCOUNT_MANAGER, common\models\User::ROLE_ASSIGNMENT_OFFICER, common\models\User::ROLE_ASSISTANT_ACCOUNT_MANAGER, common\models\User::ROLE_ACCOUNT_EXECUTIVE],
        ],
        'company' => [
            'iconClass' => 'fa fa-group',
            'routeUrl' => '/admin/company/index',
            'text' => 'Company',
            'allowedRoles' => [common\models\User::ROLE_ADMIN],
        ],
        'user' => [
            'iconClass' => 'fa fa-navicon',
            'routeUrl' => '/admin/user/index',
            'text' => 'User',
            'allowedRoles' => [common\models\User::ROLE_ADMIN, common\models\User::ROLE_ASSIGNMENT_OFFICER],
        ],
        'list' => [
            'iconClass' => 'fa fa-navicon',
            'routeUrl' => '/admin/list-type/index',
            'text' => 'List Types',
            'allowedRoles' => [common\models\User::ROLE_ADMIN],
        ],
        'message-template' => [
            'iconClass' => 'fa fa-envelope',
            'routeUrl' => '/admin/message-template/index',
            'text' => 'Message Template',
            'allowedRoles' => [common\models\User::ROLE_ADMIN],
        ],
        'report' => [
            'iconClass' => 'fa fa-file-excel-o',
            'routeUrl' => '/admin/report/index',
            'text' => 'MIS Reports',
            'allowedRoles' => [common\models\User::ROLE_ADMIN, common\models\User::ROLE_DISPATCH_EXECUTIVE, common\models\User::ROLE_DEALING_HEAD, common\models\User::ROLE_SUPERVISOR]
        ],
    ],
];
