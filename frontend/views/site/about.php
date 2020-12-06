<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner__wrapper"> 
    <!--Inner Banner section start-->
    <div class="banner__wrapper-inner">
        <div class="banner__wrapper-inner--item">
            <figure> <img src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/images/banners/inner/inner-banner.jpg" alt="banner" class="img-fluid"> </figure>
        </div>
    </div>
    <!--Inner Banner Section end-->

    <div class="banner__wrapper-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Growing Hands for Every One<span>Submit your grievance today</span></h3>
                    <div class="action__form">
                        <div class="action__form-main">
                            <form>
                                <div class="form-group">
                                    <label class="label" for="Name"><span class="">Name</span></label>
                                    <input type="text" id="Name" placeholder="Enter Name" class="form-control" name="RegistrationForm[name]" aria-required="true">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group">
                                    <label class="label" for="Mobile Number"><span class="">Mobile Number</span></label>
                                    <input type="text" id="Name" placeholder="Enter Mobile Number" class="form-control" name="RegistrationForm[mobilenumber]" aria-required="true">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group">
                                    <label class="label" for="Email"><span class="">Email</span></label>
                                    <input type="text" id="Name" placeholder="Enter Email" class="form-control" name="RegistrationForm[mobilenumber]" aria-required="true">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <button type="button"  class="button theme__btn" data-toggle="modal" data-target="#exampleModalCenter">Submit Now</button>



                            </form>
                        </div>
                        <div class="action__form-helpline">
                            <p>Do you need any help? Call Now</p>
                            <span class="helpline--number">1800 121 5555 <i class="fas fa-phone-square"></i></span> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="home-body inner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content--wrap innerContent">
                            <div class="section-head">
                                <h3 class="title">About REC</h3>
                            </div>
                            <p>REC came into being in 1969 to articulate a response to the pressing exigencies of the nation. During the time of severe drought, the leaders sought to reduce the dependency of agriculture on monsoons by energizing agricultural pump-sets for optimized irrigation. Thereafter, we have ventured into newer paths and expanded our horizons to emerge today, as a leader in providing financial assistance to the power sector in all segments, be it Generation, Transmission or Distribution.</p>

                            <p>As a Navratna company under the administrative control of the Ministry of Power, we have been rated ‘Excellent’ in terms of the MoUs signed with the Government for 22 consecutive years. We fund our business with market borrowings of various maturities, including bonds and term loans apart from foreign borrowings, on our own. Domestically, we hold the highest credit ratings from CRISIL, ICRA, IRRPL and CARE and internationally we are rated at par with the sovereign ratings. Under the discerning leadership of highly qualified and experienced professionals, which has effectively harnessed the individual talents of all our employees, we have maintained consistent profit margins and paid dividends each year since fiscal 1998. We have thus propelled ourselves to a net worth of over ₹30,000 crore.</p>

                            <p>Our humble beginnings spearheaded our strides into the corporate world and to this day our commitment towards nation-building constitutes our core value. As a natural corollary, we have been appointed as the nodal agency by the Government of India for implementation of Saubhagya (Pradhanmantri Sahaj Bijli Har Ghar Yojana) and DDUGJY (Deendayal Upadhyaya Gram Jyoti Yojana), the schemes which aim at providing 24x7 sustainable and affordable power to all households in the country. We have also been entrusted with the responsibility of being the coordinating agency for rolling out UDAY (Ujwal Discom Assurance Yojana) which seeks to operationally reform and financially turnaround the power distribution companies of the country.</p>

                            <p><img src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/images/content-images/about-img.png" width="555" height="332" class="img-fluid" /></p>

                            <p>Our two subsidiaries – RECPDCL (REC Power Distribution Company Limited) and RECTPCL (REC Transmission Project Company Limited) work in tandem with us to realise our shared mission by providing consultancy services in Distribution and Transmission sectors.</p>

                            <p>We take due cognizance of the fact that we owe our stupendous success to our customers, the unflinching commitment of our employees and our countrywide presence through 28 offices which ensures easy accessibility. Having bolstered our share in the country’s total power capacity, we are poised to help build a sound infrastructure to provide affordable, accessible and sustainable power. </p>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>