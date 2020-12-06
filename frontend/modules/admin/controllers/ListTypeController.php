<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\ListType;
use common\models\ListTypeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\controllers\AppController;

/**
 * ListTypeController implements the CRUD actions for ListType model.
 */
class ListTypeController extends AppController
{
    /**
     * {@inheritdoc}
     */
   public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::LIST_TYPE;
        return parent::beforeAction($action);
    }

    /**
     * Lists all ListType models.
     * @return mixed
     */
    public function actionIndex()
    {
        try {

            $searchModel = new \common\models\search\ListTypeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
        catch (Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessages());
        }
    }

    /**
     * Displays a single ListType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ListType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ListType();
        $model->created_by = yii::$app->user->getId();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('List type has been added successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['list-type/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ListType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($guid)
    {
        $model = $this->findModel($guid);
        $model->modified_by = yii::$app->user->getId();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('List type has been updated successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['list-type/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ListType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($guid)
    {
        try {

            $listtypeModel = $this->findModel($guid);

            if (!isset($listtypeModel) || empty($listtypeModel)) {
                throw new \components\exceptions\AppException("Oops! Look like class couldn't be deleted because there are related data in others managers.");
            }

            $listtypeModel->is_delete = ListType::RECORD_DELETED_YES;
            $listtypeModel->is_active = ListType::STATUS_INACTIVE;
            $listtypeModel->save();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }

    /**
     * Finds the ListType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($guid)
    {
        if (($model = ListType::findByGuid($guid,['resultFormat' => 'object'])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
