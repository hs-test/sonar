<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Grievance';

$this->params['breadcrumbs'][] = [
    'label' => 'Contact Us', 
    'url' => Url::toRoute(['/connect/contact'])
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template'=>'<li class="breadcrumb-item active">{link}</li>'
];
$this->registerCss('.help-block-error{color:red}');

?>
<div class="clearfix"></div>
<div class="page-header">
    <div class="page-header__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <?= $this->render('/layouts/partials/breadcrumb.php')?>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header__innerbanner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 no-padding">
                    <figure>
                        <img src="/static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="Grievance">
                    </figure>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="inner-body">
    <div class="container">
        <?= $this->render('/layouts/partials/flash-message.php')?>
        <div class="row">
            <div class="col-12">  
                <div class="section-head">
                    <h3 class="title">Grievance</h3>
                </div>
                <div class="filter__wrapper">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?= $form->field($model, 'name')->input('text', ['placeholder' => "Enter Your Name"]) ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?= $form->field($model, 'email')->input('text', ['placeholder' => "Enter Your Email"]) ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?= $form->field($model, 'mobile')->input('text', ['placeholder' => "Enter Your Mobile Number"]) ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?= $form->field($model, 'project')->dropDownList([
                                        'Education'=>'Education',
                                        'Health'=>'Health',
                                        'Financial Inclusion'=>'Financial Inclusion',
                                        'Capacity Building'=>'Capacity Building',
                                        'Skill'=>'Skill',
                                        'G2C Services'=>'G2C Services',
                                        'B2C Services'=>'B2C Services',
                                        'Educational Services'=>'Educational Services',
                                        'Financial Services'=>'Financial Services',
                                        'Health Services'=>'Health Services'
                                    ]) ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="filter__wrapper-form">
                                    
                                    <?= $form->field($model, 'message')->textarea(['rows' => 7,'placeholder'=>'Enter Your Comments Here'])->label("Comment's") ?>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?= Html::submitButton('Submit', ['class' => 'button submit', 'name' => 'contact-button']) ?>
                                    <?= Html::resetButton('Reset', ['class' => 'button reset', 'name' => 'contact-button']) ?>
                                    
                                </div>
                            </div>
                        </div> 
                    <?php ActiveForm::end(); ?>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>