<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => (isset($model->code) && $model->code > 0) ? 'editStateForm' : 'newStateForm',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= (isset($model->id) && $model->id > 0) ? 'Edit' : 'New' ?> State</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'name')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'State Name'
                            ])
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'code')->textInput([
                                'autofocus' => true,
                                'class' => 'form-control',
                                'placeholder' => 'Code'
                            ])
                            ?>
                        </div>
                       
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
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton((isset($model->id) && $model->id > 0) ? 'Update' : 'Save', ['class' => 'button blue small classSubmitBtn', 'name' => 'class-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->