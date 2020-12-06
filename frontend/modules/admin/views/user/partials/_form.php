<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$roles = \common\models\User::roleArray();
if (Yii::$app->user->hasSuperAdminRole()) {
    $roles = [\common\models\User::ROLE_ADMIN => 'ADMIN'] + $roles;
}
$showPassword = TRUE;
if ($model->id > 0) {
    $roles = [
        $model->role_id => \common\models\User::roleArray($model->role_id)
    ];
    $showPassword = FALSE;
}
if ($profile) {
    $showPassword = TRUE;
}
$this->registerJs("UserController.summary()");
?>
<?php
$form = ActiveForm::begin([
            'id' => 'userForm',
            'options' => [
                'class' => 'widget__wrapper-searchFilter',
                'autocomplete' => 'off'
            ],
        ]);
?>
<?= Html::activeHiddenInput($model, 'id') ?>
<?= Html::activeHiddenInput($model, 'guid') ?>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <?=
        $form->field($model, 'username')->textInput([
            'autofocus' => true,
            'class' => 'c9n-ippt',
            'readonly' => ($model->id > 0) ? true : false,
            'disabled' => ($model->id > 0) ? true : false,
            'placeholder' => 'Username'
        ])
        ?>
    </div>

</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'name')->textInput([
            'autofocus' => true,
            'class' => 'c9n-ippt',
            'placeholder' => 'Full Name'
        ])->label("Full Name");
        ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'mobile')->textInput([
            'autofocus' => true,
            'class' => 'c9n-ippt',
            'placeholder' => 'Mobile Number'
        ])->label("Mobile Number");
        ?>
    </div>
</div>
<div class="row">
    <div class="<?= (isset($profile) && !$profile) ? 'col-md-6 col-sm-6 col-xs-6' : 'col-md-12 col-sm-12 col-xs-12' ?>">
        <?=
        $form->field($model, 'email')->textInput([
            'autofocus' => true,
            'class' => 'c9n-ippt',
            'placeholder' => 'Email'
        ])
        ?>
    </div>
    <?php if (isset($profile) && !$profile): ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
                    $form->field($model, 'status', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList([10 => 'Active', 0 => 'Inactive'], ['class' => 'chzn-select']
                    )->label('Status');
            ?>
        </div>
    <?php endif; ?>
</div>
<?php if ($showPassword): ?>
    <div class="row">   
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?=
            $form->field($model, 'password')->passwordInput([
                'autofocus' => true,
                'class' => 'c9n-ippt',
                'placeholder' => 'Password'
            ])
            ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?=
            $form->field($model, 'verifypassword')->passwordInput([
                'autofocus' => true,
                'class' => 'c9n-ippt',
                'placeholder' => 'Verify Password'
            ])->label('Verify Password')
            ?>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($profile) && !$profile): ?>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <?=
                    $form->field($model, 'role_id', [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                    ])
                    ->dropDownList($roles, ['class' => 'chzn-select', 'prompt' => 'Select Role']
                    )->label('Role');
            ?>
        </div>

    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            <div class="grouping equal-button grouping__leftAligned">
                <?= Html::submitButton((!isset($model->id) || $model->id <= 0) ? 'Create' : 'Update', ['class' => 'button blue small', 'name' => 'button']) ?>
                <a href="<?= \yii\helpers\Url::toRoute(['user/index']) ?>" class="button grey small">Cancel</a>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>