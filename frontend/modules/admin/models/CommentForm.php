<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Role;
use yii\base\Model;

/**
 * Description of CommentForm
 *
 * @author Ravi
 */
class CommentForm extends Model
{

    public $id;
    public $grievance_id;
    public $comment;
    public $list;
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
            [['id', 'grievance_id'], 'integer'],
            [['list'], 'required'],
            [['comment'], 'string'],
            [['list'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Additional Comment',
            'list' => 'Comment'
        ];
    }

    public function save()
    {

        $transaction = \Yii::$app->db->beginTransaction();

        try {

            $model = new \common\models\GrievanceCcComment();
            $model->loadDefaultValues(TRUE);
            $model->attributes = $this->attributes;

            if (isset($this->comment) && !empty($this->comment)) {
                array_push($this->list, $this->comment);
            }
            $model->comment = json_encode(['comments' => $this->list]);
            if (!$model->save()) {
                $this->addErrors($model->getErrors());
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

}
