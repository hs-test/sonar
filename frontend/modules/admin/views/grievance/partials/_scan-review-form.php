<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$commentsList = common\models\ListType::getListTypeDropdown(['categories' => common\models\ListType::TYPE_SCAN_REVIEW]);

$typedropdown = ['REVIEW' => 'REVIEW', 'SCAN' => 'SCAN'];
if (isset($is_scan) && !empty($is_scan)) {
    unset($typedropdown['SCAN']);
}
else if (isset($is_review) && !empty($is_review)) {
    unset($typedropdown['REVIEW']);
}
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'commentform',
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
            <h4 class="modal-title"><i class="fa fa-qrcode"> </i>Scan & Review</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <?=
                            $form->field($model, 'type', [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                            ])
                            ->dropDownList(
                                    $typedropdown, ['class' => 'chzn-select', 'data-placeholder' => "Select Type"]
                            )->label('<span class="">*</span>Select Type');
                    ?>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <?=
                    $form->field($model, 'date')->textInput([
                        'autofocus' => false,
                        'autocomplete' => 'off',
                        'class' => 'form-control js-scanreviewdatePicker',
                        'placeholder' => \Yii::t('admin', 'Date')
                    ])->label(false)
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <?=
                            $form->field($model, 'reason', [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                            ])
                            ->dropDownList(
                                    $commentsList, ['class' => 'chzn-select commentList', 'data-placeholder' => "Select Reason", 'multiple' => 'true', 'tabindex' => "4"]
                            )->label('<span class="">*</span>Select Reason');
                    ?>
                </div>  
            </div>  
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'comment')->textarea([
                            ])->label('<span class=""></span>Comment')
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