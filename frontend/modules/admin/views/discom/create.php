<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
$title = (isset($model->id) && $model->id > 0) ?  'Edit Content' :  'Create Content';
$this->title = $title;
$this->registerJs('PageManagerController.createUpdate();');
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title]) ?>
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $this->render('/layouts/partials/flash-message.php') ?>
                <section class="widget__wrapper">
                    <?php
                    $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'horizontal-form widget__wrapper-searchFilter',
                                    'autocomplete' => 'off'
                                ],
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?=
                            $form->field($model, 'discom_code')->textInput([
                                'autofocus' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Discom Code'
                            ])->label('Title')
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button  grouping__leftAligned">
                                    <?= Html::submitButton((isset($model->id) && $model->id > 0) ? 'Update' : 'Create', ['class' => 'button blue classGroupSubmitBtn small', 'name' => 'classgroup-button']) ?>
                                    <a href="<?= Url::toRoute(['page/index']) ?>" class="button small grey">Cancel</a>
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
