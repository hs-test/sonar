<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\Company;
use common\models\caching\ModelCache;
use common\models\CompanySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\controllers\AppController;
use app\modules\admin\models\CompanyForm;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends AppController
{
    
    public function behaviors()
    {
        $controllerBehaviors = [
            'ajax' => [
                'class' => \components\filters\AjaxFilter::className(),
                'only' => ['company-info'],
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($controllerBehaviors, parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::COMPANY;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        try {
            $searchModel = new \common\models\search\CompanySearch();
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
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($guid)
    {
        try {
            $model = $this->findModel($guid);
            $htmlTemplate = $this->renderAjax('partials/_view-form.php', ['model' => $model]);
            return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
        }
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        $model->created_by = yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(\yii\helpers\Url::toRoute('index'));
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEdit($guid)
    {
        $model = $this->findModel($guid, ['resultFormat' => ModelCache::RETURN_TYPE_OBJECT]);

        $formModel = new CompanyForm();
        $formModel->setAttributes(CompanyForm::getCompanyFormData($model->id, $model->guid));

        if (\Yii::$app->request->isPost) {

            if ($formModel->load(\Yii::$app->request->post()) && $formModel->validate() && $formModel->save()) {
                \Yii::$app->session->setFlash('success', 'Company has been updated successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['company/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($formModel, ['header' => '']));
        }
        return $this->render('edit', [
                    'model' => $formModel,
        ]);
    }
    
    public function actionCompanyInfo($guid)
    {
        $companyModel = $this->findModel($guid, ['resultFormat' => ModelCache::RETURN_TYPE_OBJECT]);

        $model = new \common\models\CompanyDetail();
        $model->company_id = $companyModel->id;
        $success = 1;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_company-info-form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($guid)
    {

        try {
            $params = ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT];
            $companyModel = $this->findModel($guid, $params);

            if (!isset($companyModel) || empty($companyModel)) {
                throw new \components\exceptions\AppException("Oops! Look like class couldn't be deleted because there are related data in others managers.");
            }

            $companyModel->is_delete = Company::RECORD_DELETED_YES;
            $companyModel->is_active = Company::STATUS_INACTIVE;
            $companyModel->save();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }
    
    public function actionDeleteUser($id)
    {

        try {
            $params = ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT];
            $companyDetailModel = \common\models\CompanyDetail::findById($id, $params);

            if (empty($companyDetailModel)) {
                throw new \components\exceptions\AppException("Oops! Look like company user model not found.");
            }
            $companyDetailModel->delete();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }

    public function actionImport()
    {
        set_time_limit(-1);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $company = new \common\components\company\CompanyImport($model->response['orig'], $model->response['cdnPath']);
                $results = $company->import();
            }
        }
        return $this->render('import', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionImportCompanyDetails()
    {
        set_time_limit(-1);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $company = new \common\components\company\CompanyImport($model->response['orig'], $model->response['cdnPath']);
                $results = $company->detailsimport();
            }
        }
        return $this->render('import', [
                    'model' => $model,
                    'results' => $results
        ]);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($guid,$params=[])
    {
        if (($model = Company::findByGuid($guid,$params)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
