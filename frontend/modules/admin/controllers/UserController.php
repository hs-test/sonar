<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\User;
use common\models\caching\ModelCache;
use app\modules\admin\models\UserForm;
use app\modules\admin\controllers\AppController;

/**
 * Description of UserController
 *
 * @author Pawan
 */
class UserController extends AppController
{
    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::USER;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $queryParams = \Yii::$app->request->queryParams;
        $searchModel = new \common\models\search\UserSearch;
        if (\Yii::$app->user->hasAssignmentOfficerRole()) {
            $searchModel->role_id = User::ROLE_DEALING_HEAD;
            Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::DEALING_HEAD;
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('User has been added successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['user/index']));
            }
            $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($guid)
    {
        $userModel = $this->findByModel($guid);

        $model = new UserForm;
        $model->setScenario(UserForm::SCENARIO_USER_UPDATE);
        $model->attributes = $userModel->attributes;
        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('User has been updated successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['user/index']));
            }
            else {
                $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionProfile()
    {
        $userModel = $this->findByModel(Yii::$app->user->identity->guid);

        $model = new UserForm;
        $model->attributes = $userModel->attributes;
        $model->setScenario(UserForm::SCENARIO_USER_UPDATE);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                $this->setSuccessMessage('Profile has been updated successfully.');
                return $this->redirect(\yii\helpers\Url::toRoute(['user/profile']));
            }
            else {
                $this->setErrorMessage(\yii\helpers\Html::errorSummary($model, ['header' => '']));
            }
        }
        return $this->render('edit-profile', ['model' => $model, 'profile' => TRUE]);
    }

    public function actionAddPermission()
    {
        $postParams = Yii::$app->request->post();
        if (empty($postParams['userGuid']) || empty($postParams['stateCode'])) {
            throw new \components\exceptions\AppException("Invalid Request.");
        }

        $model = $this->findByModel($postParams['userGuid']);

        $state = \common\models\State::findByCode($postParams['stateCode']);
        if ($state === null) {
            throw new \components\exceptions\AppException("You are trying to access state doesn't exist or deleted.");
        }

        $userLoc = new \common\models\UserLocation;
        if ($model->role_id == User::ROLE_CPM || $model->role_id == User::ROLE_RAC_NODAL_OFFICER || $model->role_id == User::ROLE_STATE_USER) {

            //$name = $model->role_id == User::ROLE_CPM ? 'CPM' : 'RAC Nodal';
            $name = '';
            switch ($model->role_id) {
                case User::ROLE_CPM:
                    $name = 'CPM';
                    break;
                case User::ROLE_RAC_NODAL_OFFICER:
                    $name = 'RAC Nodal';
                    break;
                case User::ROLE_STATE_USER:
                    $name = 'State User';
                    break;

                default:
                    break;
            }
            if (\common\models\UserLocation::validateStateUser($postParams['stateCode'], $model->role_id)) {
                throw new \components\exceptions\AppException("Sorry, This state has already assigned $name Officer.");
            }

            $userLocId = $userLoc->saveLocation([
                'user_id' => $model->id,
                'state_code' => $state['code']
            ]);
            return \components\Helper::outputJsonResponse([
                        'success' => 1,
                        'id' => $userLocId,
                        'stateName' => $state['name']
            ]);
        }
        if ($model->role_id == User::ROLE_DISCOM_MD) {

            $district = \common\models\District::findByCode($postParams['districtCode']);
            if ($district === null) {
                throw new \components\exceptions\AppException("You are trying to access district doesn't exist or deleted.");
            }

            if (\common\models\UserLocation::validateStateDistrictUser($postParams['stateCode'], $postParams['districtCode'], $model->role_id)) {
                throw new \components\exceptions\AppException("Sorry, This district has already assigned Disom Md Officer.");
            }

            $userLocId = $userLoc->saveLocation([
                'user_id' => $model->id,
                'state_code' => $state['code'],
                'district_code' => $district['code']
            ]);

            return \components\Helper::outputJsonResponse([
                        'success' => 1,
                        'id' => $userLocId,
                        'stateName' => $state['name'],
                        'districtName' => $district['name']
            ]);
        }
        if ($model->role_id == User::ROLE_DISCOM_NODAL_OFFICER || $model->role_id == User::ROLE_DISCOM_MANAGER) {

            $district = \common\models\District::findByCode($postParams['districtCode']);
            if ($district === null) {
                throw new \components\exceptions\AppException("You are trying to access district doesn't exist or deleted.");
            }

            $discomMdUser = \common\models\UserLocation::getStateDistrictUser($postParams['stateCode'], $postParams['districtCode'], User::ROLE_DISCOM_MD);
            if (empty($discomMdUser)) {
                throw new \components\exceptions\AppException("Sorry, This district has no discom md officer.");
            }

            if (empty($model->parent_id)) {
                $model->parent_id = $discomMdUser['user_id'];
                $model->save(TRUE, ['parent_id']);
            }

            $userLocation = \common\models\UserLocation::findByUserId($model->parent_id, ['resultCount' => ModelCache::RETURN_ALL]);
            $userStates = \yii\helpers\ArrayHelper::getColumn($userLocation, 'state_code');

            $states = \common\models\State::getStateList(NULL, FALSE, ['inStateCode' => $userStates]);

            $userLocId = $userLoc->saveLocation([
                'user_id' => $model->id,
                'state_code' => $state['code'],
                'district_code' => $district['code']
            ]);

            return \components\Helper::outputJsonResponse([
                        'success' => 1,
                        'id' => $userLocId,
                        'stateName' => $state['name'],
                        'districtName' => $district['name'],
                        'states' => $states
            ]);
        }
    }

    public function actionRevokePermission()
    {
        $postParams = Yii::$app->request->post();
        if (empty($postParams['userGuid']) || empty($postParams['id'])) {
            throw new \components\exceptions\AppException("Invalid Request.");
        }

        $model = $this->findByModel($postParams['userGuid']);

        $userLocation = \common\models\UserLocation::findById($postParams['id'], [
                    'userId' => $model->id,
                    'resultFormat' => ModelCache::RETURN_TYPE_OBJECT
        ]);

        try {
            $userLocation->delete();
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }

        return \components\Helper::outputJsonResponse(['success' => 1]);
    }

    public function actionStatus($guid)
    {
        try {
            $model = $this->findByModel($guid);
            $status = ($model->status == User::STATUS_ACTIVE) ? User::STATUS_DELETED : User::STATUS_ACTIVE;
            $model->status = $status;
            $model->save(TRUE, ['status']);
            return \components\Helper::outputJsonResponse(['success' => 1, 'status' => $status]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException($ex->getMessage());
        }
    }

    public function actionDelete($guid)
    {
        $model = $this->findByModel($guid);
        try {
            $model->delete();
        }
        catch (\yii\db\Exception $ex) {
            throw new \components\exceptions\AppException('Sorry You can not delete this user because child records exists');
        }

        return \components\Helper::outputJsonResponse(['success' => 1]);
    }

    public function actionChangePassword($guid)
    {
        $model = new \app\modules\admin\models\ResetPasswordForm($guid);
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;

            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_change-password-form.php', [ 'model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
    }

    public function actionUpdateAllowedGrievance($guid)
    {
        $userModel = $this->findByModel($guid);
        //$model->scenario = 'allocate';
        $model = new \common\models\UserTargetLog();
        $model->user_id = $userModel->id;
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;

            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_udpate-allowed-grievance-form.php', [ 'model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
    }

    public function actionExport()
    {

        set_time_limit(-1);

        $queryParams = \Yii::$app->request->queryParams;
        $searchModel = new \common\models\search\UserSearch;
        $userModel = $searchModel->export($queryParams);


        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("REC Administrator")
                ->setTitle("User Data Export")
                ->setSubject("User Data Export")
                ->setDescription("User Data Export Sheet");

        $last = 'G';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("REC Control Center"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, ucwords("Corporate Office , New Delhi"));
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:' . $last . '3');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "User Report Export on(" . date('d M Y') . ")");
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
        $objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFont()->setBold(true)->setName('Times New Roman')->setSize(12)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "Total Records : " . count($userModel));

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A4:' . $last . '4')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);



        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A5', 'S.NO')
                ->setCellValue('B5', 'NAME')
                ->setCellValue('C5', 'ROLE')
                ->setCellValue('D5', 'MOBILE')
                ->setCellValue('E5', 'EMAIL')
                ->setCellValue('F5', 'STATE')
                ->setCellValue('G5', 'DISCOM');



        $lastCols = 'G';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);


        if (isset($userModel) && !empty($userModel)) {
            $i = 1;
            $counter = 6;
            foreach ($userModel as $user) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $user['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $user['role']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $user['mobile']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $user['email']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, (isset($user['stateName']) ? $user['stateName'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, (isset($user['discom']) ? $user['discom'] : '-'));
                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['user/export', 'UserSearch' => isset($queryParams['UserSearch']) ? $queryParams['UserSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="User-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function actionViewTargetLogs($id)
    {
        try {

            $model = \common\models\UserTargetLog::find()
                    ->select(['month', 'year', 'date', 'allocated', 'created_on'])
                    ->where('user_id=:userId', [':userId' => $id])
                    ->asArray()
                    ->all();

            if (empty($model)) {
                throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
            }
            $htmlTemplate = $this->renderPartial('/user/partials/_view-target-log.php', [ 'taregtLogs' => $model]);
            return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
        }
    }

    protected function findByModel($guid)
    {
        $model = User::findByGuid($guid, ['resultFormat' => ModelCache::RETURN_TYPE_OBJECT]);
        if ($model === null) {
            throw new \components\exceptions\AppException("You are trying to access user doesn't exist or deleted.");
        }
        return $model;
    }

}
