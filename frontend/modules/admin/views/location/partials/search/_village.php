<?php
$this->registerJs("LocationApiController.getDistrict();");
$searchParams = Yii::$app->request->queryParams;
$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'VillageSearchForm',
            'action' => \yii\helpers\Url::toRoute(['location/village']),
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
                    $form->field($model, 'state_code', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList(\common\models\State::getStateList(), ['class' => 'chzn-select state', 'prompt' => 'Select State']
                    )->label(FALSE);
            ?>

        </li>
        <li>
            <?=
                    $form->field($model, 'district_code', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList(\common\models\District::getDistrictList($model->state_code), ['class' => 'chzn-select district', 'prompt' => 'Select District']
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
