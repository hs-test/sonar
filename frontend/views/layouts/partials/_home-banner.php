<?php
$this->registerJs('GrievanceController.sendOtp();');
?>
<div class="banner__wrapper">
    <div class="banner__wrapper-home home--slide"> 
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/images/banners/home/banner-1.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/images/banners/home/banner-2.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/images/banners/home/banner-3.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
    </div>  
    <div class="banner__wrapper-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Growing Hands for Every One<span>Submit your grievance today</span></h3>
                    <div class="action__form">
                        <div class="action__form-main">
                            <?=$this->render('/home/partials/_otp-form');?>
                        </div>
                        <div class="action__form-helpline">
                            <p>Do you need any help? Call Now</p>
                            <span class="helpline--number">1800 121 5555 <i class="fas fa-phone-square"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="otpModalCenter" tabindex="-1" role="dialog" aria-labelledby="otpModalCenter" aria-hidden="true">
</div>