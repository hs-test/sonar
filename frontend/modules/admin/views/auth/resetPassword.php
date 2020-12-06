<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login__content">
    <?php
    $form = ActiveForm::begin(['id' => 'forgot-password',
                'options' => [
                    'class' => 'login__content-form',
                ],
    ]);
    ?>
    <h3 class="login__content-form-title">Reset Password</h3>
    <div class="row">
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
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <?=
                $form->field($model, 'verifypassword', [
                    'template' => "<label class='control-label visible-ie8 visible-ie9'>{label}\n</label><div class='input-icon'><i class='fa fa-lock'></i>\n{input}\n{hint}\n{error}</div>"
                ])->passwordInput([
                    'class' => 'form-control placeholder-no-fix',
                    'autocomplete' => 'off',
                    'placeholder' => 'Verify Password'
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-actions has-margin-top-20">
                <?= Html::submitButton('<i class="fa fa-check"></i>Save', ['class' => 'button blue button-block  button-medium', 'name' => 'forgot-button']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div> 	