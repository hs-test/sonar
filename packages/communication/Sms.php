<?php

namespace packages\communication;

use Yii;
use common\models\MstConfiguration;
use common\models\MstMessageTemplate;

/**
 * Description of Sms
 *
 * @author Pawan Kumar
 * @email <pkb.pawan@gmail.com>
 */
class Sms extends \yii\base\Component
{
    private $config = [];
    public $response = [];
    
    public function init()
    {
        $configuration = MstConfiguration::findByType(MstConfiguration::SMS);
        if (empty($configuration)) {
            throw new \yii\base\InvalidConfigException("Invalid SMS configuration.");
        }
        
        $this->config['type'] = $configuration['config_val1'];
        if (empty($this->config['type'])) {
            throw new \yii\base\InvalidConfigException("Invalid SMS type configuration.");
        }
        
        if ($this->config['type'] == 'EZYSMS') {
            $this->config['senderId'] = $configuration['config_val2'];
            $this->config['username'] = $configuration['config_val3'];
            $this->config['password'] = $configuration['config_val4'];
        }
        return parent::init();
    }

    public function send($mobile, $message, $params = [])
    {
        try {
            if ($this->config['type'] == 'EZYSMS') {
                return $this->_sendEzysms($mobile, $message);
            }
        }
        catch (\Exception $ex) {
            Yii::error('SMS ERROR :' . $ex->getMessage());
        }
        return false;
    }

    private function _sendEzysms($mobile, $message)
    {
        $message = str_replace(' ', '%20', trim($message));
        $mobiles = is_array($mobile) ? implode(',', $mobile) : $mobile;
        
        $url = "http://push.ezysms.in/api.php?username={$this->config['username']}&password={$this->config['password']}&sender={$this->config['senderId']}&sendto=$mobiles&message=$message";
        $response = \components\Helper::httpGet($url);
        if (!empty($response)) {
            $responseArr = explode('=', $response);
            return (!empty($responseArr[1])) ? true : false;
        }
        return false;
    }

    public function __otpTemplate($service)
    {
        $templateModel = MstMessageTemplate::findByType(MstMessageTemplate::TEMPLATE_SMS, [
                    'service' => $service
        ]);
        
        if($templateModel == NULL) {
            return FALSE;
        }
        
        return $templateModel['template'];
    }
    
    public function _buildTemplate($params = [])
    {
        $pattern = '{{%s}}';
        foreach ($params as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }
        return strtr($params['content'], $varMap);
    }

}