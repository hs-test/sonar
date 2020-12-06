<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\AppController;
use components\exceptions\AppException;

/**
 * Description of TypeController
 *
 * @author Ravi
 */
class TypeController extends AppController
{

    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE_TYPE;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $searchModel = new \common\models\search\TypeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    public function actionCreate()
    {
        $model = new \common\models\Type;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('grievance type created successfully!!.');
                return $this->redirect(\yii\helpers\Url::toRoute(['type/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($guid)
    {
        $model = $this->findByModel($guid);
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('grievance type updated successfully!!.');
                return $this->redirect(\yii\helpers\Url::toRoute(['type/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete($guid)
    {

        $model = $this->findByModel($guid);

        //Check Type in grivance table
        $typeModel = \common\models\Type::findByParentId($model->id, ['existOnly' => true]);
        if ($typeModel) {
            throw new AppException("Sorry You can not delete this type because child records exists.");
        }

        if (\common\models\Grievance::findByType($model->id, ['existOnly' => true])) {
            throw new AppException("Sorry You can not delete this type because its already use in grievance.");
        }
        $model->delete();
        return \components\Helper::outputJsonResponse(['success' => 1]);
    }
    
    public function actionStatus($guid)
    {
        try {
            $model = $this->findByModel($guid);
            $status = ($model->status == \common\models\caching\ModelCache::RECORD_IS_ACTIVE_YES) ? \common\models\caching\ModelCache::RECORD_IS_ACTIVE_NO : \common\models\caching\ModelCache::RECORD_IS_ACTIVE_YES;
            $model->status = $status;
            $model->save(TRUE, ['status']);
            return \components\Helper::outputJsonResponse(['success' => 1, 'status' => $status]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }

    protected function findByModel($guid)
    {
        $model = \common\models\Type::findByGuid($guid, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
        if ($model == null) {
            throw new AppException("Sorry, You trying to access type doesn't exist or deleted.");
        }

        return $model;
    }

}
