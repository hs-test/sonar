<?php

//$domain = isset($_SERVER['APPLICATION_DOMAIN']) ? $_SERVER['APPLICATION_DOMAIN'] : "reccontrolcentre.com";
$domain =  (isset($_SERVER) && isset($_SERVER['HTTP_HOST']))  ? $_SERVER['HTTP_HOST'] : '';

return [
    'applicationName' => 'IEPF',
    'applicationEnv' => isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'PROD',
    'user.passwordResetTokenExpire' => 3600,
    'timezone' => 'Asia/Kolkata',
    //Email Settings
    'adminEmail' => 'omveer@csc.gov.in',
    'supportEmail' => 'omveer@csc.gov.in',
    'systemAdminEmail' => 'reccontrolroom@gmail.com',
    'email.fromName' => '',//REC Saubhagya Control Centre',
    'email.noReply' => '',//'mail@reccontrolcentre.com',
    //Amazon
    'amazons3.key' => 'AKIATUWTXXAZC2LGJPFM',
    'amazons3.secret' => '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',
    'amazons3.bucket' => 'iepf-mis-media',
    'amazons3.region' => 'ap-south-1',
    'aws.url.validity.minutes'=>10,
    
    //Upload Settings
    'upload.dir' => dirname(__FILE__) . '/../../frontend/web/uploads',
    'upload.dir.tempFolderName' => 'temp',
    'upload.baseHttpPath' => 'http://' . $domain . '/uploads',
    'upload.baseHttpPath.relative' => '/uploads',
    'upload.deletelocalfile.afterUploadToS3' => TRUE,
    'upload.uploadToS3' => true,
    'paginationLimit' => 50,
    'image.extension' => '.jpg,.jpeg,.png,.gif',
    'file.extension' => '.doc,.docx,.xlss,.pdf',
    // sms configuration
    
    'sms.username' => 'CSCOTPApi',
    'sms.password' => 'cscotpapi@123',
    'sms.senderId' => 'CSCSPV',
    'sms.template' => 'Your Grievance no is {{grievance_no}}',
    'sms.template.nodal' => 'Mr/Ms/Mrs. {{customer_name}}, Contact No.{{customer_mobile}}, Email {{customer_email}}, Address {{address}} has requested for electricity connection under
Saubhagya Scheme. For kind needful for settlement of this Grievance No. GN {{grievance_no}}.
REC CC Team.'
];
