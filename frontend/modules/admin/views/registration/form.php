<?php

use common\models\State;
use common\models\District;
use common\models\Block;
use common\models\Panchayat;
use common\models\Village;

$states = State::getStateList();
$districts = [];
$blocks = [];
$panchayats = [];
$villages = [];
        
if($model->state_code){
   $districts = District::getDistrictList($model->state_code);
}
if($model->district_code){
   $blocks = Block::getBlockList($model->district_code);
}
if($model->block_code){
   $panchayats = Panchayat::getPanchayatList($model->block_code);
}
if($model->panchayat_code){
   $villages = Village::getVillageList($model->panchayat_code);
}



$this->title = $formConfig['title'];

$this->registerJs('RegistrationController.createUpdate();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section">
                    <h2 class="section__heading text-center"><?= ($guid)?'EDIT - ':'' ?> <?= $this->title ?></h2>
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
                                    'autocomplete' => 'off'
                                ],
                    ]);
                    ?>
                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">Student Details</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                                $form->field($model, 'applied_previously')
                                ->dropDownList([
                                    '0' => 'No',
                                    '1' => 'Yes',
                                        ], [
                                    'class' => 'chzn-select',
                                        ]
                                )->label($formConfig['label1'])
                            ?>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'previous_roll_no')->textInput(
                                    [
                                        'placeholder' => 'Previous Roll No',
//                                        'disabled' => 1,
                            ])->label('Previous Roll No')
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'full_name')
                                    ->textInput(
                                            [
                                                'value'=>$survey['name'],
                                                'placeholder' => 'Full Name'
                                            ]
                                    )
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                            $form->field($model, 'father_name')->textInput(
                                    [
                                        'placeholder' => 'Father\'s Name',
                            ])->label('Father\'s Name')
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                    $form->field($model, 'mother_name')
                                    ->textInput(
                                            [
                                                'placeholder' => 'Mother\'s Name'
                                            ]
                                    )
                                    ->label('Mother\'s Name')
                            ?>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 col-xs-12">
                            <?=
                            $form->field($model, 'gender')->dropDownList(
                                    [
                                        'Male'=>'Male',
                                        'Female'=>'Female',
                                    ],
                                    [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                            ])
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                            $form->field($model, 'dob')->textInput([
                                'class'=>'dob'
                            ])->label('Date Of Birth')
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                            $form->field($model, 'category')
                            ->dropDownList([
                                'General'=>'General',
                                'SC'=>'SC',
                                'ST'=>'ST',
                                'OBC'=>'OBC'
                            ],[
                                'class'=>'chzn-select',
                                'prompt'=>'Select'
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'occupation')->dropDownList(
                                    [
                                        'Government Employee'=>'Government Employee',
                                        'Government Undertaking'=>'Government Undertaking',
                                        'Private Employee'=>'Private Employee',
                                        'Self Employed'=>'Self Employed',
                                        'Student'=>'Student',
                                        'Others'=>'Others'
                                    ],
                                    [
                                        'class' => 'chzn-select',
                                        'prompt' => 'Select',
                            ])
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'disability')->dropDownList([
                                0=>'No',
                                1=>'Yes',
                            ],
                                    [
                                'class'=>'chzn-select',
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'mobile')
                                    ->textInput(
                                            [
                                                'placeholder' => 'Mobile'
                                            ]
                                    )
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'email')
                                    ->textInput(
                                            [
                                                'placeholder' => 'Email'
                                            ]
                                    )
                            ?>
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
                                ->dropDownList($states,
                                    [
                                        'class' => 'chzn-select stateCascadeMain stateSearch',
                                        'prompt' => 'Select',
                                        'data-search'=>'1',
                                        'data-parent'=>'state',
                                        'data-child-class'=>'districtCascadeMain',
                                        'disabled' => true
                                    ]
                                )
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'district_code')
                                ->dropDownList($districts,
                                    [
                                        'class' => 'chzn-select districtCascadeMain districtSearch',
                                        'prompt' => 'Select',
                                        'data-search'=>'1',
                                        'data-parent'=>'district',
                                        'data-child-class'=>'blockCascadeMain',
                                        'disabled' => true
                                    ]
                                )
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'block_code')
                                ->dropDownList($blocks,
                                    [
                                        'class' => 'chzn-select blockCascadeMain blockSearch',
                                        'prompt' => 'Select',
                                        'data-search'=>'1',
                                        'data-parent'=>'block',
                                        'data-child-class'=>'panchayatCascadeMain',
                                        'disabled' => true
                                    ]
                                )
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'panchayat_code')
                                ->dropDownList($panchayats,
                                    [
                                        'class' => 'chzn-select panchayatCascadeMain panchayatSearch',
                                        'prompt' => 'Select',
                                        'data-search'=>'1',
                                        'data-parent'=>'panchayat',
                                        'data-child-class'=>'villageCascadeMain',
                                        'disabled' => true
                                    ]
                                )
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'village_code')
                                ->dropDownList($villages,
                                    [
                                        'class' => 'chzn-select villageCascadeMain villageSearch',
                                        'prompt' => 'Select',
                                        'data-search'=>'1',
                                        'data-parent'=>'village',
                                        'disabled' => true
                                    ]
                                )
                            ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'address')
                                ->textInput(
                                    [
                                        'placeholder'=>'Address'
                                    ]
                                )
                            ?>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 col-xs-12">
                            <?=
                                $form->field($model, 'pin_code')
                                ->textInput(
                                    ['placeholder'=>'Pin Code']
                                )
                            ?>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">Education</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-6 col-xs-12">
                            <?=
                                $form->field($model, 'edu_qualification')
                                ->dropDownList(
                                        $formConfig['edu_qulaification'],
                                    [
                                        'class'=>'chzn-select',
                                        'prompt'=>'Select',
                                        ]
                                )->label('Education Qualification')
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?=
                                $form->field($model, 'year_of_passing')
                                ->textInput(
                                        []
                                )
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;">Attachments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 col-xs-12">
                            <?php
                            if (isset($model->photo_media_id) && !empty($model->photo_media_id)) {

                                $mediaList = \common\models\Media::find()
                                        ->where('id =:id', [':id' => $model->photo_media_id])
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
                                                    <a href="javascript:;" class="uploadFileBtn">
                                                        <figure>
                                                            <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                        </figure>
                                                        <p><?= \Yii::t('admin', 'Upload Photo') ?>
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
                                <?= $form->field($model, 'photo_media_id')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?php
                            $mediaList = [];
                            if (isset($model->signature_media_id) && !empty($model->signature_media_id)) {

                                $mediaList = \common\models\Media::find()
                                        ->where('id =:id', [':id' => $model->signature_media_id])
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
                                                    <a href="javascript:;" class="uploadFileBtn">
                                                        <figure>
                                                            <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                        </figure>
                                                        <p><?= \Yii::t('admin', 'Upload Signature') ?>
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
                                <?= $form->field($model, 'signature_media_id')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?php
                            $mediaList = [];
                            if (isset($model->left_hand_thumb_media_id) && !empty($model->left_hand_thumb_media_id)) {

                                $mediaList = \common\models\Media::find()
                                        ->where('id =:id', [':id' => $model->left_hand_thumb_media_id])
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
                                                    <a href="javascript:;" class="uploadFileBtn">
                                                        <figure>
                                                            <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                        </figure>
                                                        <p><?= \Yii::t('admin', 'Upload Left Hand Thumb Impression') ?>
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
                                <?= $form->field($model, 'left_hand_thumb_media_id')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4 col-xs-12">
                            <?php
                            $mediaList = [];
                            if (isset($model->address_proof_media_id) && !empty($model->address_proof_media_id)) {

                                $mediaList = \common\models\Media::find()
                                        ->where('id =:id', [':id' => $model->address_proof_media_id])
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
                                                    <a href="javascript:;" class="uploadFileBtn">
                                                        <figure>
                                                            <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                        </figure>
                                                        <p><?= \Yii::t('admin', 'Upload Address Proof') ?>
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
                                <?= $form->field($model, 'address_proof_media_id')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?php
                            $mediaList = [];
                            if (isset($model->id_proof_media_id) && !empty($model->id_proof_media_id)) {

                                $mediaList = \common\models\Media::find()
                                        ->where('id =:id', [':id' => $model->id_proof_media_id])
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
                                                    <a href="javascript:;" class="uploadFileBtn">
                                                        <figure>
                                                            <img src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/media.svg" alt="Media Icon" />
                                                        </figure>
                                                        <p><?= \Yii::t('admin', 'Upload ID Proof') ?>
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
                                <?= $form->field($model, 'id_proof_media_id')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button grouping__leftAligned">
                                    <?= Html::submitButton((!isset($model->id) || $model->id < 0) ? 'Submit' : 'Update', ['class' => 'button blue small', 'name' => 'button']) ?>
                                    <a href="<?= Url::toRoute(['index','type'=>$formConfig['type']]) ?>" class="button grey small">Cancel</a>            
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