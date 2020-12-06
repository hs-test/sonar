<?php

use common\models\State;
use common\models\District;
use common\models\Block;
use common\models\Panchayat;
use common\models\Village;

$this->title = 'Facilitation Centre Registration';


$states = State::getStateList();
$districts = District::getDistrictList($vle->state_code);
$blocks = Block::getBlockList($vle->district_code);
$panchayats = Panchayat::getPanchayatList($vle->block_code);
$villages = Village::getVillageList($vle->panchayat_code);


$this->registerJs('VleController.facilitation();');
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
                                'id' => 'nfcForm',
                                'options' => [
                                    'class' => 'widget__wrapper-searchFilter',
                                    'autocomplete' => 'off',
                                    'novalidate' => true
                                ],
                    ]);
                    ?>

                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">VLE Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'vle_name')->textInput(
                                    [
                                        'placeholder' => 'VLE Name',
                                        'readonly' => '1',
                            ])->label('VLE Name')
                            ?>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'gender')
                                    ->dropDownList([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                            ], [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                            ]
                                    )
                            ?>

                        </div>

                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'father_name')->textInput(
                                    [
                                        'placeholder' => 'Father\'s Name',
                            ])->label('Father\'s Name')
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'mobile')
                                    ->textInput(
                                            [
                                                'placeholder' => 'Mobile Number'
                                            ]
                                    )
                                    ->label('Mobile Number')
                            ?>

                        </div>

                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'email')->textInput(
                                    [
                                        'placeholder' => 'Email ID',
                            ])->label('Email ID')
                            ?>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'vle_pan_number')
                                    ->textInput(
                                            [
                                                'placeholder' => 'VLE PAN Number'
                                            ]
                                    )->label('VLE PAN Number')
                            ?>

                        </div>
                    </div>
                    <?php
                    if (isset($model->vle_pan_media_id) && !empty($model->vle_pan_media_id)) {

                        $mediaList = \common\models\Media::find()
                                ->where('id =:id', [':id' => $model->vle_pan_media_id])
                                ->asArray()
                                ->one();
                    }
                    ?>
                    <div class="row" >
                        <div class="col-md-6 col-xs-12 ">
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
                                <?= $form->field($model, 'vle_pan_media_id')->hiddenInput()->label(false) ?>
                            </div>



                        </div>
                    </div>

                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">Location Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'state_code')
                                    ->dropDownList($states, [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                        'disabled' => 1,
                                            ]
                                    )
                                    ->label('State')
                            ?>

                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'district_code')
                                    ->dropDownList($districts, [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                        'disabled' => 1,
                                            ]
                                    )
                                    ->label('District')
                            ?>

                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'block_code')
                                    ->dropDownList($blocks, [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                        'disabled' => 1,
                                            ]
                                    )->label('Block')
                            ?>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'panchayat_code')
                                    ->dropDownList(
                                            $panchayats, [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                        'disabled' => 1,
                                            ]
                                    )->label('Panchayat')
                            ?>

                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'village_code')
                                    ->dropDownList($villages, [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                                        'disabled' => 1,
                                            ]
                                    )->label('Village')
                            ?>

                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'centre_address')
                                    ->textInput(
                                            [
                                                'placeholder' => 'Centre Address'
                                            ]
                                    )
                            ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'pin')
                                    ->textInput(
                                            [
                                                'placeholder' => 'PIN'
                                            ]
                                    )
                            ?>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">Centre Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'no_of_computers')
                                    ->dropDownList([
                                        '1 to 5'=>'1 to 5',
                                        '6 to 10'=>'6 to 10',
                                        '11 to 15'=>'11 to 15',
                                        '16 to 20'=>'16 to 20',
                                        'More than 20'=>'More than 20'
                                        ], 
                                        [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select'
                                            ]
                                    )
                            ?>

                        </div>

                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'connectivity_type')
                                    ->dropDownList([
                                        'Broad band' => 'Broad band',
                                        'DSL' => 'DSL',
                                        'ISDN' => 'ISDN',
                                        'Other' => 'Other',
                                            ], 
                                        [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select'
                                            ]
                                    )
                            ?>
                            <?=
                                    $form->field($model, 'connectivity_type_other')
                                    ->textInput([
                                        'placeholder' => 'Connectivity Type Other',
                                        'class' => 'hide'
                                    ])
                                    ->label(false)
                            ?>


                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'is_facilitation_center_already_registered')
                                    ->dropDownList(
                                            [
                                        '0' => 'No',
                                        '1' => 'Yes'
                                            ], [
                                        'class' => 'chzn-select vleRegistered',
                                            ]
                                    )
                            ?>
                        </div>
                    </div>

                    <div class="row vleRegisteredYes hide">
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'facilitation_center_no')->textInput()
                            ?>
                        </div>
                    </div>
                    <div class="row vleRegisteredYes hide">
                        <div class="col-md-6 col-xs-12">
                            <div class="fileUploading__wrapper mediaContainer">
                                <?php
                                $mediaList = [];
                                if (isset($model->vle_ccc_certificate_media_id) && !empty($model->vle_ccc_certificate_media_id)) {

                                    $mediaList = \common\models\Media::find()
                                            ->where('id =:id', [':id' => $model->vle_ccc_certificate_media_id])
                                            ->asArray()
                                            ->one();
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12">
                                        <div class="uploads mediaUploadBox <?= (isset($mediaList) && count($mediaList) > 0) ? 'hide' : '' ?>">
                                            <ul>
                                                <li>
                                                    <a  href="javascript:;" class="uploadFileBtn">
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
                                <?=
                                        $form->field($model, 'facilitation_center_certificate_media_id')
                                        ->hiddenInput()
                                        ->label(false)
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="vleRegisteredNo hide">
                        <div  class="row">
                            <div class="col-md-4 col-xs-12">
                                <?=
                                        $form->field($model, 'is_vle_ccc_certified')
                                        ->dropDownList(
                                                [
                                            '0' => 'No',
                                            '1' => 'Yes'
                                                ], [
                                            'class' => 'chzn-select vleCertified'
                                                ]
                                );
                                ?>

                            </div>
                        </div>
                        <div class="row certifiedYes hide">

                            <div class="col-md-4 col-xs-12">
                                <?=
                                        $form->field($model, 'vle_ccc_certificate_roll_no')
                                        ->textInput(
                                                [
                                                ]
                                        )
                                ?>

                            </div>
                            <div class="col-md-4 col-xs-12">


                                <?=
                                        $form->field($model, 'vle_ccc_grade')
                                        ->dropDownList(
                                                [
                                            'D' => 'D',
                                            'C' => 'C',
                                            'B' => 'B',
                                            'A' => 'A',
                                            'S' => 'S',
                                            'F' => 'F'
                                                ], [
                                            'class' => 'chzn-select',
                                            'prompt' => 'Select'
                                                ]
                                        )
                                ?>
                            </div>
                        </div>
                        <div class="row certifiedYes hide" >
                            <div class="col-md-4 col-xs-12">
                                <div class="fileUploading__wrapper mediaContainer">
                                    <?php
                                    $mediaList = [];
                                    if (isset($model->vle_ccc_certificate_media_id) && !empty($model->vle_ccc_certificate_media_id)) {

                                        $mediaList = \common\models\Media::find()
                                                ->where('id =:id', [':id' => $model->vle_ccc_certificate_media_id])
                                                ->asArray()
                                                ->one();
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12">
                                            <div class="uploads mediaUploadBox <?= (isset($mediaList) && count($mediaList) > 0) ? 'hide' : '' ?>">
                                                <ul>
                                                    <li>
                                                        <a  href="javascript:;" class="uploadFileBtn">
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
                                    <?=
                                            $form->field($model, 'vle_ccc_certificate_media_id')
                                            ->hiddenInput()
                                            ->label(false)
                                    ?>
                                </div>

                            </div>
                        </div>



                        <div class="certifiedNo hide">
                            <div class="row" >
                                <div class="col-md-6 col-xs-12">
                                    <?=
                                            $form->field($model, 'equivalent_qualification')
                                            ->dropDownList([
                                                'MCA' => 'MCA',
                                                'M.Sc (Computer Science)' => 'M.Sc (Computer Science)',
                                                'BE (Computer Science/ IT)' => 'BE (Computer Science/ IT)',
                                                'B.Tech (Computer Science/ IT)' => 'B.Tech (Computer Science/ IT)',
                                                'NIELIT O' => 'NIELIT O',
                                                'NIELIT A' => 'NIELIT A',
                                                'NIELIT B' => 'NIELIT B',
                                                'NIELIT C Qualifier' => 'NIELIT C Qualifier',
                                                'BCA' => 'BCA',
                                                'PGDCA' => 'PGDCA',
                                                    ], [
                                                'class' => 'chzn-select',
                                                'prompt' => 'Select'
                                            ])
                                    ?>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <?=
                                            $form->field($model, 'equivalent_person')
                                            ->dropDownList([
                                                'VLE Self' => 'VLE Self',
                                                'Faculty' => 'Faculty',
                                                    ], [
                                                'class' => 'chzn-select',
                                                'prompt' => 'Select'
                                            ])
                                    ?>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6 col-xs-12">
                                    <?=
                                            $form->field($model, 'equivalent_university_name')
                                            ->textInput([])
                                    ?>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <?=
                                            $form->field($model, 'equivalent_roll_no')
                                            ->textInput([])
                                    ?>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-md-6 col-xs-12">
                                    <?=
                                            $form->field($model, 'equivalent_grade')
                                            ->dropDownList(
                                                [
                                            'D' => 'D',
                                            'C' => 'C',
                                            'B' => 'B',
                                            'A' => 'A',
                                            'S' => 'S',
                                            'F' => 'F'
                                                ], [
                                            'class' => 'chzn-select',
                                            'prompt' => 'Select'
                                                ]
                                        )
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <?php
                                    $mediaList = [];
                                    if (isset($model->equivalent_certificate_media_id) && !empty($model->equivalent_certificate_media_id)) {

                                        $mediaList = \common\models\Media::find()
                                                ->where('id =:id', [':id' => $model->equivalent_certificate_media_id])
                                                ->asArray()
                                                ->one();
                                    }
                                    ?>
                                    <div class="fileUploading__wrapper mediaContainer">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12">
                                                <div class="uploads mediaUploadBox <?= (isset($mediaList) && count($mediaList) > 0) ? 'hide' : '' ?>">
                                                    <ul>
                                                        <li>
                                                            <a  href="javascript:;" class="uploadFileBtn">
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
                                        <?=
                                                $form->field($model, 'equivalent_certificate_media_id')
                                                ->hiddenInput()
                                                ->label(false)
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <?php if(!isset($hideApproval)): ?>
                            <div class="row" >
                                <div class="col-md-6 col-xs-12">
                                    <?=
                                        $form->field($model, 'is_submitted')->dropDownList(
                                            [
                                                0 => 'No',
                                                1 => 'Yes',
                                            ], [
                                                'class' => 'chzn-select',
                                            ]
                                        )->label('Submit for approval');  
                                    ?>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button grouping__leftAligned">
                                    <?= Html::submitButton((!isset($model->id) || $model->id < 0) ? 'Submit' : 'Update', ['class' => 'button blue small', 'name' => 'button']) ?>
                                    <a href="<?= Url::toRoute(['index']) ?>" class="button grey small">Cancel</a>            
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