<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$col_md_class = 'col-md-6';
$showComment = FALSE;
$showDate = $showDescription = $showTransaction = $showDepository = $showApproved = TRUE;
$depository = ['NSDL' => 'NSDL', 'CDSL' => 'CDSL', 'AMOUNT' => 'AMOUNT'];

if (isset($model->security_depository_type) && !empty($model->security_depository_type)) {

    $depository = array_keys($depository, $model->security_depository_type);
}

if (\Yii::$app->user->hasDispatchExecuitveRole()) {
    $showTransaction = FALSE;
    $showApproved = FALSE;
}
else if (\Yii::$app->user->hasAccountManagerRole()) {
    $col_md_class = 'col-md-12';
    $showComment = TRUE;
    $showDate = $showDescription = $showDepository = $showApproved = FALSE;
}
else if (\Yii::$app->user->hasDealingHeadRole()) {

    $showApproved = FALSE;
    $showComment = TRUE;
    $col_md_class = 'col-md-12';
    $showDate = $showDescription = $showTransaction = $showDepository = FALSE;
    if ($srnmodel->status == common\models\Grievance::UNDER_PROCESS) {
        $showApproved = TRUE;
    }
}
else if (\Yii::$app->user->hasAdminRole()) {
    $col_md_class = 'col-md-12';
    $showComment = TRUE;
    $showDate = $showDescription = $showTransaction = $showDepository = $showApproved = FALSE;
    if ($srnmodel->status == common\models\Grievance::DR_ASSIGNED) {
        $showApproved = TRUE;
    }
}
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'updatestatusform',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'options' => [
                    'class' => 'horizontal-form',
                    'autocomplete' => 'off'
                ]
    ]);
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> Update Status</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="<?= $col_md_class; ?> col-sm-12 col-xs-12">
                    <?=
                            $form->field($model, 'grievance_status', [
                                'template' => "{label}\n{input}\n{hint}\n{error}",
                            ])
                            ->dropDownList(
                                    [ '' => 'Select Status'], ['class' => 'chzn-select applicationStatus', 'data-class' => 'showComments', 'data-class-approved' => 'showApproved']
                            )->label('<span class="">*</span>Application Status');
                    ?>
                </div>
                <?php if ($showDate): ?>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'date')->textInput([
                            'autofocus' => false,
                            'class' => 'form-control grievanceDates',
                            'placeholder' => 'Date',
                            'autocomplete' => 'off',
                            'readonly' => true,
                            'disabled' => true,
                            'value' => date('d-m-Y'),
                            'data-guid' => 0
                        ])->label('Date')
                        ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php if ($showDescription): ?>
                <div class="row has-margin-top-20">
                    <div class="col-md-6 col-xs-12">
                        <?=
                                $form->field($model, 'security_depository_type', [
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                ])
                                ->dropDownList(
                                        $depository, ['class' => 'chzn-select']
                                )->label('Depository Type')
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'description')->textInput([
                            'autofocus' => false,
                            'class' => 'form-control description',
                            'placeholder' => 'Description',
                            'autocomplete' => 'off',
                            'readonly' => true
                        ])->label('Description')
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <!--------------discrepancy layout----------->
                <div class="row showComments" style="display:none;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="application-accordian checkListBoxComments">
                        </div>
                    </div>
                </div>
           
            <!------------discrepancy layout-------------->
            <?php if ($showApproved): ?>
                <div class="row showApproved">
                    <div class="col-md-6 col-xs-12">
                        <?=
                        $form->field($model, 'approved_shares')->textInput([
                            'autofocus' => false,
                            'class' => 'form-control requestedShare',
                            'placeholder' => 'No of Share',
                            'autocomplete' => 'off',
                        ])->label('No of Share')
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'approved_amount')->textInput([
                            'autofocus' => false,
                            'class' => 'form-control sharedAmount',
                            'placeholder' => 'Amount',
                            'autocomplete' => 'off',
                        ])->label('Amount')
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($showComment): ?>
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'additional_comment')->textarea([
                            'autofocus' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Comment',
                            'autocomplete' => 'off',
                        ])->label('Comment')
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div> 
        <div class="modal-footer">
            <?= Html::submitButton('Save', [ 'class' => 'button blue small classSubmitBtn', 'name' => 'class-button']) ?>
            <button type="button" class="button grey small" data-dismiss="modal" aria-label="Close">
                Cancel
            </button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>