<?php

namespace frontend\controllers;
use common\models\News;
use common\models\Slider;


/**
 * Description of MediaController
 *
 * @author Amardeep Singh
 */
class MediaController extends AppController
{
    
    public function actionNewsUpdates()
    {
        
        $news = News::find()->where(['status'=>1])->orderBy('id DESC')->all();
        
        return $this->render('news_updates', compact('news'));
    }
    
    
    public function actionNewsDetails($guid)
    {
        
        $model = News::findByGuid($guid);
        
        if($model == NULL){
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $this->render('news_details', compact('model'));
        
    }
    
    
    
    public function actionGallery()
    {
        $sliderList = Slider::find()
                ->where('type = :type', [':type' => 'gallery'])
                ->andWhere('status = 1')
                ->orderBy(['slider.id' => SORT_DESC])
                ->asArray()
                ->all();
        
        return $this->render('gallery', compact('sliderList'));
    }
    
}
