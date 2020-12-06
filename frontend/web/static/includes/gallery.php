<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = \yii::t('admin','gallery');

$this->registerJs('GalleryController.createUpdate();');

$this->params['breadcrumbs'][] = ['label' => \yii::t('admin','gallery.manager')];
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= $this->render('/layouts/partials/_breadcrumb.php', ['pageTitle' => \yii::t('admin','gallery.manager')]) ?>
                <aside class="section section__right">
                    <ul>
                        <li><a href="<?= Url::toRoute(['gallery/create'])?>" class="button blue" ><i class="fa fa-plus"></i> <?=\yii::t('admin','new')?></a></li>
                        <li><a href="javascript:;" class="search__single" ><i class="fa fa-search"></i></a></li>
                    </ul>
                    <div class="search__single-bar">
                        <div class="input-group">
                            <input type="search" class="form-control" name="SliderSearch[search]" placeholder="<?=\yii::t('admin','search')?>" />
                            <button type="submit" class="search__single-bar--button"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <div class="accordian__view">
                        <div class="loading__wrapper theme2">
                            <div class="loading__spinner"> 
                                <div class="loader"> 
                                    <span><img width="24" height="24" src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/loading.svg"></span> 
                                    <span class="text">Please wait ...</span> 
                                </div> 
                            </div>
                            <div class="loading__spinner-overlay"></div>
                        </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Title name
                                        <ul class="option-set">
                                            <li class="active galleryStatus" data-toggle="tooltip" title="Active">
                                                <i class="fa fa-image"></i>
                                            </li>
                                            <li class="arrowBg">
                                                <i class="arrow fa fa-angle-down"></i>
                                            </li>
                                        </ul>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p class="descriptionSection">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                    </p>
                                    <div class="galleryListing fileUploading__wrapper">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth">
                                                <div class="uploads ">
                                                    <div class="uploads__image">
                                                        <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/profile_Bg.jpg" alt="image" />
                                                        <div class="uploads__image-close"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content">
                                                            sd
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth">
                                                <div class="uploads ">
                                                    <div class="uploads__image">
                                                        <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/profile_Bg.jpg" alt="image" />
                                                        <div class="uploads__image-close"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content">
                                                            sd
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth">
                                                <div class="uploads ">
                                                    <div class="uploads__image">
                                                        <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/profile_Bg.jpg" alt="image" />
                                                        <div class="uploads__image-close"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content">
                                                            sd
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth">
                                                <div class="uploads ">
                                                    <div class="uploads__image">
                                                        <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/profile_Bg.jpg" alt="image" />
                                                        <div class="uploads__image-close"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content">
                                                            sd
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth">
                                                <div class="uploads ">
                                                    <div class="uploads__image">
                                                        <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/admin/dist/images/profile_Bg.jpg" alt="image" />
                                                        <div class="uploads__image-close"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content">
                                                            sd
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footerSection">
                                        <ul>
                                            <li class="user">
                                                <i class="fa fa-user"></i>
                                                Posted By: 
                                                <span>Mayank</span>
                                            </li>
                                            <li class="date">
                                                <i class="fa fa-calendar"></i>
                                                Posted Date: 
                                                <span>16-May-2017</span>
                                            </li>
                                            <li class="counter">
                                                <i class="fa  fa-database"></i>
                                                Total Counts: 
                                                <span>26,000</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Title name
                                        <ul class="option-set">
                                            <li class="galleryStatus" data-toggle="tooltip" title="Inactive">
                                                <i class="fa fa-image"></i>
                                            </li>
                                            <li class="arrowBg">
                                                <i class="arrow fa fa-angle-down"></i>
                                            </li>
                                        </ul>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <p class="descriptionSection">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                    </p>
                                    <div class="galleryListing">
                                        
                                    </div>
                                    <div class="footerSection">
                                        <ul>
                                            <li class="counter">sds</li>
                                            <li class="counter">sdsddd</li>
                                            <li class="counter">sdsddsd</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- panel-group -->
                </div>
                </div> 
            </div>
        </div>
    </section>
</div>