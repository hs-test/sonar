<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if(!isset($stateList)){
    $stateList = [];
}

if(!isset($districtList)){
    $districtList = [];
}

if(!isset($blockList)){
    $blockList = [];
}

$showStatus = TRUE;
if(isset($villageList) && count($villageList) > 0){
    $showStatus = FALSE;
}

?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => (isset($model->code) && $model->code > 0) ? 'editPanchayatForm' : 'newPanchayatForm',
                'action' => (isset($url)) ? $url : '',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'options' => [
                    'class' => 'horizontal-form',
                    'autocomplete' => 'off'
                ],
    ]);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= (isset($model->code) && $model->code > 0) ? 'Edit' : 'New' ?> Panchayat</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">                        
                        <div class="col-md-12 col-xs-12">
                            <?=
                                $form->field($model, 'state_code', [
                                    'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                                ])
                                ->dropDownList(
                                   [ '' => 'Select State']+$stateList, ['class' => 'chzn-select stateCascade', 'data-search' => '1', 'data-parent' => 'state', 'data-child-class' => 'districtCascade']
                                )
                            ?>
                        </div>                        
                        <div class="col-md-12 col-xs-12">
                            <?=
                                $form->field($model, 'district_code', [
                                    'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                                ])
                                ->dropDownList(
                                    [ '' => 'Select District']+$districtList, ['class' => 'chzn-select districtCascade', 'data-search' => '1', 'data-parent' => 'district', 'data-child-class' => 'blockCascade']
                                )
                            ?>
                        </div>
                        
                        <div class="col-md-12 col-xs-12">
                            <?=
                                $form->field($model, 'block_code', [
                                    'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                                ])
                                ->dropDownList(
                                    [ '' => 'Select Block']+$blockList, ['class' => 'chzn-select blockCascade']
                                )
                            ?>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'code')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Panchayat Code'
                            ])
                            ?>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'name')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Panchayat Name'
                            ])
                            ?>
                        </div>
                        <?php if($showStatus): ?>
                        <div class="col-md-12 col-xs-12">
                            <?=
                                $form->field($model, 'status', [
                                    'template' => "<label>\n{label}</label>\n{input}\n{hint}\n{error}",
                                ])
                                ->dropDownList(
                                    [1 => 'Active', 0 => 'Inactive'], ['class' => 'chzn-select']
                                )
                            ?>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton((isset($model->code) && $model->code > 0) ? 'Update' : 'Save', ['class' => 'button blue classSubmitBtn', 'name' => 'class-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->