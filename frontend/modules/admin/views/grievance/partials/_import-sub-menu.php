<?php

use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->params['allowSubmenu'] = TRUE;

$this->params['submenu'][] = ['title' => \Yii::t('admin', 'CDSL Import'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/cdsl-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(),'active' => $cdsl];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Download CDSL Format'), 'icon' => 'calendar-2', 'route' => \Yii::$app->params['staticHttpPath'] . '/dist/format/cdsl_format.csv', 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole()];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'NSDL Import'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/nsdl-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(),'active' => $nsdl];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Download NSDL Format'), 'icon' => 'calendar-2', 'route' => \Yii::$app->params['staticHttpPath'] . '/dist/format/nsdl_format.csv', 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole()];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Amount Import'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/amount-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(),'active' => $amount];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Download Amount Format'), 'icon' => 'calendar-2', 'route' => \Yii::$app->params['staticHttpPath'] . '/dist/format/amount_format.csv', 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole()];