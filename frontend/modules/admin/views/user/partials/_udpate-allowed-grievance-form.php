<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$startYear = date('Y');
//$endYear = date("Y", strtotime(date("Y-m-d") . " + 1 year"));
$formattedMonthArray = [
    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
];
$months = [];
$currentmonth = date('m');
foreach ($formattedMonthArray as $key => $month) {
    if ($key >= $currentmonth) {
        $months[$key] = $month;
    }
}
?>
<div class="modal-dialog" role="document">
    <?php
    $form = ActiveForm::begin([
                'id' => 'usertagerlog',
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
            <h4 class="modal-title"><i class="fa fa-edit"> </i> Update Targeted SRN</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">

                            <?=
                                    $form->field($model, 'year', [
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                    ])
                                    ->dropDownList(
                                            [ '' => 'Select Year'] + [$startYear => $startYear], ['class' => 'chzn-select']
                                    )->label('<span class="">*</span>Year');
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?=
                                    $form->field($model, 'month', [
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                    ])
                                    ->dropDownList(
                                            [ '' => 'Select Month'] + $months, ['class' => 'chzn-select']
                                    )->label('<span class="">*</span>Month');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'allocated')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Targeted SRN'
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