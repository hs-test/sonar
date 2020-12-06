<?php

namespace frontend\controllers;
use common\models\Service;


/**
 * Description of ServicesController
 *
 * @author Amardeep Singh
 */
class ServicesController extends AppController
{
    
    public function actionView($slug)
    {
        
        $page = Service::findBySlug($slug, ['status'=>1]);
        
        if(!$page){
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $this->render('view', compact('page'));
        
    }
    
}
