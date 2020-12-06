<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'resetpasswordform',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i> Change Password</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">    
                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'password')->textInput([
                                'type' => 'password',
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Password'
                            ])
                            ?>
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <?=
                            $form->field($model, 'verifypassword')->textInput([
                                'type' => 'password',
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Verify Password'
                            ])
                            ?>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('Update', ['class' => 'button blue classSubmitBtn', 'name' => 'class-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->