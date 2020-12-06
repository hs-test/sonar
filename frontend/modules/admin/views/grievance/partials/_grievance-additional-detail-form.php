<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'grievance',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i>Update SRN Details</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'rack_no')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Rack No'
                            ])->label('Rack No')
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