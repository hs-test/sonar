<?php

$this->title = 'Enable Solar';

$this->registerJs('VleController.datePicker(".datepicker");');
$this->registerJs('VleController.uploadMedia();');
$this->registerJs('VleController.deleteMedia();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section">
                    <h2 class="section__heading text-center"> <?= $this->title ?></h2>
                </div>
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

                    use yii\helpers\Url;
                    use yii\helpers\Html;
                    use yii\bootstrap\ActiveForm;
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'villageForm',
                                'options' => [
                                    'class' => 'widget__wrapper-searchFilter',
                                    'autocomplete' => 'off'
                                ],
                    ]);
                    ?>

                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;"><?= $this->title ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <?php for($i = 1; $i <= 8; $i++): ?>
                        <?php 
                            $solarField = 'solar'.$i;
                            $solarEnableField = 'solar_enabled_date'.$i;
                            $solarMediaField = 'solar_media'.$i;
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <?=
                                $form->field($model, $solarField)->textInput([
                                    'autofocus' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Solar No.',
                                    'autocomplete' => 'off'
                                ])->label("Solar No.");
                                ?>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <?=
                                $form->field($model, $solarEnableField)->textInput([
                                    'autofocus' => false,
                                    'class' => 'form-control datepicker',
                                    'placeholder' => 'Solar Enabled Date',
                                    'autocomplete' => 'off'
                                ])->label('Solar Enabled Date');
                                ?>
                            </div>
                            <?php
                            $mediaList = [];
                        if (isset($model->{$solarMediaField}) && !empty($model->{$solarMediaField})) {

                            $mediaList = \common\models\Media::find()
                                    ->where('id =:id', [':id' => $model->{$solarMediaField}])
                                    ->asArray()
                                    ->one();
                        }
                        ?>
                            <div class="col-md-12 col-xs-12 ">
                                <div class="fileUploading__wrapper mediaContainer">
                                    <div class="row">
                                        <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12">
                                            <div class="uploads mediaUploadBox <?= (isset($mediaList) && count($mediaList) > 0) ? 'hide' : '' ?>">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:;" class="uploadFileBtn">
                                                            <figure>
                                                                <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                            </figure>
                                                            <p><?= \Yii::t('admin', 'Upload Image') ?>
                                                                <span>( <?= \Yii::t('admin', 'jpg, png') ?> )</span>
                                                            </p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="uploads mediaResultset <?= (!isset($mediaList) || count($mediaList) <= 0) ? 'hide' : '' ?>">
                                                <?php if (isset($mediaList) && count($mediaList) > 0): ?>
                                                    <div class="uploads__image">
                                                        <img src="<?= $mediaList['cdn_path'] ?>" alt="image" />
                                                        <div class="uploads__image-close deleteFile" data-id="<?= $mediaList['id'] ?>" data-guid="<?= $mediaList['guid'] ?>"><i class="fa fa-close"></i></div>
                                                        <div class="uploads__image-content"><?= $mediaList['filename'] ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $form->field($model, $solarMediaField)->hiddenInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php endfor;?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button grouping__leftAligned">
                                    <?= Html::submitButton( 'Submit', ['class' => 'button blue small', 'name' => 'button']) ?>           
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