<?php

namespace frontend\controllers;

/**
 * Description of ErrorController
 *
 * @author Pawan Kumar
 */
class ErrorController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

}
