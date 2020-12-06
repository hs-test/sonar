<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$stateList = \common\models\State::getStateList();
$typeList = \common\models\Type::getParentChildTypeList();

$districtList = [];
$villageList = [];
$readOnly = FALSE;
if (isset($model->customer_id) && $model->customer_id > 0) {

    $districtList = common\models\District::getDistrictList(NULL, ['code' => $model->district_code]);
    $villageList = common\models\Village::getVillageList(NULL, ['code' => $model->village_code]);
    $readOnly = TRUE;
}
?>
<section class="widget__wrapper">   
    <?php
    $form = ActiveForm::begin([
                'id' => 'graphicForm',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'options' => [
                    'class' => 'widget__wrapper-searchFilter',
                    'autocomplete' => 'off',
                    'enctype' => 'multipart/form-data'
                ],
    ]);
    ?>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <?=
                    $form->field($model, 'prefix')
                    ->dropDownList([ '' => 'Select Pre'] + ['Mr' => 'Mr', 'Ms' => 'Ms', 'Mrs' => 'Mrs'], ['class' => 'chzn-select']
            );
            ?>
        </div>
        <div class="col-md-6 col-xs-12">
            <?=
            $form->field($model, 'name')->textInput([
                'autofocus' => false,
                'class' => 'form-control',
                'placeholder' => 'Name'
            ])->label('<span class="">*</span>Name')
            ?>
        </div>

    </div>
    <div class="row">

        <div class="col-md-6 col-xs-12">
            <?=
            $form->field($model, 'email')->textInput([
                'autofocus' => false,
                'class' => 'form-control',
                'placeholder' => 'Email, if any',
            ])
            ?>
        </div>
        <div class="col-md-6 col-xs-12">
            <?=
            $form->field($model, 'mobile')->textInput([
                'autofocus' => false,
                'class' => 'form-control only-number',
                'placeholder' => 'Mobile',
                'minlength' => 10,
                'maxlength' => 10,
            ])->label('<span class="">*</span>Mobile')
            ?>
        </div>
    </div>
    <div class="row"> 

        <div class="col-md-6 col-xs-12">
            <?=
                    $form->field($model, 'state_code', [
                        'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList(
                            [ '' => 'Select State'] + $stateList, ['class' => 'chzn-select stateCascade', 'data-search' => '1', 'data-parent' => 'state', 'data-child-class' => 'districtCascade']
                    )->label('<span class="">*</span>State')
            ?>
        </div>
        <div class="col-md-6 col-xs-12">
            <?=
                    $form->field($model, 'district_code', [
                        'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList(
                            [ '' => 'Select District'] + $districtList, ['class' => 'chzn-select districtCascade', 'data-search' => '1', 'data-parent' => 'district', 'data-child-class' => 'villageCascade']
                    )->label('<span class="">*</span>District')
            ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <?=
                    $form->field($model, 'village_code', [
                        'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList(
                            [ '' => 'Select Village'] + $villageList, ['class' => 'chzn-select villageCascade']
                    )->label('<span>*</span>Village/Town')
            ?>
        </div>
        <div class="col-md-6 col-xs-12">
            <?=
            $form->field($model, 'pincode')->textInput([
                'autofocus' => false,
                'class' => 'form-control only-number',
                'placeholder' => 'Pincode',
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <?=
            $form->field($model, 'type', [
                'inputOptions' => [
                    'class' => 'chzn-select'
                ]
                    ]
            )->dropDownList(common\models\Type::typeListDropDown(), ['prompt' => 'Select Grievance Type']);
            ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <?=
            $form->field($model, 'address')->textarea([
            ])->label('<span class="">*</span>Address/Location')
            ?>

        </div>  
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <?=
            $form->field($model, 'description_complaint')->textarea([
            ])->label('<span class="">*</span>Complaint Description')
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton((isset($model->id) && $model->id > 0) ? 'Update' : 'Save', ['class' => 'button blue classSubmitBtn', 'name' => 'class-button']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <!-- /.modal-dialog -->
</section>
   <?php
   $script = <<< JS
           
    $('#graphicForm').on('beforeSubmit', function (e) {
    $('.classSubmitBtn').attr('disabled', 'disabled');
     return true;
});
           
          
JS;
   $this->registerJs($script);
   ?>