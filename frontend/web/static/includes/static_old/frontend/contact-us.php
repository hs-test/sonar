<!-- Begin global header section -->
<?php
$pageTitle = 'REC';
$bodyClass = '';
include("includes/_global-Head.php");
include("includes/_header.php");
?>

<div class="clearfix"></div>
<!-- Begin Home Banner -->
<div class="banner__wrapper"> 
  <!--Inner Banner section start-->
  <div class="banner__wrapper-inner">
    <div class="banner__wrapper-inner--item">
      <figure> <img src="static/images/banners/inner/inner-banner.jpg" alt="banner" class="img-fluid"> </figure>
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
<!-- End Home Banner --> 

<div class="home-body inner">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="content--wrap innerContent">
              
              
              
              <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="section-head">
                            <h3 class="title">Corporate Office</h3>
                        </div>
                        <div class="contact__wrap">
                            <h4 class="company--title">Rural Electrification Corporation Limited</h4>
                            <p><i class="icon fa fa-map-marker"></i> Core- 4, SCOPE Complex,<br>7, Lodhi Road, CGO Complex,<br>Pragati Vihar, New Delhi, Delhi 110003</p>
                            
                            <p><i class="icon fa fa-phone"></i> 011 4309 1500</p>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="section-head">
                            <h3 class="title">Location</h3>
                        </div>
                        <div class="location__wrap">
                            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14013.757383037548!2d77.2376733!3d28.5865938!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe9025d95787c5be1!2sRural+Electrification+Corporation+Limited!5e0!3m2!1sen!2sin!4v1489826817319" frameborder="0" style="border:0" height="250" width="100%" allowfullscreen></iframe>
                        </div>
                    </div> 
                </div>
              

             
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
<?php
include("includes/_footer.php");
include("includes/_scripts.php");

