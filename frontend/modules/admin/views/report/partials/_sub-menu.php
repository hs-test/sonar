<?php

use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->params['allowSubmenu'] = TRUE;
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'SRN Details Report'), 'icon' => 'employees', 'route' => Url::toRoute(['report/mis']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasSupervisorRole(), 'active' => ((isset($mis) && $mis) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Performance Report'), 'icon' => 'employees', 'route' => Url::toRoute(['report/performance']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasSupervisorRole(), 'active' => ((isset($performance) && $performance) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Status Report'), 'icon' => 'employees', 'route' => Url::toRoute(['report/status']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasSupervisorRole(), 'active' => ((isset($status) && $status) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Aging Report'), 'icon' => 'employees', 'route' => Url::toRoute(['report/aging']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasSupervisorRole(), 'active' => ((isset($aging) && $aging) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Status Compairison Report'), 'icon' => 'employees', 'route' => Url::toRoute(['report/status-comparison']), 'visible' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasSupervisorRole(), 'active' => ((isset($status) && $status) ? TRUE : FALSE)];
