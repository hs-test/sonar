<!-- Begin Login container -->
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div class="login__content">
    <?= $this->render('/layouts/partials/flash-message') ?>
    <?php
    $form = ActiveForm::begin(['id' => 'login-form',
                'options' => [
                    'class' => 'login__content-form',
                ],
    ]);
    ?>
    <h3 class="login__content-form-title">Login To Your Account</h3>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-group has-error">
                <?=
                $form->field($model, 'username', [
                    'template' => "<label class='control-label visible-ie8 visible-ie9'>{label}\n</label><div class='input-icon'><i class='fa fa-user'></i>\n{input}\n{hint}\n{error}</div>"
                ])->textInput([
                    'autofocus' => true,
                    'class' => 'form-control placeholder-no-fix',
                    'autocomplete' => 'off',
                    'placeholder' => 'Username'
                ])->label('Username');
                ?>
            </div>
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <?=
                $form->field($model, 'password', [
                    'template' => "<label class='control-label visible-ie8 visible-ie9'>{label}\n</label><div class='input-icon'><i class='fa fa-lock'></i>\n{input}\n{hint}\n{error}</div>"
                ])->passwordInput([
                    'class' => 'form-control placeholder-no-fix',
                    'autocomplete' => 'off',
                    'placeholder' => 'Password'
                ]);
                ?>
            </div>
        </div>
<!--        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                
            </div>
        </div>-->
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6 mob__fullwidth-599">
            <?=
            $form->field($model, 'rememberMe', [
                'options' => ['tag' => 'div', 'class' => 'custom-checkbox pull-left field-RememberMe'],
                'template' => "<label>\n{input}\n<span for='RememberMe'>Remember Me</span></label>\n{hint}\n{error}"
            ])->checkbox(['id' => 'RememberMe', 'hidefocus' => true], false)
            ?>      
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mob__fullwidth-599 forgot_password">
            <a href="/admin/auth/forgot" id="forgot-password" class="link-blue">Forgot Your Password?</a>      
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-actions has-margin-top-20">
                <?= Html::submitButton('<i class="fa fa-check"></i>Login', ['class' => 'button blue button-block  button-medium', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>