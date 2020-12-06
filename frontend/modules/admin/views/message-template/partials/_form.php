<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin([
            'options' => [
                'class' => 'widget__wrapper-searchFilter',
                'autocomplete' => 'off'
            ],
        ]);
?>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
        $form->field($model, 'title')->textInput([
            'autofocus' => false,
            'class' => 'form-control',
            'placeholder' => 'Title'
        ]);
        ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <?=
                $form->field($model, 'type', [
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                ])
                ->dropDownList(['EMAIL' => 'Email', 'DOC' => 'Doc'], ['class' => 'chzn-select', 'prompt' => 'Select Type']
                )->label('Type');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?=
        $form->field($model, 'template')->textarea([
            'autofocus' => false,
            'class' => 'form-control',
            'placeholder' => 'Template'
        ]);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            <div class="grouping equal-button grouping__leftAligned">
                <?= Html::submitButton((isset($model->id) && $model->id > 0) ? \yii::t('admin', 'update') : \yii::t('admin', 'Create'), ['class' => 'button blue small', 'name' => 'button']) ?>
                <a href="<?= Url::toRoute(['message-template/index']) ?>" class="button grey small"><?= \yii::t('admin', 'Cancel') ?></a>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

