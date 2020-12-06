<?php

namespace frontend\controllers;

use Yii;
use common\models\Page;
use common\models\search\PageSearch;
use common\models\News;
use common\models\Slider;
use common\models\search\VleSearch;

/**
 * Home controller
 */
class HomeController extends AppController
{
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'send-otp' || $action->id == 'verify-otp') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug = null)
    {     
         
//        $gallery = Slider::find()
//                ->select(['media.cdn_path','slider.type'])
//                ->innerJoin('slider_media', 'slider_media.slider_id = slider.id')
//                ->innerJoin('media', 'slider_media.media_id = media.id')
//                ->andWhere(['slider.status' => '1'])
//                ->limit(12)
//                ->asArray()
//                ->all();
//        
//        
//        $about = Page::findBySlug('about',['status'=>1]);
//        
//        $news = News::find()
//                ->where(['status'=>1])
//                ->orderBy('id DESC')
//                ->limit(5)
//                ->all();
//        
//        $totalSurveys = \common\models\Survey::getAll(); 
//        $bccCount = \common\models\Registration::getServiceCount(\common\models\Service::TYPE_BCC); 
//        $cccCount = \common\models\Registration::getServiceCount(\common\models\Service::TYPE_CCC); 
//        $tallyCount = \common\models\Registration::getServiceCount(\common\models\Service::TYPE_TALLY);
//        $facilitationCount = \common\models\VleFacilitation::getCount();
//        $healthKitCount = \common\models\VleHealthKitRegistration::getCount();
        
        return $this->render('index');
    }
    
    
    public function actionView($slug)
    {
        $page = Page::findBySlug($slug,['status'=>1]);
            
        if(!$page){
            throw new \yii\web\NotFoundHttpException;
        }
        
        
        return $this->render('view', compact('page'));
    }
    
    
    public function actionDigitalVillageList()
    {
        $searchModel = new VleSearch();
        $params = [
//            'role' => \common\models\Role::ROLE_VLE,
        ];
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $params);
        
        return $this->render('digital_village_list', compact('searchModel','dataProvider'));
        
    }
    
    
    public function actionSearchResult($q = '')
    { 
        $searchModel = new PageSearch;
        $searchModel->title = $q;
        
        if($q == ''){
            return $this->redirect('/');
        }
        
        $dataProvider = $searchModel->search(['title'=>$q], 1);
        
        
        return $this->render('search_results', compact('dataProvider','q'));
        
    }
    
    public function actionStatesCovered($type = 'survey')
    {
        $states = \common\models\State::getStatesCovered($type);

        return $this->render('states-covered', [
            'states' => $states,
            'type' => $type
        ]);
    }
    
    public function actionDistrictsCovered($stateCode, $type = 'survey')
    {
        $state = \common\models\State::findByCode($stateCode);
        if($state === NULL) {
            throw new \yii\web\NotFoundHttpException();
        }
        
        $districts = \common\models\District::getDistrictCovered($stateCode, $type);

        return $this->render('districts-covered', [
            'districts' => $districts,
            'state' => $state,
            'type' => $type
        ]);
    }

    public function actionTestEmail()
    {
        Yii::$app->awsSes->sendEmail([
            'to' => 'insphere.azam@gmail.com',
            'subject' => 'Test Email',
            'message' => 'Content goes here',
            'from' => 'admin@digital-village.in',
        ]);

        die('asdasd');
    }

    public function actionSendOtp()
    {

        if (\Yii::$app->request->isPost) {
            // send otp & email
            $postParams = \Yii::$app->request->post();

            $mobileNo = $postParams['mobile'];
            $email = $postParams['email'];
            $messageTemplate = 'Hi your OTP is 123456';

            Yii::$app->sms->send($mobileNo, $messageTemplate);

            if (\Yii::$app->sms->response['success']) {
                $template = $this->renderAjax('partials/_verify-otp.php', ['grievanceDetails' => $postParams]);
                return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $template]);
            }

            $errors = $model->errors;
            return \components\Helper::outputJsonResponse(['success' => 0, 'errors' => $errors]);
        }

        throw new \components\exceptions\AppException('Oops! Your request is not valid.');
    }
    
    
    public function actionVerifyOtp()
    {

        $model = new \app\modules\admin\models\GrievanceForm();

        if (\Yii::$app->request->isPost) {

            $postParams = Yii::$app->request->post();
            $model->name = $postParams['username'];
            $model->email = $postParams['email'];
            $model->mobile_no = $postParams['mobile'];
        }

        return $this->render('add-grievance', ['model' => $model]);
    }

}
