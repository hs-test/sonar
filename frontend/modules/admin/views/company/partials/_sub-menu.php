<?php

use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->params['allowSubmenu'] = TRUE;

$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Company'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['company/index']), 'visible' => Yii::$app->user->hasAdminRole(), 'active' => ((isset($company) && $company) ? TRUE : FALSE)];
$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Import'), 'icon' => 'calendar-2', 'route' => Url::toRoute(['company/import']), 'visible' => Yii::$app->user->hasAdminRole(), 'active' => ((isset($import) && $import) ? TRUE : FALSE)];
//$this->params['submenu'][] = ['title' => \Yii::t('admin', 'Download Format'), 'icon' => 'calendar-2', 'route' => \Yii::$app->params['staticHttpPath'] . '/dist/format/company.csv', 'visible' => Yii::$app->user->hasAdminRole()];
