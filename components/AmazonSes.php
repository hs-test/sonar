<?php

namespace components;

use yii\base\Component;
use Aws\Ses\SesClient;

class AmazonSes extends Component
{
    public $amazons3Key;
    public $amazons3Secret;
    public $amazons3Region;
    public $client;
    
    public $result;
    public $error;

    public function init()
    {
        $this->amazons3Key = \Yii::$app->params['amazons3.key'];
        $this->amazons3Secret = \Yii::$app->params['amazons3.secret'];
        $this->amazons3Region = \Yii::$app->params['amazons3.region'];

        // Instantiate the S3 client with your AWS credentials
        $this->client = new SesClient([
            'credentials' => [
                'key' => $this->amazons3Key,
                'secret' => $this->amazons3Secret
            ],
            'region' => 'us-east-1',
            'version' => 'latest'
        ]);
        

        parent::init();
    }

    public function sendEmail($params)
    {
        $to = $params['to'];
        $subject = $params['subject'];
        $body = $params['message'];
        $from = $params['from'];

        $msg = array();
        $msg['Source'] = 'admin@digital-village.in';//$from;
        
        //To Addresses must be an array
        $msg['Destination']['ToAddresses'][] = $to;

        $msg['Message']['Subject']['Data'] = $subject;
        $msg['Message']['Subject']['Charset'] = "UTF-8";

        $msg['Message']['Body']['Html']['Data'] = $body;
        $msg['Message']['Body']['Html']['Charset'] = "UTF-8";

        try {
            $this->result = $this->client->sendEmail($msg);            
            return true;
        }
        catch (Exception $e) {
            //An error happened and the email did not get sent
            $this->error = $e->getMessage();
            return false;
        }
    }

}
