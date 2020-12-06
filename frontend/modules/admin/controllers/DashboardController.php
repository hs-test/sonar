<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\AppController;
use Yii;

use common\models\User;
use common\models\Role;


/**
 * Description of DashboardController
 *
 * @author Pawan Kumar
 */
class DashboardController extends AppController
{

    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::DASHBOARD;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $params = [
            'selectCols' => new \yii\db\Expression("SUM(IF(`status`='0',1,0)) pending, 
                    SUM(IF(`status`='1',1,0))  vr_assigned, 
                    SUM(IF(`status`='2',1,0)) dr_assigned,
                    SUM(IF(`status`='3',1,0)) approved,
                    SUM(IF(`status`='4',1,0)) rejected,
                    SUM(IF(`status`='5',1,0)) discrepancy,
                    SUM(IF(`status`='6',1,0)) paid,
                    SUM(IF(`status`='7',1,0)) under_process"
            ),
        ];

        if (\Yii::$app->user->hasDealingHeadRole()) {
            $params = \yii\helpers\ArrayHelper::merge(['dealingHeadId' => Yii::$app->user->id], $params);
        }

        if (\Yii::$app->user->hasAssignmentOfficerRole()) {
            $params = \yii\helpers\ArrayHelper::merge(['Notnull' => TRUE], $params);
        }

        if (\Yii::$app->user->hasAccountManagerRole()) {
            $params = \yii\helpers\ArrayHelper::merge(['status' => \common\models\Grievance::APPROVED], $params);
        }

        $grievance = \common\models\Grievance::findGrievance($params);

        return $this->render('index', ['counters' => $grievance]);
    }

}
