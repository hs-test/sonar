<?php

use yii\widgets\DetailView;

$this->title = 'Grievance Verify';
$search = \Yii::$app->request->queryParams;
if (isset($search['GrievanceSearch']['mobile']) && !empty($search['GrievanceSearch']['mobile'])) {
    $mobile = $search['GrievanceSearch']['mobile'];
}
 
?>

<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title]) ?>

<!-- Begin Form section -->
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <div class="grievance__wrapper"> 
                        <!--State History section start-->
                        <section class="widget__wrapper">
                            <?php
                            $form = \yii\bootstrap\ActiveForm::begin([
                                        'id' => 'SearchForm',
                                        'method' => 'GET',
                            ]);
                            ?>
                            <div class="addSection">
                                <div class="heading">
                                    Add Grievance 
                                </div>
                                <?=
                                $form->field($searchModel, 'mobile')->textInput([
                                    'placeholder' => 'Enter Mobile No',
                                    'minlength' => 10,
                                    'maxlength' => 10,
                                    'class' => 'form-control only-number'
                                ])->label(false)
                                ?>
                                <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
                            </div>
                            <?php \yii\bootstrap\ActiveForm::end(); ?>
                        </section>
                        <!--State History section end--> 
                        <?php if(!empty($dataProvider)):?>
                        <div class="table__structure table__structure-scrollable">
                            <div class="table__structure__head">
                                <div class="section-head">
                                    <div class="section-head--title"></div>
                                    <div class="section-head__optionSets">
                                        <div class="section-head__optionSets--addButton">
                                            <a href="<?= yii\helpers\Url::toRoute(['grievance/add-grievance', 'mobile' => $mobile]); ?>"><i class="fa fa-plus"></i>New</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $this->render('partials/_other-grievance', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Form section -->