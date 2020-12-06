<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace packages\communication;

use Yii;

/**
 * Description of Email
 *
 * @author Pawan Kumar
 * @email <pkb.pawan@gmail.com>
 */
class Email extends \yii\base\Component
{

    public $fromName = null;
    public $fromEmail = null;
    public $assetsPath = null;
    private $_config = [];

    public function init()
    {
//        $configuration = MstConfiguration::findByType(MstConfiguration::EMAIL_AES);
//        if (empty($configuration)) {
//            throw new \yii\base\InvalidConfigException("Invalid AES email configuration.");
//        }
//
//        $this->_config = $configuration;
//        $this->assetsPath = $this->_config['config_val4'];
//        $this->fromName = $this->_config['config_val5'];
//        $this->fromEmail = $this->_config['config_val6'];
            
        //   'email.fromName' => 'REC Saubhagya Control Centre',
        //'email.noReply' => 'mail@reccontrolcentre.com',
        $this->fromName = 'REC Saubhagya Control Centre';//Yii::$app->params['email.fromName'];
        $this->noReply = 'mail@reccontrolcentre.com';//Yii::$app->params['email.noReply'];
        \Yii::$app->set('mailer', [
            'class' => 'Swift_SmtpTransport',
            //'viewPath' => '@common/mail',
            'host' => 'email-smtp.us-east-1.amazonaws.com', // amazon smtp host 
            'username' => 'AKIAJXEZRMYIO6HNK4FA', // ses user username
            'password' => 'BJ9fmcJ5/bQIx72AV5WUsmoE13IKZNrM/NUPQs33Sogm', // ses user password
            'port' => '587',
            'encryption' => 'tls',
        ]);

        return parent::init();
    }

    public function _buildTemplate($params = [])
    {
        $pattern = '{{%s}}';
        foreach ($params as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }
        return strtr($params['content'], $varMap);
    }

    public function __sendEmail($emailParams)
    {
        try {
            $emailParams['fromName'] = $this->fromName;
            $emailParams['fromEmail'] = $this->fromEmail;
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
