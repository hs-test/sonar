<?php

namespace app\modules\admin\models;

use Yii;
use common\models\Grievance;
use common\models\GrievanceScanReview;
use common\models\Role;
use yii\base\Model;

/**
 * Description of ScanReviewForm
 *
 * @author Ravi
 */
class ScanReviewForm extends Model
{

    public $id;
    public $grievance_id;
    public $date;
    public $reason;
    public $type;
    public $comment;
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
            [['date', 'reason', 'type'], 'required'],
            [['comment', 'date', 'type'], 'string'],
            [['reason'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Comment',
            'list' => 'Comment'
        ];
    }

    public function save()
    {
        $grievance_id = $this->grievance_id;
        $transaction = \Yii::$app->db->beginTransaction();

        try {

            if (empty($grievance_id)) {
                return false;
            }

            $grievanceModel = Grievance::find()
                    ->where('id=:id', [':id' => $grievance_id])
                    ->one();
            if (empty($grievanceModel)) {
                return false;
            }
            $this->grievance_id = $grievanceModel->id;
            $model = new GrievanceScanReview();
            $model->loadDefaultValues(TRUE);
            $model->attributes = $this->attributes;
            $model->reason = json_encode(['comments' => $this->reason]);

            if (!$model->save()) {
                $this->addErrors($model->getErrors());
                $transaction->rollBack();
                return false;
            }
            if ($this->type === GrievanceScanReview::TYPE_SCAN) {
                $grievanceModel->is_scan = 1;
            }
            else {
                $grievanceModel->is_review = 1;
            }
            if (!$grievanceModel->save(TRUE, ['is_scan', 'is_review'])) {
                $this->addErrors($grievanceModel->getErrors());
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
