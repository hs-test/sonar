<?php
$title = (isset($model->id) && $model->id > 0) ? 'Edit Module' : 'Create Module';
$this->title = $title;
$this->registerJs('ModuleController.createUpdate();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section">
                    <h2 class="section__heading"> <?= $title ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $this->render('/layouts/partials/flash-message.php') ?>
                <section class="widget__wrapper">

                    <?php

                    use yii\helpers\Url;
                    use yii\helpers\Html;
                    use yii\bootstrap\ActiveForm;

$hide = (isset($model->id) && ($model->id) > 0 ) ? 'hide' : '';
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'countryForm',
                                'options' => [
                                    'class' => 'widget__wrapper-searchFilter',
                                    'autocomplete' => 'off'
                                ],
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'name')->textInput([
                                'autofocus' => true,
                                'class' => 'c9n-ippt',
                                'placeholder' => 'Name'
                            ])->label('Name')
                            ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <?=
                            $form->field($model, 'content')->textarea([
                                'id' => 'editor',
                                'placeholder' => 'Content'
                            ]);
                            ?> 
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12 col-xs-12">
                            <?=
                                    $form->field($model, 'is_active', [
                                        'template' => "{label}\n{input}\n{hint}\n{error}",
                                    ])
                                    ->dropDownList(
                                            ['1' => 'Active', '0' => 'Inactive'], ['class' => 'chzn-select']
                                    )->label('Status')
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button grouping__leftAligned">
                                    <?= Html::submitButton((!isset($model->id) || $model->id < 0) ? 'Create' : 'Update', ['class' => 'button blue small', 'name' => 'button']) ?>
                                    <a href="<?= Url::toRoute(['index']) ?>" class="button grey small">Cancel</a>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </section>
            </div>
        </div>
    </div>
</div>