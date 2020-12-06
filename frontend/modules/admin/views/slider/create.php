<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;

$title = (isset($model->id) && $model->id > 0) ? 'Edit Slider' : 'Create Slider';
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Slider Manager', 'url' => Url::toRoute(['slider/index'])];
$this->params['breadcrumbs'][] = ['label' => $title];

$this->registerJs('SliderController.createUpdate();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= $this->render('/layouts/partials/_breadcrumb.php', ['pageTitle' => \yii::t('admin','Create Slider')]) ?>
            </div>
        </div>
    </div>
</div>

<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $this->render('/layouts/partials/flash-message.php') ?>
                <section class="widget__wrapper">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'slider',
                        'options' => [
                            'class' => 'widget__wrapper-searchFilter ',
                            'autocomplete' => 'off'
                        ],
                    ]);
                    ?>  
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <?=
                                                $form->field($model, 'title')->textInput([
                                                    'autofocus' => false,
                                                    'class' => 'form-control',
                                                    'placeholder' => \yii::t('admin','Title')
                                                ])->label(\yii::t('admin','Title'))
                                                ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <?=
                                                    $form->field($model, 'type', [
                                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                                    ])
                                                    ->dropDownList([
                                                        'header' => 'Header', 
                                                        'footer' => 'Footer', 
                                                        'gallery' => 'Gallery'
                                                        ], 
                                                        [
                                                            'class' => 'chzn-select', 
                                                            'prompt' => 'Type'
                                                        ]
                                                    )->label(\yii::t('admin','Type'))
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- File Uploading Section -->
                            <div class="col-md-12 col-xs-12">
                                <?php
                                $mediaList = null;
                                if (isset($model->id) && !empty($model->id)):
                                    $mediaList = common\models\SliderMedia::getSliderMedia($model->id);
                                endif;
                                ?> 
                                <div class="fileUploading__wrapper">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 has-margin-left-30">
                                            <div class="slider <?= ($mediaList == null) ? 'hide': '' ?> sliderBlock">
                                                <div id="slider-carousel" class="owl-carousel owl-theme">
                                                    <?php if (isset($mediaList) && count($mediaList) > 0): ?>
                                                        <?php foreach ($mediaList as $media): ?>
                                                            <div class="item">
                                                                <a href="javascript:;">
                                                                    <div class="overlay_icons">
                                                                        <div class="close removeImage" data-id="<?= $media['id']?>"  data-guid="<?= $media['guid'] ?>">
                                                                            <i class="fa fa-close"></i>
                                                                        </div>
                                                                    </div>
                                                                    <img src="<?= $media['cdn_path'] ?>" alt="image" />
                                                                </a>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="uploads mediaUploadBox ">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:;" class="uploadFileBtn">
                                                            <figure>
                                                                <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/images/icons/media.svg" alt="Media Icon" />
                                                            </figure>
                                                            <p>
                                                                <?= \Yii::t('admin', 'Upload Images') ?>
                                                                <span>( <?= \Yii::t('admin', 'valid.extension.images') ?> )</span>
                                                            </p>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="mediaContainer">
                                                    <?php
                                                    if (isset($mediaList)):
                                                        foreach ($mediaList as $media):
                                                            ?>
                                                            <input id="mediafile<?= $media['id'] ?>" name="SliderForm[media][]" type="hidden" value="<?= $media['id'] ?>">
                                                        <?php endforeach; ?>     
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="grouping equal-button grouping__leftAligned">
                                            <?= Html::submitButton((isset($model->id) && $model->id > 0) ? \yii::t('admin', 'update') : \yii::t('admin', 'create'), ['class' => 'button blue classGroupSubmitBtn', 'name' => 'classgroup-button']) ?>
                                            <a href="<?= Url::toRoute(['slider/index']) ?>" class="button grey"><?= \yii::t('admin', 'cancel') ?></a>            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </section> 
            </div>
        </div>
    </div>   
</div>
