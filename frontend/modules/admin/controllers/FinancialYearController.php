<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\FinancialYear;
use common\models\FinancialYearSearch;
use app\modules\admin\controllers\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinancialYearController implements the CRUD actions for FinancialYear model.
 */
class FinancialYearController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::FINANCIAL_YEAR;
        return parent::beforeAction($action);
    }

    /**
     * Lists all FinancialYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        try {

            $searchModel = new \common\models\search\FinancialYearSearch();
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
     * Displays a single FinancialYear model.
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
     * Creates a new FinancialYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinancialYear();
        $model->created_by = yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(\yii\helpers\Url::toRoute('index'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FinancialYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($guid)
    {
        $model = $this->findModel($guid);
        $model->modified_by = yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(\yii\helpers\Url::toRoute('index'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FinancialYear model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($guid)
    {
        try {

            $financialModel = $this->findModel($guid);
            
            if (!isset($financialModel) || empty($financialModel) ) {
                throw new \components\exceptions\AppException("Oops! Look like class couldn't be deleted because there are related data in others managers.");
            }

            $financialModel->is_delete = FinancialYear::RECORD_DELETED_YES;
            $financialModel->is_active = FinancialYear::STATUS_INACTIVE;
            $financialModel->save();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }

    /**
     * Finds the FinancialYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinancialYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($guid)
    {
        if (($model = FinancialYear::findByGuid($guid,['resultFormat' => 'object'])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
