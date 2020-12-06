<?php
$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'ReportSearchForm',
            'method' => 'GET',
        ]);
?>
<div class="filters-wrapper" style="display:block">
    <ul>
        <?php if (isset($from_date) && $from_date): ?>
            <li>
                <?=
                $form->field($searchModel, 'from_date')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control fromDatePicker',
                    'placeholder' => \Yii::t('admin', 'From date')
                ])->label(false)
                ?>
            </li>
        <?php endif; ?>
        <?php if (isset($to_date) && $to_date): ?>
            <li>
                <?=
                $form->field($searchModel, 'to_date')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control toDatePicker',
                    'placeholder' => \Yii::t('admin', 'To date')
                ])->label(false)
                ?>
            </li>
        <?php endif; ?>
        <?php if (isset($status) && $status): ?>
            <li>
                <?=
                        $form->field($searchModel, 'status', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList(common\models\Grievance::getGrievanceStatusArr(NULL,TRUE), ['class' => 'chzn-select',
                            'prompt' => 'Select SRN Status',
                                ]
                        )->label(false)
                ?>
            </li>
        <?php endif; ?>

        <li class="action-button">
            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>

        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::button('Reset', ['class' => 'button blue small resetForm', 'type' => 'button']) ?>
        </li>
    </ul>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>