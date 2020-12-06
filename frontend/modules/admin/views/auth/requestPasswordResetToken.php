<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login__content">
    <?= $this->render('/layouts/partials/flash-message') ?>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
    <h3 class="login__content-form-title">Forgot Password</h3>
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
                    'placeholder' => 'Enter Username'
                ])->label('Username');
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-actions has-margin-top-20">
                <?= Html::submitButton('<i class="fa fa-check"></i>Submit', ['class' => 'button blue button-block  button-medium', 'name' => 'forgot-button']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div> 	