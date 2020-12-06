<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Contact Us';

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
                        <img src="/static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="Contact">
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
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="section-head">
                            <h3 class="title">Head Office</h3>
                        </div>
                        <div class="contact__wrap">
                            <h4 class="company--title">CSC e Governance India Limited</h4>
                            <p>238, Okhla Phase III<br>Behind Modi Mill<br>New Delhi - 110020</p>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="section-head">
                            <h3 class="title">Location</h3>
                        </div>
                        <div class="location__wrap">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.681519031468!2d77.26562501416079!3d28.54929098245066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce3e8c0000001%3A0xa706172f50ccdb0d!2sCSC+e-Governance+Services+India+Ltd!5e0!3m2!1sen!2sin!4v1535523002987" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div> 
                </div>
                <div class="clearfix"><!-- blank tag --></div>
                <div class="section-head">
                    <h3 class="title">Query</h3>
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