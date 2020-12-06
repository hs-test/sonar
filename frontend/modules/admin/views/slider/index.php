<?php

use \yii\helpers\Url;

$this->title = \yii::t('admin','slider');

$this->params['breadcrumbs'][] = ['label' => 'Slider Manager'];
$this->registerJs('SliderController.createUpdate();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= $this->render('/layouts/partials/_breadcrumb.php', ['pageTitle' => \yii::t('admin','Slider Manager')]) ?>
                <aside class="section section__right">
                    <ul>
                        <li><a href="<?= Url::toRoute(['slider/create'])?>" class="button blue" ><i class="fa fa-plus"></i> <?=\yii::t('admin','new')?></a></li>
                    </ul>
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
                        <div class="loading__wrapper theme2 hide">
                            <div class="loading__spinner"> 
                                <div class="loader"> 
                                    <span><img width="24" height="24" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/images/loading.svg"></span> 
                                    <span class="text">Please wait ...</span> 
                                </div>
                            </div>
                            <div class="loading__spinner-overlay"></div>
                        </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php if(isset($sliderList) && !empty($sliderList)):?>
                        <?php  foreach ($sliderList as $slider): ?>
                        <div class="panel panel-default">
                           <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $slider['id']?>" aria-expanded="true" aria-controls="collapseOne">
                                        <?= $slider['title']." (".ucfirst($slider['type']).")"; ?>
                                        <ul class="option-set">
                                            <li class="galleryStatus  <?= $slider['status'] ? 'active' : 'inactive' ?> updateStatus" data-status="<?= $slider['status'] ?>" data-url = "<?= Url::toRoute(['slider/status', 'guid' => $slider['guid']]) ?>" data-toggle="tooltip" title="<?=  $slider['status'] ? 'active' : 'inactive'?>">
                                                <i class="fa fa-image"></i>
                                            </li>
                                            <li class="arrowBg">
                                                <i class="arrow fa fa-angle-down"></i>
                                            </li>
                                        </ul>
                                    </a>
                                </h4>
                            </div>
                            <?php $mediaList = common\models\SliderMedia::getSliderMedia($slider['id']); ?> 
                            <div id="collapse-<?php echo $slider['id']?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="galleryListing fileUploading__wrapper mediaBlock">
                                        <div class="row">
                                            <?php if (isset($mediaList) && count($mediaList) > 0): ?>
                                            <?php foreach($mediaList as $media):?>
                                                <div class="col-md-4 col-sm-4 col-xs-6 mob__fullwidth imageBlock">
                                                    <div class="uploads ">
                                                        <div class="uploads__image">
                                                            <a data-fancybox="gallery" href="<?= $media['cdn_path'] ?>">
                                                                <img src="<?= $media['cdn_path'] ?>" alt="image" />
                                                            </a>
                                                            <div class="uploads__image-close deleteMedia" data-id="<?= $media['id'] ?>" data-guid="<?= $media['guid'] ?>"><i class="fa fa-close"></i></div>
                                                            <div class="uploads__image-content">
                                                                <?= $media['filename'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="pull-right">
                                                <a href="<?= Url::toRoute(['slider/update', 'guid' => $slider['guid']]) ?>" class="button blue"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="javascript:;" data-url="<?= Url::toRoute(['slider/delete', 'guid' => $slider['guid']]) ?>" class="button red deleteSlider"><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="footerSection">
                                        <ul>
                                            <li class="counter">
                                                <i class="fa  fa-database"></i>
                                                Total Counts: 
                                                <span><?php echo count($mediaList)?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php else:?>
                            <!-- Begin No slider found Markup -->
                            <div class="error__theme error__theme-gallery">
                                <figure>
                                    <img src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/images/no_Gallery.jpg" alt="icon" />
                                </figure>
                                <div class="error__theme-content">
                                    <h3><span>Oops! Looks like</span> you don't have any slider.</h3>
                                </div>
                            </div>
                            <!-- End No slider found Markup -->
                        <?php endif;?>
                    </div><!-- panel-group -->
                </div>
                </div> 
            </div>
        </div>
    </section>
</div>