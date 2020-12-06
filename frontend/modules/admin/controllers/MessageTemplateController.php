<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\MessageTemplate;
use common\models\MessageTemplateSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\controllers\AppController;

/**
 * ListTypeController implements the CRUD actions for ListType model.
 */
class MessageTemplateController extends AppController
{
    /**
     * {@inheritdoc}
     */
   public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::MESSAGE_TEMPLATE;
        return parent::beforeAction($action);
    }

    /**
     * Lists all ListType models.
     * @return mixed
     */
    public function actionIndex()
    {
        try {

            $searchModel = new \common\models\search\MessageTemplateSearch();
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
     * Creates a new ListType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessageTemplate();
        $model->created_by = yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessMessage('Template has been added successfully.');
            return $this->redirect(\yii\helpers\Url::toRoute('index'));
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessMessage('Template has been updated successfully.');
            return $this->redirect(\yii\helpers\Url::toRoute('index'));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
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
     * Finds the ListType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($guid)
    {
        if (($model = MessageTemplate::findByGuid($guid,['resultFormat' => 'object'])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
