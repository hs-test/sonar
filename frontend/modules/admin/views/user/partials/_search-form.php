<?php

use yii\bootstrap\ActiveForm;

$roles = \common\models\User::roleArray();
if (Yii::$app->user->hasSuperAdminRole()) {
    $roles = [\common\models\User::ROLE_ADMIN => 'ADMIN'] + $roles;
}

$form = ActiveForm::begin([
            'method' => 'GET',
            'id' => 'userSearchForm',
            'options' => [
                'autocomplete' => 'off'
            ],
        ]);
?>
<div class="filters-wrapper">
    <ul>
        <li>
            <?=
            $form->field($model, 'search')->textInput([
                'autofocus' => false,
                'class' => 'form-control',
                'placeholder' => 'Search by name,username,mobile,email'
            ])->label(FALSE)
            ?>
        </li>
        <?php if (!\Yii::$app->user->hasAssignmentOfficerRole()): ?>
            <li>
                <?=
                        $form->field($model, 'role_id', [
                            'template' => "\n{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList($roles, ['class' => 'chzn-select', 'prompt' => 'Select Role'])->label(FALSE)
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
