<?php

use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->params['allowSubmenu'] = TRUE;

$this->params['submenu'][] = ['title' => \Yii::t('admin', 'SRN'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($import) && $import) ? TRUE : FALSE)];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Import Summary'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/import-logs']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($importLog) && $importLog) ? TRUE : FALSE)];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Download Format'), 'icon' => 'calendar-2', 'route' => \Yii::$app->params['staticHttpPath'] . '/dist/format/format.csv', 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole()];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'VR'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/vr-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($vrimport) && $vrimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'DR'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/dr-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($drimport) && $drimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'APPROVED'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/approved-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($approvedimport) && $approvedimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'PAID'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/paid-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($paidimport) && $paidimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'UNDER PROCESS'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/under-process-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($underprocesimport) && $underprocesimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'VR REJECTION'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/vr-rejected-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($vrrejectedimport) && $vrrejectedimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'SENT FOR RESUBMISSION REJECTION'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/discrepancy-rejected-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(), 'active' => ((isset($discripancyrejectedimport) && $discripancyrejectedimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'SCAN'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/scan-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDealingHeadRole(), 'active' => ((isset($scanimport) && $scanimport) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'REVIEW'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['grievance/review-import']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDealingHeadRole(), 'active' => ((isset($reviewimport) && $reviewimport) ? TRUE : FALSE)];
