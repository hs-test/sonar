<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$commentsList = common\models\ListType::getListTypeDropdown(['categories' => common\models\ListType::TYPE_CC_COMMENTS, 'optionGroup' => TRUE]);
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i>Add Comment</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <?=
                            $form->field($model, 'list', [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                            ])
                            ->dropDownList(
                                    $commentsList, ['class' => 'chzn-select commentList', 'data-placeholder' => "Select Comments", 'multiple' => 'true', 'tabindex' => "4"]
                            )->label('<span class="">*</span>Select Comments');
                    ?>
                </div>  
            </div>  
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'comment')->textarea([
                            ])->label('<span class=""></span>Additional Comment')
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