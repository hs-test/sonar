<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Reports';
?>
<?= $this->render('partials/_sub-menu.php') ?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <div class="sub-linking ">
                        <ul class="sub-linking__navs">
                            <li class="sub-linking__navs--items">
                                <a href="javascript:;">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span> 
                                    <span class="sub-linking__navs--items--label">General Report</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/academic-year/index">
                                    <span class="sub-linking__navs--items--image">
                                    <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span>
                                    <span class="sub-linking__navs--items--label">Executive Report</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/school/settings">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span>
                                    <span class="sub-linking__navs--items--label">Aging Report</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/page-manager/index">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive"> 
                                    </span>
                                    <span class="sub-linking__navs--items--label">Discom Report Summary</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/menu/index">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span>
                                    <span class="sub-linking__navs--items--label">Discom Report Details</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/slider/index">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span>
                                    <span class="sub-linking__navs--items--label">Daily Report</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/category/index">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive"> 
                                    </span>
                                    <span class="sub-linking__navs--items--label">Mop Report</span>
                                </a>
                            </li>
                            <li class="sub-linking__navs--items">
                                <a href="/admin/designation/index">
                                    <span class="sub-linking__navs--items--image">
                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive">
                                    </span>
                                    <span class="sub-linking__navs--items--label">New Daily</span>
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>