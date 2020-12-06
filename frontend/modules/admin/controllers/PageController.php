<?php
namespace app\modules\admin\controllers;


use Yii;
use common\models\Page;
use common\models\search\PageSearch;
use common\models\caching\ModelCache;

/**
 * Description of PageController
 *
 * @author Pawan Kumar
 */
class PageController extends AppController
{
     
    public function actionIndex()
    {
        $searchModel = new PageSearch;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Page;
        $model->created_by = yii::$app->user->getId();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Page has been created successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute('page/index'));
            }
            else {
                $error = \yii\helpers\Html::errorSummary($model, ['header' => '']);
                Yii::$app->session->setFlash('error', $error);
            }
        }
        return $this->render('create', [
                    'model' => $model
        ]);
    }
    
    public function actionUpdate($guid)
    {
        $model = $this->findModel($guid);
        if (Yii::$app->request->isPost) {
            $model->updated_by = yii::$app->user->getId();
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Page Manager has been updated successfully');
                return $this->redirect(\yii\helpers\Url::toRoute('page/index'));
            }
            else {
                $error = \yii\helpers\Html::errorSummary($model, ['header' => '']);
                Yii::$app->session->setFlash('error', $error);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($guid)
    {
        try {
            $model = $this->findModel($guid);
            $model->delete();
            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException("Oops! You are trying to delete this page dosen't exist or deleted. ");
        }
    }
    
    public function actionStatus($guid)
    {
        try {
            $model = $this->findModel($guid);
            $status = ($model->status == ModelCache::STATUS_ACTIVE) ? ModelCache::STATUS_INACTIVE : ModelCache::STATUS_ACTIVE;
            $model->status = $status;
            $model->save(FALSE);
            return \components\Helper::outputJsonResponse(['success' => 1, 'status' => $status]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException("Oops! Your are trying to update this page doesn't exist or deleted.");
        }
    }
    

    /**
     * Finds the Page model based on its primary key value.
     * @param string $guid
     * @return object
     * @throws \components\exceptions\AppException
     */
    protected function findModel($guid)
    {
        if (($model = Page::findOne(['guid' => $guid])) !== null) {
            return $model;
        }
        throw new \components\exceptions\AppException("Oops! Your are trying to access this page doesn't exist or deleted.");
    }
   
}
