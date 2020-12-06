<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJs('GrievanceController.ckeditor();');
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'messageform',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i>Send Message</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'subject')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Subject'
                            ])->label('Subject')
                            ?>

                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'message')->textarea([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Message',
                                'id' => 'editor'
                            ])->label('Message')
                            ?>
                        </div> 
                    </div>
                    <div class="row has-margin-top-20">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="custom-radio bottom-margin pull-left has-margin-bottom-10">

                                <?=
                                        $form->field($model, 'send_message')->radio(array(
                                            'label' => '<span for="company">Send To Company</span>',
                                            'id' => 'send_message_company',
                                            'value' => 'company',
                                            'checked' => 'checked'))
                                        ->label('false');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="custom-radio bottom-margin pull-left has-margin-bottom-10">

                                <?=
                                        $form->field($model, 'send_message')->radio(array(
                                            'label' => '<span for="applicant">Send To Applicant</span>',
                                            'id' => 'send_message_applicant',
                                            'value' => 'applicant',
                                            'uncheck' => null))
                                        ->label('false');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="custom-radio bottom-margin pull-left has-margin-bottom-10">
                                <?=
                                        $form->field($model, 'send_message')->radio(array(
                                            'label' => '<span for="both">Send To Both</span>',
                                            'id' => 'send_message_both',
                                            'value' => 'both',
                                            'uncheck' => null))
                                        ->label('false');
                                ?>
                            </div>
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