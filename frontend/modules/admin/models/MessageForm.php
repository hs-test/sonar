<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Role;
use yii\base\Model;

/**
 * Description of MessageForm
 *
 * @author Ravi
 */
class MessageForm extends Model
{

    public $grievance_id;
    public $grievance_activity_id;
    public $subject;
    public $message_id;
    public $message;
    public $type;
    public $receiver_name;
    public $send_message;
    public $created_by;

    public function init()
    {
        $this->created_by = \Yii::$app->user->id;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grievance_id','message_id','grievance_activity_id'],'integer'],
            [['subject', 'message'], 'required'],
            [['subject', 'message'], 'string'],
            ['send_message', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'password',
            'verifypassword' => 'Verify Password',
            'state_code' => 'State',
            'district_code' => 'District',
            'village_code' => 'Village',
            'block_code' => 'Block',
            'mobile' => 'Mobile number',
            'type' => 'Type'
        ];
    }

    public function save()
    {

        $grievance_id = (int) $this->grievance_id;
        $message_id = (int) $this->message_id;

        $transaction = \Yii::$app->db->beginTransaction();
        try {


            $model = \common\models\GrievanceMessageLog::findByGrievanceId($grievance_id, ['messageId' => $message_id, 'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
            if (empty($model)) {
                $model = new \common\models\GrievanceMessageLog();
                $model->loadDefaultValues(TRUE);
            }

            $model->attributes = $this->attributes;

            if (!$model->save()) {
                $this->addErrors($model->getErrors());
                $transaction->rollBack();
                return false;
            }

            // save grievance message log detail 
            $grievanceMessageLogDetail = new \common\models\GrievanceMessageLogDetail();
            if (!$grievanceMessageLogDetail->saveLogs($grievance_id, $model->id, $this->send_message)) {
                $transaction->rollBack();
                return FALSE;
            }

            // update grivance activity log 
            $grievanceActivityModel = \common\models\GrievanceActivityLog::findById($this->grievance_activity_id, [ 'resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
            $grievanceActivityModel->is_msg_sent = (Yii::$app->user->identity->role_id == User::ROLE_ADMIN ) ? 0 : 2; //\common\models\GrievanceActivityLog::IS_MESSAGE_SENT_NO;

            if (!$grievanceActivityModel->save(TRUE, ['is_msg_sent'])) {
                $this->addErrors($grievanceActivityModel->getErrors());
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;
        }
        catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }

        return false;
    }

    public static function getMessageFormData($id = 0, $guid = '')
    {

        $query = \common\models\GrievanceMessageLog::find();

        if ($id > 0) {
            $query->where('grievance_message_log.id = :id', [':id' => $id
            ]);
        }

        $model = $query->asArray()->one();

        if ($model === null) {
            throw new \components\exceptions\AppException('Oops! We could not get data form company model. Here’s the message we got: <br/>requested parameter is not valid.');
        }

        return $model;
    }

}
