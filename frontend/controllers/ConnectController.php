<?php

namespace frontend\controllers;
use common\models\Contact;
use Yii;


/**
 * Description of ConnectController
 *
 * @author Amardeep Singh
 */
class ConnectController extends AppController
{  
    public function actionContact()
    {        
        $model = new Contact();
        
        if(Yii::$app->request->isPost)
        {            
            $model->type = 'contact';
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                return $this->refresh();
                
            } 
			else {
                Yii::$app->session->setFlash('error', \yii\helpers\Html::errorSummary($model));
            }            
        }
        
        return $this->render(\Yii::$app->controller->action->id, compact('model'));        
    }

    public function actionGrievance()
    {        
        $model = new Contact();
        
        if(Yii::$app->request->isPost)
        {            
            $model->type = 'grievance';
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Your Request has been submitted successfully.');
                return $this->refresh();                
            }
			else {
                Yii::$app->session->setFlash('error', \yii\helpers\Html::errorSummary($model));
            }            
        }
        
        return $this->render(\Yii::$app->controller->action->id, compact('model'));
    }
    
}
