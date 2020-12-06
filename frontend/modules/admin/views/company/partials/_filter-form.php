<?php
$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'filterForm',
            'action' => yii\helpers\Url::toRoute(['company/index']),
            'method' => 'GET',
        ]);
?>

<div class="filters-wrapper">
    <ul>
        <li>
            <?=
            $form->field($model, 'name')->textInput([
                'placeholder' => 'Search by name , alias',
                'autocomplete'=> 'off'
            ])->label(false)
            ?>
        </li>
        <li>
            <?=
            $form->field($model, 'cin_no')->textInput([
                'placeholder' => 'Search by CIN No.',
                'autocomplete'=> 'off'
            ])->label(false)
            ?>
        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
        </li>
    </ul>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>
