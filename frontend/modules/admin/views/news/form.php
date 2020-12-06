<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if($guid){
    $this->title = 'Edit News & Update';
	$buttonText = 'Update';
}else{
    $this->title = 'Add News & Update';
	$buttonText = 'Create';
}
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
                            'id'=>'news-form',
                            'action'=>['form','guid'=>$guid],
                            'options'=>['class'=>'widget__wrapper-searchFilter',]
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
                        <!-- Begin single column section -->
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                
                                <?= $form->field($model, 'title') ?>
                            </div>
                            
                            <div class="col-md-6 col-xs-12">
                                <?= 
                                $form
                                ->field($model, 'status') 
                                ->dropDownList(
                                        [
                                    '1' => 'Active',
                                    '0' => 'Inactive'
                                        ], 
                                        ['class' => 'chzn-select']
                                )
                                ?>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                
                                <?= 
									$form
									->field($model, 'content')
									->textarea() 
									->label('News Content')
                                ?>
                            </div>
                        </div>
                        <!-- End single column section -->

                        <!-- Begin Buttons section -->
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <div class="grouping equal-button  grouping__leftAligned">
                                        <button type="submit" class="button blue"><?= $buttonText?></button>                                    
                                        
                                        <?= Html::a('Cancel','index',['class'=>'button grey']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End Buttons section -->
                    <?php $form->end() ?>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End Form section -->