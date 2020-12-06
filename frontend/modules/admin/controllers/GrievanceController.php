<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\GrievanceForm;
use app\modules\admin\controllers\AppController;
use components\exceptions\AppException;
use common\models\User;
use app\modules\admin\models\UpdateStatusForm;
use app\modules\admin\models\MessageForm;
use app\modules\admin\models\CommentForm;

/**
 * Description of GrievanceController
 *
 * @author Ravi
 */
class GrievanceController extends AppController
{

    public function behaviors()
    {
        $controllerBehaviors = [
            'ajax' => [
                'class' => \components\filters\AjaxFilter::className(),
                'only' => ['delete', 'delete-multiple', 'status', 'description', 'get-list', 'template'],
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($controllerBehaviors, parent::behaviors());
    }

    public function beforeAction($action)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new \common\models\search\GrievanceSearch();

        if (\Yii::$app->user->hasAssignmentOfficerRole()) {
            $searchModel->notNullDhId = TRUE;
        }
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    public function actionView($guid)
    {
        try {
            $params['resultFormat'] = \common\models\caching\ModelCache::RETURN_TYPE_OBJECT;

            if (\Yii::$app->user->hasDealingHeadRole()) {
                $params['dealingHeadId'] = Yii::$app->user->id;
            }


            $model = \common\models\Grievance::findByGuid($guid, $params);
            if ($model == null) {
                throw new AppException("Sorry, You trying to access type doesn't exist or deleted.");
            }

            //get activity logs
            $i = $j = $k = 0;
            $grievanceLogs = [];
            $activityLogsParams = [
                'selectCols' => ['grievance_activity_log.id','date', 'description', 'grievance_status', 'comments', 'additional_comment','user.name', 'role.name as roleName', 'grievance_activity_log.created_on'],
                'joinWithUser' => 'innerJoin',
                'joinWithRole' => 'innerJoin',
                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
            ];
            $activityLogsModel = \common\models\GrievanceActivityLog::findByGrievanceId($model->id, $activityLogsParams);

            if (isset($activityLogsModel) && !empty($activityLogsModel)) {
                foreach ($activityLogsModel as $activityLogs) {
                    
                    // multipleComments 
                    $grievanceActivityLogComments = \common\models\GrievanceActivityComment::findByGrievanceActivityId($activityLogs['id'], [
                                'selectCols' => ['grievance_activity_comment.comment', 'user.name', 'grievance_activity_comment.created_on'],
                                'joinWithUser' => 'innerJoin',
                                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
                    ]);

                    $grievanceLogs[$i] = [
                        'id' => $activityLogs['id'],
                        'date' => date('d-m-Y', strtotime($activityLogs['date'])),
                        'description' => $activityLogs['description'],
                        'status' => \common\models\Grievance::getGrievanceStatusArr($activityLogs['grievance_status']),
                        'comments' => $activityLogs['comments'],
                        'username' => $activityLogs['name'],
                        'role' => $activityLogs['roleName'],
                        'additional_comment' => $activityLogs['additional_comment'],
                        'multipleComments' => $grievanceActivityLogComments
                    ];
                    $i++;
                }
            }
                
            // grievance assign logs
            $grievanceAssignLogs = [];
            $assignLogsParams = [
                'selectCols' => ['grievance_assign_log.created_on', 'previousDealingHead.name as prvDh', 'newDealingHead.name as  newDh', 'user.name as  assignedBy', 'role.name as roleName'],
                'joinWithUser' => 'innerJoin',
                'joinWithPreviousDealing' => 'innerJoin',
                'joinWithNewDealing' => 'innerJoin',
                'joinWithRole' => 'innerJoin',
                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
            ];
            $assignLogsModel = \common\models\GrievanceAssignLog::findByGrievanceId($model->id, $assignLogsParams);

            if (isset($assignLogsModel) && !empty($assignLogsModel)) {
                foreach ($assignLogsModel as $assignLogs) {
                    $grievanceAssignLogs[$j]['date'] = date('d-m-Y', $assignLogs['created_on']);
                    $grievanceAssignLogs[$j]['previousDealingHead'] = $assignLogs['prvDh'];
                    $grievanceAssignLogs[$j]['newDealingHead'] = $assignLogs['newDh'];
                    $grievanceAssignLogs[$j]['assignedBy'] = $assignLogs['assignedBy'];
                    $grievanceAssignLogs[$j]['role'] = $assignLogs['roleName'];
                    $j++;
                }
            }

            // grievance cc comments
            $comments = [];
            $ccParams = [
                'selectCols' => ['grievance_cc_comment.created_on', 'grievance_cc_comment.comment', 'grievance_cc_comment.created_on', 'user.name', 'role.name as roleName'],
                'joinWithUser' => 'innerJoin',
                'joinWithRole' => 'innerJoin',
                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
            ];
            $ccCommentModel = \common\models\GrievanceCcComment::findByGrievanceId($model->id, $ccParams);

            $comments = new \yii\data\ArrayDataProvider([
                'allModels' => $ccCommentModel,
                'pagination' => [
                    'pageSize' => 100,
                    'params' => \Yii::$app->request->queryParams,
                ],
            ]);

            // message log summary
            $messageLogDetailModel = \common\models\GrievanceMessageLog::getMessageLogDetails($model->id);
            $applicantMessageLog = new \yii\data\ArrayDataProvider([
                'allModels' => !empty($messageLogDetailModel['APPLICANT']) ? $messageLogDetailModel['APPLICANT'] : [],
                'pagination' => [
                    'pageSize' => 100,
                    'params' => \Yii::$app->request->queryParams,
                ],
            ]);
            $companyMessageLog = new \yii\data\ArrayDataProvider([
                'allModels' => !empty($messageLogDetailModel['COMPANY']) ? $messageLogDetailModel['COMPANY'] : [],
                'pagination' => [
                    'pageSize' => 100,
                    'params' => \Yii::$app->request->queryParams,
                ],
            ]);
            
            //grievance scan review logs
            $scanreviewParams = [
                'selectCols' => ['grievance_scan_review.type', 'grievance_scan_review.date', 'grievance_scan_review.reason', 'grievance_scan_review.comment','grievance_scan_review.created_on','user.name', 'role.name as roleName'],
                'joinWithUser' => 'innerJoin',
                'joinWithRole' => 'innerJoin',
                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
            ];
            $scanreviewModel = \common\models\GrievanceScanReview::findByGrievanceId($model->id, $scanreviewParams);
                
            return $this->render('view', compact('model', 'grievanceLogs', 'grievanceAssignLogs', 'comments', 'guid', 'applicantMessageLog', 'companyMessageLog','scanreviewModel'));
        }
        catch (Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
        }
    }

    public function actionAddComment($guid)
    {

        $model = new CommentForm();

        $success = 1;
        if (\Yii::$app->request->isPost) {
            $grievanceModel = $this->findByModel($guid);
            $model->grievance_id = $grievanceModel->id;

            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_add-comment-form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }
    
    public function actionUpdateDepository($guid)
    {
        $model = $this->findByModel($guid);
        $model->scenario = 'depository';
        if (empty($model->security_depository_type)) {
            throw new \components\exceptions\AppException('Oops! Depository type cannot be update.');
        }

        $success = 1;
        if (\Yii::$app->request->isPost) {
            $model->modified_by = Yii::$app->user->id;
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_grievance-depository-form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionAdditionalDetail($guid)
    {
        $model = $this->findByModel($guid);
        $model->scenario = 'additional-detail';

        $success = 1;
        if (\Yii::$app->request->isPost) {
            $model->modified_by = Yii::$app->user->id;
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_grievance-additional-detail-form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionGrievanceMessageView($id)
    {
        try {

            $model = \common\models\GrievanceMessageLog::findById($id, ['selectCols' => ['grievance_message_log.message']]);

            if (empty($model)) {
                throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
            }
            $htmlTemplate = $this->renderPartial('/grievance/partials/_view-message-log.php', [ 'model' => $model]);
            return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
        }
    }

    public function actionImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->import();
            }
        }
        return $this->render('import', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionVrImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->Vrimport();
            }
        }
        return $this->render('import-vr', [
                    'model' => $model,
                    'results' => $results
        ]);
    }

    public function actionDrImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->Drimport();
            }
        }
        return $this->render('import-dr', [
                    'model' => $model,
                    'results' => $results
        ]);
    }

    public function actionCdslImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE_IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->cdslImport();
            }
        }
        return $this->render('import_common', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionNsdlImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE_IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->nsdlImport();
            }
        }
        return $this->render('import_common', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionAmountImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE_IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->amountImport();
            }
        }
        return $this->render('import_common', [
                    'model' => $model,
                    'results' => $results
        ]);
    }

    public function actionImportLogs($type)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        $searchModel = new \common\models\search\GrievanceStatSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('import-logs', compact('searchModel', 'dataProvider'));
    }

    public function actionImportStatView($id)
    {
        try {
            $params = [
                'selectCols' => ['grievance_stat.logs', 'grievance_stat.company_logs'],
            ];
            $model = \common\models\GrievanceStat::findById($id, $params);


            if (empty($model)) {
                throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
            }
            $htmlTemplate = $this->renderPartial('/grievance/partials/_view-stat.php', [ 'model' => $model]);
            return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Data you trying to access doesn\'t exist.');
        }
    }

    public function actionDescriptionToken()
    {
        try {

            $postparams = Yii::$app->request->post();

            if (!isset($postparams['guid']) || empty($postparams['guid'])) {
                throw new \components\exceptions\AppException('Oops! Grievance guid cannot be blank.');
            }
            if (!isset($postparams['date']) || empty($postparams['date'])) {
                throw new \components\exceptions\AppException('Oops! Grievance date cannot be blank.');
            }

            $grievanceModel = $this->findByModel($postparams['guid']);
            $token = \common\models\GrievanceActivityLog::GenerateTrackingNo($postparams['date']);

            return \components\Helper::outputJsonResponse(['success' => 1, 'token' => $token]);
        }
        catch (\Exception $ex) {
            throw new \components\exceptions\AppException('Oops! Error raised during token creation.' . $ex->getMessage());
        }
    }

    public function actionUpdateStatus($guid)
    {
        $model = new UpdateStatusForm();
        $srnModel = $this->findByModel($guid);
        $model->security_depository_type = $srnModel->security_depository_type;
                

        if (\Yii::$app->user->hasDispatchExecuitveRole()) {
            $model->scenario = UpdateStatusForm::SCENARIO_USER_DISPATCH_EXECUTIVE;
        }
                
        $success = 1;
        if (\Yii::$app->request->isPost) {
            $model->grievance_guid = $guid;
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1, 'guid' => $guid, 'grievance_activity_id' => $model->grievance_activity_id]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_grievance-status-form.php', ['model' => $model, 'srnmodel' => $srnModel, 'url' => \yii\helpers\Url::toRoute(['grievance/update-status', 'guid' => $guid])]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    public function actionReassign()
    {
        if (!\Yii::$app->request->isPost) {
            throw new \components\exceptions\AppException('Oops! Invalid Request.');
        }
        $requestParams = \Yii::$app->request->post();

        if (isset($requestParams['guidList']) && !empty($requestParams['guidList'])) {

            $errors = [];
            $success = $failed = 0;
            foreach ($requestParams['guidList'] as $guid) {

                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $grievanceModel = \common\models\Grievance::findByGuid($guid, ['resultFormat' => \common\models\ caching\ModelCache::RETURN_TYPE_OBJECT]);

                    if (empty($grievanceModel)) {
                        throw new \components\exceptions\AppException('Grievance not found');
                    }

                    //update assigned counter for dealing head
                    $assignedDealingHeadModel = User::findById($requestParams['dealing_head'], ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT, 'isLimitAcheived' => 0, 'notEmptyAllowedGrievance' => 0]);
                    if (empty($assignedDealingHeadModel)) {
                        throw new \components\exceptions\AppException('Assigned dealing head not found or allowed SRN limit exceed');
                    }


                    $assignedDealingHeadModel->allocated_grievance = $assignedDealingHeadModel->allocated_grievance + 1;
                    $assignedDealingHeadModel->is_last_allocated = User::IS_LAST_ALLOCATED_YES;

                    $userTarget = User::findUserTarget($assignedDealingHeadModel->id, $params = [], date('m'));
                    if (empty($userTarget)) {
                        throw new \components\exceptions\AppException('Dealing head SRN not allocated.');
                    }

                    if ($assignedDealingHeadModel->allocated_grievance == $userTarget) {
                        $assignedDealingHeadModel->is_limit_achieved = 1;
                    }

                    if (!$assignedDealingHeadModel->save(TRUE, ['allocated_grievance', 'is_last_allocated', 'is_limit_achieved'])) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($assignedDealingHeadModel, ['header' => '']));
                    }

                    // update allocated counter of dealing head
                    $previousDealingHeadModel = User::findById($grievanceModel->dh_id, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
                    if (empty($previousDealingHeadModel)) {
                        throw new \components\exceptions\AppException('Previous dealing head not found');
                    }
                    $previousDealingHeadModel->allocated_grievance = $previousDealingHeadModel->allocated_grievance - 1;
                    $previousDealingHeadModel->is_last_allocated = User::IS_LAST_ALLOCATED_NO;

                    $previoususerTarget = User::findUserTarget($previousDealingHeadModel->id, $params = [], date('m'));
                    if (empty($previoususerTarget)) {
                        throw new \components\exceptions\AppException('Dealing head SRN not allocated.');
                    }

                    if ($previousDealingHeadModel->allocated_grievance < $previoususerTarget) {
                        $previousDealingHeadModel->is_limit_achieved = 0;
                    }


                    if (!$previousDealingHeadModel->save(TRUE, ['allocated_grievance', 'is_last_allocated', 'is_limit_achieved'])) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($previousDealingHeadModel, ['header' => '']));
                    }
                    else {
                        // update if any previous is allocated set
                        User::updateAll([
                            'is_last_allocated' => User::IS_LAST_ALLOCATED_NO,
                                ], 'id !=:userId', [':userId' => $assignedDealingHeadModel->id]);
                    }

                    // update into grievance assign log
                    $grievanceAssignModel = new \common\models\GrievanceAssignLog();
                    $grievanceAssignModel->isNewRecord = TRUE;
                    $grievanceAssignModel->grievance_id = $grievanceModel->id;
                    $grievanceAssignModel->prv_dh_id = $grievanceModel->dh_id;
                    $grievanceAssignModel->new_dh_id = $requestParams['dealing_head'];
                    $grievanceAssignModel->created_by = \Yii::$app->user->id;
                    if (!$grievanceAssignModel->save()) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceAssignModel, ['header' => '']));
                    }

                    // update grievance dealing head id
                    $grievanceModel->dh_id = $assignedDealingHeadModel->id;
                    if (!$grievanceModel->save(TRUE, ['dh_id'])) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                    }

                    $transaction->commit();
                    $success = $success + 1;
                }
                catch (\Exception $ex) {
                    $failed = $failed + 1;
                    $errors[] = "Error with srn no -{$grievanceModel->srn_no}: " . $ex->getMessage();
                    $transaction->rollBack();
                    continue;
                }
            }

            return \components\Helper::outputJsonResponse([
                        'errors' => $errors,
                        'totalRecords' => $success + $failed,
                        'failedRecords' => $failed,
                        'successRecords' => $success
            ]);
        }
    }

    public function actionGetList()
    {
        if (\Yii::$app->request->isPost) {
            $type = \Yii::$app->request->post('type');
            $optionGroup = FALSE;
            switch ($type) {
                case 'DISCREPANCY':
                    $optionGroup = TRUE;
                    $category = [
                        \common\models\ListType::TYPE_KYC,
                        \common\models\ListType::TYPE_FORM,
                        \common\models\ListType::TYPE_ENTITLEMENT,
                        \common\models\ListType::TYPE_COMPANY_RELATED_DISCREPANCIES,
                        \common\models\ListType::TYPE_TRANSMISSION,
                    ];
                    $data = \common\models\ListType::getListTypeDropdown(['categories' => $category, 'optionGroup' => $optionGroup]);

                    break;
                case 'REJECTED':
                    $data = \common\models\ListType::getListTypeDropdown(['categories' => \common\models\ListType::TYPE_REJECTION]);
                    break;

                default:
                    break;
            }

            return \components\Helper::outputJsonResponse(['success' => 1, 'list' => $data, 'optionGroup' => $optionGroup]);
        }

        throw new \components\exceptions\AppException("Invalid Request");
    }

    public function actionGetDealingHead()
    {
        if (\Yii::$app->request->isPost) {
            $users = \Yii::$app->request->post('dh');

            $model = User::findByRoleId(User::ROLE_DEALING_HEAD, ['selectCols' => ['user.id', 'user.name'], 'status' => User::STATUS_ACTIVE, 'userNotIn' => $users, 'resultCount' => \common\models\caching\ModelCache::RETURN_ALL]);
            $list = [];
            if (!empty($model)) {
                $list = \yii\helpers\ArrayHelper::map($model, 'id', 'name');
            }
            $htmlTemplate = $this->renderAjax('partials/_grievance-reassigned-form.php', ['userList' => $list]);
            return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
        }

        throw new \components\exceptions\AppException("Invalid Request");
    }

    public function actionTemplate($id)
    {

        $model = new MessageForm();
        $grievanceActivityModel = \common\models\GrievanceActivityLog::findById($id, [
                    'selectCols' => ['company.name', 'grievance.srn_no', 'grievance.applicant_name', 'grievance_activity_log.grievance_id', 'grievance_activity_log.grievance_status', 'grievance_activity_log.comments', 'grievance_activity_log.created_on'],
                    'joinWithGrievance' => 'innerJoin',
                    'joinWithCompany' => 'innerJoin'
        ]);

        if (empty($grievanceActivityModel)) {
            throw new \components\exceptions\AppException("Grievance Activity model not found");
        }

        switch ($grievanceActivityModel['grievance_status']) {
            case \common\models\Grievance::APPROVED:

                $service = \common\models\MessageTemplate::SERVICE_SRN_APPROVAL;

                break;
            case \common\models\Grievance::REJECTED:

                $service = \common\models\MessageTemplate::SERVICE_SRN_REJECTION;
                break;
            case \common\models\Grievance::DISCREPANCY:

                $service = \common\models\MessageTemplate::SERVICE_SRN_DISCRIPANCY;
                break;

            case \common\models\Grievance::PAID:

                $service = \common\models\MessageTemplate::SERVICE_SRN_SANCATION;
                break;

            default:
                break;
        }

        $messageTemplateParams = [
            'selectCols' => ['message_template.id', 'message_template.title', 'message_template.service', 'message_template.template'],
        ];

        $messageTemplate = \common\models\MessageTemplate::findByService($service, $messageTemplateParams);
        if (empty($messageTemplate)) {
            throw new \components\exceptions\AppException("Oops! message template not found.");
        }

        $comments = \common\models\GrievanceActivityLog::getComments($grievanceActivityModel['comments'], TRUE);
        
        $templateParams = [
            'srn_no' => $grievanceActivityModel['srn_no'],
            'srn_date' => \Yii::$app->formatter->asDate(date('Y-m-d', $grievanceActivityModel['created_on']), 'long'),
            'company_name' => $grievanceActivityModel['name'],
            'applicant_name' => $grievanceActivityModel['applicant_name'],
            'comments' => $comments,
            'content' => $messageTemplate['template']
        ];

        $template = \common\models\MessageTemplate::buildTemplate($templateParams);

        $model->subject = \common\models\MessageTemplate::buildTemplate(['srn_no' => $grievanceActivityModel['srn_no'], 'company_name' => $grievanceActivityModel['name'], 'srn_date' => \Yii::$app->formatter->asDate(date('Y-m-d', $grievanceActivityModel['created_on']), 'long'), 'content' => $messageTemplate['title']]);
        $model->message = $template;
        $model->grievance_id = $grievanceActivityModel['grievance_id'];
        $model->message_id = $messageTemplate['id'];
        $model->grievance_activity_id = $id;

        $messageLogModel = \common\models\GrievanceMessageLog::findByGrievanceId($grievanceActivityModel['grievance_id'], ['messageId' => $messageTemplate['id']]);
        if (!empty($messageLogModel)) {
            $model->setAttributes(MessageForm::getMessageFormData($messageLogModel['id']));
        }

        $success = 1;
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_grievance-message-template.php', ['model' => $model, 'grievanceActivity' => $grievanceActivityModel]);
        return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $htmlTemplate]);
    }

    public function actionExport()
    {
        set_time_limit(-1);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("School Administrator")
                ->setTitle("Grievance Data Export")
                ->setSubject("Grievance Data Export")
                ->setDescription("Grievance Data Export Sheet");
        $last = 'F';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords(Yii::$app->params['applicationName']));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'S.NO')
                ->setCellValue('B2', 'DATE')
                ->setCellValue('C2', 'STATE')
                ->setCellValue('D2', 'DISTRICT')
                ->setCellValue('E2', 'DISCOM')
                ->setCellValue('F2', 'GRIEVANCE NO');

        $lastCols = 'F';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);


        $params = [

            'selectCols' => [
                'grievance.grievance_no',
                'state.name as stateName', 'district.name as districtName',
                'village.name as villageName',
                'grievance.created_at as grievancePostedDate',
            ],
            'joinWithState' => 'innerJoin',
            'joinWithDistrict' => 'leftJoin',
            'joinWithVillage' => 'leftJoin',
            'resultFormat' => 'array',
            'resultCount' => 'all',
            'orderBy' => ['grievance.created_at' => SORT_DESC]
        ];



        $grievanceModel = \common\models\Grievance::findGrievance($params);

        if (isset($grievanceModel) && !empty($grievanceModel)) {
            $i = 1;
            $counter = 3;
            foreach ($grievanceModel as $grievance) {

                $discomName = '';
                if (isset($grievance['grievance_no'])) {

                    $explodeGrievanceNo = explode('/', $grievance['grievance_no']);
                    $discomName = (isset($explodeGrievanceNo[2])) ? $explodeGrievanceNo[2] : '-';
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, date('d-m-Y', $grievance['grievancePostedDate']));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance['stateName']) ? $grievance['stateName'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, (isset($grievance['districtName']) ? $grievance['districtName'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $discomName);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, (isset($grievance['grievance_no']) ? $grievance['grievance_no'] : '-'));
                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['grievance/index', 'StudentSearch' => $queryParams['StudentSearch']]));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="students.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function actionImportDepositoryLogs($type)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::GRIEVANCE_IMPORT;
        if (empty($type)) {
            throw new AppException("Sorry, Type cannot be blank.");
        }

        $searchModel = new \common\models\search\GrievanceStatSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('depository-logs', compact('searchModel', 'dataProvider'));
    }
    
    public function actionImportVrDrLogs($type)
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        if (empty($type)) {
            throw new AppException("Sorry, Type cannot be blank.");
        }

        $searchModel = new \common\models\search\GrievanceStatSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('depository-logs', compact('searchModel', 'dataProvider'));
    }

    public function actionDownloadLetter($guid)
    {
        $grievanceModel = $this->findByModel($guid);
        $messageTemplateParams = [
            'selectCols' => ['message_template.template'],
        ];

        $messageTemplate = \common\models\MessageTemplate::findByService(\common\models\MessageTemplate::SERVICE_SRN_SANCATION, $messageTemplateParams);
        if (empty($messageTemplate)) {
            throw new \components\exceptions\AppException("Oops! message template not found.");
        }

        $templateParams = [
            'srn_no' => $grievanceModel->srn_no,
            'srn_date' => date('Y-m-d', strtotime($grievanceModel->posting_date)),
            'applicant_name' => $grievanceModel->applicant_name,
            'bank_name' => $grievanceModel->applicant_bank_name,
            'ifsc_code' => $grievanceModel->applicant_micr_code,
            'account_no' => $grievanceModel->applicant_bank_account_no,
            'requested_total_amount' => $grievanceModel->requested_total_amount,
            'requested_total_amount_in_word' => \components\Helper::currencyFormat($grievanceModel->requested_total_amount),
            'content' => $messageTemplate['template']
        ];

        $template = \common\models\MessageTemplate::buildTemplate($templateParams);
        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Sanction-Letter.doc");
        return $template;
    }

    public function actionDownloadGar($guid)
    {
        $grievanceModel = $this->findByModel($guid);
        if (!Yii::$app->user->hasAccountManagerRole() && $grievanceModel->status !== \common\models\Grievance::APPROVED) {

            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['grievance/view', 'guid' => $guid]));
        }
        $messageTemplateParams = [
            'selectCols' => ['message_template.template'],
        ];

        $messageTemplate = \common\models\MessageTemplate::findByService(\common\models\MessageTemplate::SERVICE_SRN_GAR, $messageTemplateParams);
        if (empty($messageTemplate)) {
            throw new \components\exceptions\AppException("Oops! message template not found.");
        }

        $templateParams = [
            'srn_no' => $grievanceModel->srn_no,
            'bank_name' => $grievanceModel->applicant_bank_name,
            'refund_amount' => $grievanceModel->refund_amount,
            'content' => $messageTemplate['template']
        ];

        $template = \common\models\MessageTemplate::buildTemplate($templateParams);
        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=GAR-Letter.doc");
        return $template;
    }

    public function actionAddMultipleComment($id)
    {

        $grievanceActivityModel = \common\models\GrievanceActivityLog::findById($id);

        if ($grievanceActivityModel == NULL) {
            throw new AppException("Sorry, Grievance activity model not found.");
        }
        $model = new \common\models\GrievanceActivityComment();
        $model->grievance_activity_id = $grievanceActivityModel['id'];
        $model->created_by = Yii::$app->user->id;

        $success = 1;
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        $htmlTemplate = $this->renderAjax('partials/_multiple-comment-form.php', ['model' => $model]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

    protected function findByModel($guid)
    {
        $model = \common\models\Grievance::findByGuid($guid, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
        if ($model == null) {
            throw new AppException("Sorry, You trying to access type doesn't exist or deleted.");
        }

        return $model;
    }
    
    public function actionApprovedImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->ApprovedImport();
            }
        }
        return $this->render('import-approved', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionPaidImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->PaidImport();
            }
        }
        return $this->render('import-paid', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
     public function actionUnderProcessImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->UnderProcessImport();
            }
        }
        return $this->render('import-underprocess', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionVrRejectedImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->VrRejected();
            }
        }
        return $this->render('import-vr-rejected', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionDiscrepancyRejectedImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->DiscrepancyRejected();
            }
        }
        return $this->render('import-discrepancy-rejected', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
    public function actionScanImport()
    {
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->ScanImport();
            }
        }
        return $this->render('import-scan', [
                    'model' => $model,
                    'results' => $results
        ]);
    }
    
     public function actionReviewImport()
    {
        if (!\Yii::$app->user->hasAdminRole() && !\Yii::$app->user->hasDealingHeadRole()) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }
        
        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::IMPORT;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $results = [];
        $model = new \app\modules\admin\models\ImportForm;
        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $grievanceWorker = new \common\components\workers\GrievanceWorker($model->response['orig'], $model->response['cdnPath']);
                $results = $grievanceWorker->ReviewImport();
            }
        }
        return $this->render('import-review', [
                    'model' => $model,
                    'results' => $results
        ]);
    }

    public function actionScanReview($guid)
    {
        if (!\Yii::$app->user->hasAdminRole() && !\Yii::$app->user->hasDealingHeadRole()) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }

        $model = new \app\modules\admin\models\ScanReviewForm();
        $grievanceModel = $this->findByModel($guid);
        $success = 1;
        if (\Yii::$app->request->isPost) {
            $model->grievance_id = $grievanceModel->id;
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }
        $htmlTemplate = $this->renderAjax('partials/_scan-review-form.php', ['model' => $model, 'is_scan' => $grievanceModel->is_scan, 'is_review' => $grievanceModel->is_review]);
        return \components\Helper::outputJsonResponse(['success' => $success, 'template' => $htmlTemplate]);
    }

}
