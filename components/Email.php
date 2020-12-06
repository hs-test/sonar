<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace components;

use Yii;
use common\models\caching\ModelCache;

/**
 * Description of Email
 *
 * @author Pawan Kumar
 */
class Email extends \yii\base\Component
{

    public function sendEmail($messageLogId, $params = [])
    {
        $messageLogModel = \common\models\GrievanceMessageLog::findById($messageLogId, ['selectCols' => ['grievance_message_log.subject', 'grievance_message_log.message']]);
        if (empty($messageLogModel)) {
            return true;
        }
        $emailParams = [
            'toName' => $params['name'],
            'toEmail' => $params['email'],
            'template' => $messageLogModel['message'],
            'subject' => $messageLogModel['subject'],
        ];

        return $this->__sendEmail($emailParams);
    }

    public function sendWelcomeCenterEmail($centerId, $password)
    {
        $centerModel = $this->findCenterModel($centerId);
        if ($centerModel === FALSE) {
            return FALSE;
        }

        $centerSuperintendent = \common\models\CenterAddress::findByCenterId($centerModel->id, [
                    'addressType' => \common\models\CenterAddress::TYPE_CENTER_SUPERINTENDENT
        ]);
        if ($centerSuperintendent === FALSE) {
            return FALSE;
        }


        $templateModel = MstMessageTemplate::findByType(MstMessageTemplate::TEMPLATE_EMAIL, [
                    'service' => MstMessageTemplate::SERVICE_LOGIN_DETAIL
        ]);

        if ($templateModel === NULL) {
            return FALSE;
        }
        $templateParams = [
            'name' => $centerModel->name,
            'username' => $centerModel->email,
            'reference' => $centerModel->reference_code,
            'password' => $password,
            'staticPath' => $this->assetsPath,
            'siteUrl' => \yii\helpers\Url::base(TRUE),
            'content' => $templateModel['template']
        ];

        $emailParams = [
            'toName' => $centerSuperintendent['name'],
            'toEmail' => $centerModel->email,
            'template' => $this->_buildTemplate($templateParams),
            'subject' => $templateModel['title'],
        ];

        return $this->__sendEmail($emailParams);
    }

    private function findCenterModel($centerId)
    {
        if (empty($centerId)) {
            return FALSE;
        }

        $centerModel = \common\models\Center::findById($centerId, ['resultFormat' => ModelCache::RETURN_TYPE_OBJECT]);
        if ($centerModel == NULL) {
            return FALSE;
        }

        return $centerModel;
    }

    public function sendRegistrationOtpEmail($email, $centeName, $otp)
    {

        $templateModel = MstMessageTemplate::findByType(MstMessageTemplate::TEMPLATE_EMAIL, [
                    'service' => MstMessageTemplate::SERVICE_OTP
        ]);

        if ($templateModel === NULL) {
            return FALSE;
        }

        $templateParams = [
            'name' => $centeName,
            'otp' => $otp,
            'staticPath' => $this->assetsPath,
            'siteUrl' => \yii\helpers\Url::base(TRUE),
            'content' => $templateModel['template']
        ];

        $emailParams = [
            'toName' => $centeName,
            'toEmail' => $email,
            'template' => $this->_buildTemplate($templateParams),
            'subject' => $templateModel['title'], //'OTP for verification'
        ];

        $this->__sendEmail($emailParams);
    }
    
//    private function __sendEmail($params = [])
//    {
//        try {
//            $emailAQ = Yii::$app->mailer->compose($params['template'])
//                    ->setFrom([Yii::$app->params['email.noReply'] => Yii::$app->params['email.fromName']])
//                    ->setTo($params['toEmail'])
//                    ->setSubject($params['subject']);
//
//            return $emailAQ->send();
//        }
//        catch (\Exception $ex) {
//
//           echo '<pre>';print_r($ex->getMessage());die;
//            Yii::error($ex->getMessage());
//        }
//    }
    
    public function __sendEmail($emailParams)
    {
        try {
            $emailParams['fromName'] = Yii::$app->params['email.fromName'];
            $emailParams['fromEmail'] = Yii::$app->params['email.noReply'];
            return $this->_sendSesEmail($emailParams);
        }
        catch (\Exception $ex) {
            \Yii::error('Email Client Error : ' . $ex->getMessage());
            return FALSE;
        }

        return TRUE;
    }

    private function _sendSesEmail($params)
    {
        try {
            $emailAQ = Yii::$app->mailer->compose()
                    ->setFrom([$params['fromEmail'] => $params['fromName']])
                    ->setTo($params['toEmail'])
                    ->setHtmlBody($params['template'])
                    ->setSubject($params['subject']);

            if (isset($params['cc']) && !empty($params['cc'])) {
                $emailAQ->setCc($params['cc']);
            }
            if (isset($params['bccEmail']) && !empty($params['bccEmail'])) {
                $emailAQ->setBcc($params['bccEmail']);
            }

            return $emailAQ->send();
        }
        catch (\Exception $ex) {
            \Yii::error($ex->getMessage());
        }
        return false;
    }

}
