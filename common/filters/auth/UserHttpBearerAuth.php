<?php

namespace common\filters\auth;

use Yii;
use yii\filters\auth\HttpBearerAuth;

/**
 * Description of UserHttpBearerAuth
 *
 * @author Azam
 */
class UserHttpBearerAuth extends HttpBearerAuth
{

    /**
     * @inheritdoc
     */
    public $userModel = NULL;
    public $subVleModel = NULL;

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $this->userModel = \common\models\User::findUserByAccessToken($matches[1]);
            if ($this->userModel === null) {
                $this->handleFailure($response);
            }
            $userId = $this->userModel->id;
            $model = \common\models\Vle::findOne(['user_id' => $userId]);
            $this->subVleModel = $model;
            return $this->userModel;
        }

        return $this->userModel;
    }

    public function handleFailure($response)
    {
        try {
            parent::handleFailure($response);
        }
        catch (\Exception $ex) {
            print_r(json_encode([
                'status' => 0,
                'errors' => ['message' => 'Please provide valid auth key.'],
                'data' => []
            ]));
            \Yii::$app->end();
        }
    }

}
