<?php

namespace common\models;

use Yii;
use common\models\base\UserTargetLog AS BaseUserTargetLog;

/**
 * Description of UserTargetLog
 *
 * @author Pawan Kumar
 */
class UserTargetLog extends BaseUserTargetLog
{

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => [
                        'created_on',
                    ],
                ]
            ],
        ];
    }

    public function init()
    {
        $this->date = date('Y-m-d');
        return parent::init();
    }

    public function afterSave($insert, $changedAttributes)
    {
        $month = date('m');
        if ($this->month == $month) {
            User::updateAll([
                'allowed_grievance' => $this->allocated,
                    ], 'id =:userId', [':userId' => $this->user_id]);
        }
        if (isset($this->allocated) && !empty($this->allocated)) {
            // find user allocated srn
            $userModel = User::findById($this->user_id, ['resultFormat' => caching\ModelCache::RETURN_TYPE_OBJECT]);
            if (!empty($userModel)) {

                if ($this->allocated > $userModel->allocated_grievance) {
                    $userModel->is_limit_achieved = 0;
                    $userModel->save(TRUE, ['is_limit_achieved']);
                }
            }
        }
        return parent::afterSave($insert, $changedAttributes);
    }

}
