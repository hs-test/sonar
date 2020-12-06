<?php

$this->title = 'VLE Facilitation Centre Id';

$this->registerJs('VleController.facilitation();');
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section">
                    <h2 class="section__heading text-center"> <?= $this->title ?></h2>
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
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'nfcForm',
                                'options' => [
                                    'class' => 'widget__wrapper-searchFilter',
                                    'autocomplete' => 'off'
                                ],
                    ]);
                    ?>
                    
                    <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;"><?= $this->title ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($vle->is_facilitation_centre_assigned): ?>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <p>Your Facilitaion Centre Id is : <?= $vle->facilitation_centre_id ?></p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <?=
                                $form->field($vle, 'facilitation_centre_id')
                                ->textInput([
                                    'placeholder'=>'Facilitation Centre ID',
                                    'required'=>1,
                                    ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-4 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button grouping__leftAligned">
                                    <?= Html::submitButton( 'Submit', ['class' => 'button blue small', 'name' => 'button']) ?>
                                    <a href="<?= Url::toRoute(['index']) ?>" class="button grey small">Cancel</a>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" >
                        <div class="col-md-12 col-xs-12">
                            <p class="text-center" >OR</p>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 col-xs-12">
                            <div class="text-center">
                               <?= Html::a('Click here to Submit Centre details','/admin/user/vle-facilitation-registration?type=nielit',['class'=>'button green']) ?>
                           </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <br><br>
                    <?php ActiveForm::end(); ?>
                </section>
            </div>
        </div>
    </div>
</div>