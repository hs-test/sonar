<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'companyinfo',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i>Add User</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'contact_person')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Contact Person'
                            ])->label('Contact Person')
                            ?>

                        </div> 
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'email')->input('email',[
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Email'
                            ])->label('Email')
                            ?>

                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'contact_no')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Contact No'
                            ])->label('Contact No')
                            ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'address')->textarea([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Address'
                            ])->label('Address')
                            ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('Save', ['class' => 'button blue classSubmitBtn', 'name' => 'class-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->