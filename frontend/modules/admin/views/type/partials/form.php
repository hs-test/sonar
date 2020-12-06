<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<!-- Begin Form section -->
<div class="page-main-content">
    <div class="container">
        <?= $this->render('/layouts/partials/flash-message.php') ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <section class="widget__wrapper">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'grievance-type-form',
                                'options' => ['class' => 'widget__wrapper-searchFilter',]
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
                    <div class="row">
                        <div class="col-md-6 col-xs-12">

                            <?= $form->field($model, 'title') ?>
                        </div>
                        <!--                        <div class="col-md-6 col-xs-12">
                        <?php
//                                    $form
//                                    ->field($model, 'parent_id')
//                                    ->dropDownList(
//                                           $typeDropDownList, ['class' => 'chzn-select','prompt'=>'Select Parent Type']
//                                    )->label('Parent Type');
                        ?>
                                                </div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <div class="grouping equal-button  grouping__leftAligned">
                                    <button type="submit" class="button blue small">Create</button>                                    
                                    <?= Html::a('Cancel', 'index', ['class' => 'button small grey']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $form->end() ?>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End Form section -->