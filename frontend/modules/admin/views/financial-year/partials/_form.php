<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin([
            'options' => [
                'class' => 'widget__wrapper-searchFilter',
                'autocomplete' => 'off'
            ],
]);
?>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'code')->textInput([
            'autofocus' => false,
            'class' => 'form-control',
            'placeholder' => \yii::t('admin', 'Code')
        ])->label(\yii::t('admin', 'Code'))
        ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'name')->textInput([
            'autofocus' => false,
            'class' => 'form-control',
            'placeholder' => 'Name'
        ]);
        ?>
    </div>
</div>
<div class="row">
    
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'from_date')->textInput([
            'autofocus' => false,
            'class' => 'form-control fromDatepicker',
            'placeholder' => 'From Date'
        ]);
        ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'to_date')->textInput([
            'autofocus' => false,
            'class' => 'form-control toDatepicker',
            'placeholder' => 'To Date'
        ]);
        ?>
    </div>
</div>

<div class="row">
     <div class="col-md-12 col-xs-12">
        <div class="form-group">
            <div class="grouping equal-button grouping__leftAligned">
                <?= Html::submitButton((isset($model->guid) && $model->guid > 0) ? \yii::t('admin', 'update') : \yii::t('admin', 'create'), ['class' => 'button blue small', 'name' => 'button']) ?>
                <a href="<?= Url::toRoute(['index']) ?>" class="button grey small"><?= \yii::t('admin', 'cancel') ?></a>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $(".fromDatepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('.toDatepicker').datepicker('setStartDate', startDate);
        }).on('clearDate', function () {
            $('.toDatepicker').datepicker('setStartDate', null);
        });

        $(".toDatepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('.fromDatepicker').datepicker('setEndDate', endDate);
        }).on('clearDate', function () {
            $('.fromDatepicker').datepicker('setEndDate', null);
        });
JS;
$this->registerJs($script);
?>

