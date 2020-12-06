<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\AppController;
use Yii;

/**
 * Description of LocationController
 *
 * @author Pawan Kumar
 */
class LocationController extends AppController
{
    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::LOCATION;
        return parent::beforeAction($action);
    }

    public function actionState()
    {
        $searchModel = new \common\models\search\StateSearch;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);


        $model = new \common\models\State;
        return $this->render('state', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddState()
    {
        $model = new \common\models\State;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
    }

    public function actionUpdateState($guid)
    {
        $stateModel = \common\models\State::findStateModel($guid);
        $success = 1;
        if (\Yii::$app->request->isPost) {
            if ($stateModel->load(\Yii::$app->request->post()) && $stateModel->validate() && $stateModel->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $stateModel->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_state-form.php', ['model' => $stateModel]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionDeleteState($guid)
    {
        try {

            $stateModel = \common\models\State::findStateModel($guid);
            $childList = \common\models\District::getDistrictList($stateModel->code);
            if (count($childList) > 0) {
                return \components\Helper::outputJsonResponse(['success' => 0]);
            }
            $stateModel->delete();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \Exception("Oops! unable to deleted this resource. Please find below error :<br/><br/>" . $ex->getMessage());
        }
    }

    public function actionDistrict()
    {
        $searchModel = new \common\models\search\DistrictSearch;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $model = new \common\models\District;
        return $this->render('district', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddDistrict()
    {
        $model = new \common\models\District;
        $model->created_by = Yii::$app->user->id;
        $model->updated_by = Yii::$app->user->id;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
    }

    public function actionUpdateDistrict($guid)
    {
        $districtModel = \common\models\District::findDistrictModel($guid);
        $stateList = \common\models\State::getStateList();
        $blockList = \common\models\Block::getBlockList($districtModel->code);

        $districtModel->updated_by = Yii::$app->user->id;
        $success = 1;

        if (\Yii::$app->request->isPost) {
            if ($districtModel->load(\Yii::$app->request->post()) && $districtModel->validate() && $districtModel->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $districtModel->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_district-form.php', ['model' => $districtModel, 'stateList' => $stateList, 'blockList' => $blockList]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionDeleteDistrict($guid)
    {
        try {
            $districtModel = \common\models\District::findDistrictModel($guid);
            $childList = \common\models\Block::getBlockList($districtModel->code);
            if (count($childList) > 0) {
                return \components\Helper::outputJsonResponse(['success' => 0]);
            }
            $districtModel->delete();

            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \Exception("Oops! unable to deleted this resource. Please find below error :<br/><br/>" . $ex->getMessage());
        }
    }

//    public function actionBlock()
//    {
//        $searchModel = new \common\models\search\BlockSearch;
//        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//
//        $model = new \common\models\Block;
//        return $this->render('block', [
//                    'model' => $model,
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    public function actionAddBlock()
//    {
//        $model = new \common\models\Block;
//        $model->created_by = Yii::$app->user->id;
//        $model->updated_by = Yii::$app->user->id;
//        if (\Yii::$app->request->isPost) {
//            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
//                return \components\Helper::outputJsonResponse(['success' => 1]);
//            }
//            $errors = $model->errors;
//            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
//        }
//
//        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
//    }
//
//    public function actionUpdateBlock($guid)
//    {
//        $blockModel = \common\models\Block::findBlockModel($guid);
//        $stateList = \common\models\State::getStateList();
//        $districtList = \common\models\District::getDistrictList($blockModel->state_code);
//        $panchayatist = \common\models\Panchayat::getPanchayatList($blockModel->code);
//        $success = 1;
//
//        $blockModel->updated_by = Yii::$app->user->id;
//        if (\Yii::$app->request->isPost) {
//            if ($blockModel->load(\Yii::$app->request->post()) && $blockModel->validate() && $blockModel->save()) {
//                return \components\Helper::outputJsonResponse(['success' => 1]);
//            }
//            $errors = $blockModel->errors;
//            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
//        }
//
//        $htmlTemplate = $this->renderAjax('partials/_block-form.php', ['model' => $blockModel, 'stateList' => $stateList, 'districtList' => $districtList, 'panchayatist' => $panchayatist]);
//        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
//    }
//
//    public function actionDeleteBlock($guid)
//    {
//        try {
//
//            $blockModel = \common\models\Block::findBlockModel($guid);
//            $childList = \common\models\Panchayat::getPanchayatList($blockModel->code);
//            if (count($childList) > 0) {
//                return \components\Helper::outputJsonResponse(['success' => 0]);
//            }
//            $blockModel->delete();
//            return \components\Helper::outputJsonResponse(['success' => 1]);
//        }
//        catch (\Exception $ex) {
//            throw new \Exception("Oops! unable to deleted this resource. Please find below error :<br/><br/>" . $ex->getMessage());
//        }
//    }

//    public function actionPanchayat()
//    {
//        $searchModel = new \common\models\search\PanchayatSearch;
//        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//
//        $model = new \common\models\Panchayat;
//        return $this->render('panchayat', [
//                    'model' => $model,
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

//    public function actionAddPanchayat()
//    {
//        $model = new \common\models\Panchayat;
//        $model->created_by = Yii::$app->user->id;
//        $model->updated_by = Yii::$app->user->id;
//        if (\Yii::$app->request->isPost) {
//            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
//                return \components\Helper::outputJsonResponse(['success' => 1]);
//            }
//            $errors = $model->errors;
//            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
//        }
//
//        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
//    }

//    public function actionUpdatePanchayat($guid)
//    {
//        $panchayatModel = \common\models\Panchayat::findPanchayatModel($guid);
//        $stateList = \common\models\State::getStateList();
//        $districtList = \common\models\District::getDistrictList($panchayatModel->state_code);
//        $blockList = \common\models\Block::getBlockList($panchayatModel->district_code);
//        $villageList = \common\models\Village::getVillageList($panchayatModel->code);
//        $success = 1;
//
//        $panchayatModel->updated_by = Yii::$app->user->id;
//        if (\Yii::$app->request->isPost) {
//            if ($panchayatModel->load(\Yii::$app->request->post()) && $panchayatModel->validate() && $panchayatModel->save()) {
//                return \components\Helper::outputJsonResponse(['success' => 1]);
//            }
//            $errors = $panchayatModel->errors;
//            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
//        }
//        $htmlTemplate = $this->renderAjax('partials/_panchayat-form.php', ['model' => $panchayatModel, 'stateList' => $stateList, 'stateList' => $stateList, 'districtList' => $districtList, 'blockList' => $blockList, 'villageList' => $villageList]);
//        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
//    }
//
//    public function actionDeletePanchayat($guid)
//    {
//        try {
//            $panchayatModel = \common\models\Panchayat::findPanchayatModel($guid);
//            $childList = \common\models\Village::getVillageList($panchayatModel->code);
//            if (count($childList) > 0) {
//                return \components\Helper::outputJsonResponse(['success' => 0]);
//            }
//            $panchayatModel->delete();
//            return \components\Helper::outputJsonResponse(['success' => 1]);
//        }
//        catch (\Exception $ex) {
//            throw new \Exception("Oops! unable to deleted this resource. Please find below error :<br/><br/>" . $ex->getMessage());
//        }
//    }

    public function actionVillage()
    {
        $searchModel = new \common\models\search\VillageSearch;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $model = new \common\models\Village;
        return $this->render('village', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddVillage()
    {
        $model = new \common\models\Village;
        $model->created_by = Yii::$app->user->id;
        $model->updated_by = Yii::$app->user->id;
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
    }

    public function actionUpdateVillage($guid)
    {
        $villageModel = \common\models\Village::findVillageModel($guid);
        $stateList = \common\models\State::getStateList();
        $districtList = \common\models\District::getDistrictList($villageModel->state_code);
        $blockList = \common\models\Block::getBlockList($villageModel->district_code);
        $panchayatList = \common\models\Panchayat::getPanchayatList($villageModel->block_code);

        $villageModel->updated_by = Yii::$app->user->id;
        $success = 1;

        if (\Yii::$app->request->isPost) {
            if ($villageModel->load(\Yii::$app->request->post()) && $villageModel->validate() && $villageModel->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $villageModel->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_village-form.php', ['model' => $villageModel, 'stateList' => $stateList, 'districtList' => $districtList, 'blockList' => $blockList, 'panchayatList' => $panchayatList]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionDeleteVillage($guid)
    {
        try {
            $villageModel = \common\models\Village::findVillageModel($guid);
            $villageModel->delete();
            return \components\Helper::outputJsonResponse(['success' => 1]);
        }
        catch (\Exception $ex) {
            throw new \Exception("Oops! unable to deleted this resource. Please find below error :<br/><br/>" . $ex->getMessage());
        }
    }

    public function actionCascade()
    {
        if (\Yii::$app->request->isPost) {
            $val = \Yii::$app->request->post('val');
            $parent = \Yii::$app->request->post('parent');
            $districtIds = [];
            if (\Yii::$app->user->hasDiscomNodalOfficerRole() || \Yii::$app->user->hasDiscomMDRole() || \Yii::$app->user->hasDiscomOfficerRole()) {

                $userLocationModel = \common\models\UserLocation::findByUserId(\Yii::$app->user->id, ['selectCols' => ['user_location.district_code'], 'resultFormat' => 'array', 'resultCount' => 'all']);

                if (!empty($userLocationModel)) {
                    $districtIds = \yii\helpers\ArrayHelper::getColumn($userLocationModel, 'district_code');
                }
            }

            switch ($parent) {
                case 'state':
                    $data = \common\models\District::findByStateCode($val, [
                                'returnAll' => TRUE,
                                'inDistrictCode' => $districtIds,
                                'orderBy'=>['name' => SORT_ASC]
                    ]);
                    break;
                case 'district':
                    $data = \common\models\Village::findByDistrictCode($val, [
                                'returnAll' => TRUE,
                                'orderBy'=>['name' => SORT_ASC]
                    ]);
                    break;
                case 'block':
                    $data = \common\models\Panchayat::findByBlockCode($val, [
                                'returnAll' => TRUE,
                                'orderBy'=>['name' => SORT_ASC]
                    ]);
                    break;
                case 'panchayat':
                    $data = \common\models\Village::findByPanchayatCode($val, [
                                'returnAll' => TRUE,
                                'orderBy'=>['name' => SORT_ASC]
                    ]);
                    break;

                default:
                    break;
            }

            return \components\Helper::outputJsonResponse(['success' => 1, 'data' => $data]);
        }

        throw new \components\exceptions\AppException("Invalid Request");
    }

}
