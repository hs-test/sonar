<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\admin\controllers;

use Yii;
use common\models\Discom;
use common\models\search\DiscomSearch;

/**
 * Description of DiscomController
 *
 * @author Pawan
 */
class DiscomController extends AppController
{
    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::DISCOM;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new DiscomSearch;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
                    'model' => new Discom,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Discom;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = \components\Helper::convertModelErrorsToString($model->errors);
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
    }

    public function actionUpdate($guid)
    {

        $success = 1;
        $model = $this->findModel($guid);
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionDelete($guid)
    {
        $model = $this->findModel($guid);
        try {
            $model->delete();
        }
        catch (\yii\db\Exception $ex) {
            throw new \components\exceptions\AppException('Sorry You can not delete this discom because child records exists');
        }

        return \components\Helper::outputJsonResponse(['success' => 1]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * @param string $guid
     * @return object
     * @throws \components\exceptions\AppException
     */
    protected function findModel($guid)
    {
        if (($model = Discom::findByGuid($guid, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT])) !== null) {
            return $model;
        }
        throw new \components\exceptions\AppException("Oops! Your are trying to access this discom doesn't exist or deleted.");
    }

}
