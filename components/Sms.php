<?php

namespace components;

use Yii;
use yii\base\Component;

/**
 * Description of Sms
 *
 * @author Pawan Kumar
 */
class Sms extends Component
{
    private $url = 'https://bulksmsapi.vispl.in';
    private $username = 'cscotpapi';
    private $password = 'cscotpapi@123';
    public $senderId = 'CSCSPV';

    public $response;

    public function send($mobile, $message, $grievanceId, $userId, $sendType,$discomNodalId = NULL)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $response = file_get_contents($this->url . "?username=$this->username&password=$this->password&messageType=text&mobile=91$mobile&message=" . urlencode($message) . "&senderId=$this->senderId", false, stream_context_create($arrContextOptions));

        $messageDataArr = explode('#', $response);
        $success = TRUE;
        $response = 'Message sent Successfully';

        if ($messageDataArr[0] !== '0') {
            $success = FALSE;
            $response = $messageDataArr[1];
        }

        \common\models\MessageLog::saveMessageLog($grievanceId, [

            'discomNodalId' => $discomNodalId,
            'sendType' => $sendType,
            'mobile' => $mobile,
            'message' => $message,
            'userId' => $userId,
            'logs' => $response,
            'is_msg_sent' => ($success) ? \common\models\MessageLog::IS_MSG_SENT_SUCCESS : \common\models\MessageLog::IS_MSG_SENT_FAILED
        ]);
    }

}
