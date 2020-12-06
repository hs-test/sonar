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
            <div class="section-head">
              <h3 class="title">Grievance</h3>
            </div>
            
            <!--Grievance Form Section start-->
            <div class="filter__wrapper">
              <form id="contact-form" action="/connect/grievance" method="post">
                <div class="row">
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">Pre</label>
                        <select id="" class="form-control" name="Pre">
                          <option value="Mr">--Mr--</option>
                          <option value="Mrs">--Mrs--</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-name required">
                        <label class="control-label" for="contact-name">First Name: <span>*</span></label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your First Name" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">Last Name: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your Last Name" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">Gender: <span>*</span></label>
                        <select id="" class="form-control" name="Pre">
                          <option value="Male">Select Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">Mobile Number: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your Mobile No." aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">E-mail: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your Email ID" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">State: <span>*</span></label>
                        <select id="" class="form-control" name="Pre">
                          <option value="Male">Select State</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">District: <span>*</span></label>
                        <select id="" class="form-control" name="Pre">
                          <option value="Male">Select State</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">Block: <span>*</span></label>
                        <select id="" class="form-control" name="Pre">
                          <option value="Male">Select State</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">Village: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your Email ID" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">Street Address: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Your Street Address" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-email required">
                        <label class="control-label" for="contact-email">Pin Code:: <span>*</span> </label>
                        <input type="text" id="" class="form-control" name="" placeholder="Enter Pin Code" aria-required="true">
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-project">
                        <label class="control-label" for="contact-project">Grievance Type: <span>*</span></label>
                        <select id="" class="form-control" name="Grievance-type">
                          <option value="">Select Grievance</option>
                          <option value="AX">Saubhagya</option>
                          <option value="AF">Other</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-message required has-error">
                        <label class="control-label" for="contact-message">Description of Complaint: <span>*</span></label>
                        <textarea id="contact-message" class="form-control" name="Contact[message]" rows="7"  aria-required="true" aria-invalid="true"></textarea>
                        <p class="help-block help-block-error"></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="filter__wrapper-form">
                      <div class="form-group field-contact-message required has-error">
                        <label class="control-label" for="contact-message">Have you earlier lodged the grievance to the above Department on the same subject ? If Yes Ask for Grivance Number, Date: <span>*</span></label>
                        <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios">
                            Yes </label>
                          &nbsp;
                          <label>
                            <input type="radio" name="optionsRadios">
                            No </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="filter__wrapper-form">
                      <button type="submit" class="button submit" name="contact-button">Submit</button>
                      <button type="reset" class="button reset" name="contact-button">Reset</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!--Grievance Form Section end--> 
            
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



