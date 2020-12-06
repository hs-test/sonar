<?php
$searchParams = Yii::$app->request->queryParams;
$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'StateSearchForm',
            'action' => \yii\helpers\Url::toRoute(['location/state']),
            'method' => 'GET',
        ]);
?>
<div class="filters-wrapper" <?= !empty($searchParams) ? "style='display:block'" : '' ?>>
    <ul>
        <li>
            <?=
            $form->field($model, 'search')->textInput([
                'class' => 'c9n-ippt',
                'placeholder' => 'Search'
            ])->label(FALSE);
            ?>   
        </li>
        <li>
            <?=
                    $form->field($model, 'is_cpm_head', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList([1 => 'Yes', 2 => 'No'], ['class' => 'chzn-select', 'prompt' => 'Is CPM Head']
                    )->label(FALSE);
            ?>

        </li>
        <li>
            <?=
                    $form->field($model, 'is_nodal_officer', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList([1 => 'Yes', 2 => 'No'], ['class' => 'chzn-select', 'prompt' => 'Is Nodal Officer']
                    )->label(FALSE);
            ?>

        </li>
        <li>
            <?=
                    $form->field($model, 'is_state_user', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList([1 => 'Yes', 2 => 'No'], ['class' => 'chzn-select', 'prompt' => 'Is State User']
                    )->label(FALSE);
            ?>

        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
        </li>
         <li class="action-button">
            <?= \yii\helpers\Html::button('Reset', ['class' => 'button blue small resetForm', 'type' => 'reset']) ?>
        </li>
    </ul>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>
