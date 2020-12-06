<?php
$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'filterForm',
            'action' => yii\helpers\Url::toRoute(['financial-year/index']),
            'method' => 'GET',
        ]);
?>

<div class="filters-wrapper">
    <ul>
        <li>
            <?=
            $form->field($model, 'name')->textInput([
                'placeholder' => 'Search'
            ])->label(false)
            ?>
        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
        </li>
    </ul>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>
