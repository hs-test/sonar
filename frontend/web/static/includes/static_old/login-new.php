<!-- Begin global header section -->
<?php
$pageTitle = 'Login';
$bodyClass = 'login__Class';
include("includes/_global-Head.php");
?>

<!-- End global header section -->

<!-- Begin header section -->
<section id="viewport">
    <div class="page-container">
        <!-- Begin Navigational Area -->
        <?php
        include("includes/_sidebar.php");
        ?>
        <!-- //End Navigational Area -->

        <!-- Begin Page Content Area -->
        <div class="page__content-wrapper">
            <div class="page__content-inner">
                <!-- Begin Page Header Area -->
                <?php
                include("includes/_header-login.php");
                ?>
                <!-- //End Page Header Area -->
                
                <!-- Begin Login container -->
                <div class="newLogin">
                    <div class="login__content">
                            <form class="login__content-form">
                                <h3 class="login__content-form-title">Login To Your Account</h3>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group has-error">
                                            <label class="control-label">Username / Email</label>
                                            <div class="input-icon">
                                                <i class="fa fa-user"></i>
                                                <input class="form-control" name="LoginForm[username]" autocomplete="off" placeholder="Username / Email" type="text">
                                                <p class="help-block help-block-error">Username or email cannot be blank.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <div class="input-icon">
                                                <i class="fa fa-lock"></i>
                                                <input class="form-control" name="LoginForm[username]" autocomplete="off" placeholder="Username / Email" type="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 mob__fullwidth-599">
                                        <div class="custom-checkbox pull-left field-RememberMe">
                                            <label>
                                                <input id="RememberMe" name="LoginForm[rememberMe]" checked="" type="checkbox">
                                                <span for="RememberMe">Remember Me</span>
                                            </label>
                                        </div>        
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 mob__fullwidth-599 forgot_password">
                                        <a href="forgot.php" id="forgot-password" class="link-blue">Forgot Your Password?</a>      
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-actions has-margin-top-20">
                                            <button type="submit" class="button blue  button-block  button-medium" name="login-button"><i class="fa fa-check"></i>Login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div class="login_data">
                            <p><strong>About the DFTP Service</strong> : The rural and urban India requires awareness on digital economy, digital financial transactions  details about the government policies which would provide them an opportunity to come to main stream economy and move towards the cashless economy. The Digital financial transaction awareness programme (DFTAP) is to reduce risks of un informed rural and urban merchants about digital financial aspects and bring them under mainstream economic system through CSCs.</p>
                            <p><strong>For more information contact:</strong></p>
                            <p>CSC e-Governance Services India Limited</p>
                            <p><strong>Helpdesk No.</strong> 180030003468 Etx. 415 or 441</p>
                            <!--<div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-actions has-margin-top-20">
                                        <a href="http://dftp.s3.amazonaws.com/Work%20Flow%28DFTAP%29.pdf" class="button blue  button-inline  button-medium"><i class="fa fa-star"></i>Process Follow</a>
                                    </div>
                                    <div class="form-actions has-margin-top-20">
                                        <a href="http://dftp.s3.amazonaws.com/User_manual_for_VLEs-1.docx" class="button blue  button-inline  button-medium"><i class="fa fa-star"></i>User Manual</a>
                                    </div>
                                    <div class="form-actions has-margin-top-20">
                                        <a href="http://dftp.s3-ap-southeast-1.amazonaws.com/DFTAP.apk" class="button blue  button-inline  button-medium"><i class="fa fa-star"></i>Download DFTAP</a>
                                    </div>
                                    <div class="form-actions has-margin-top-20">
                                        <a href="https://assist.airtelbank.com/PromoterApp/" class="button blue  button-block  button-medium" target="_blank"><i class="fa fa-star"></i>Airtel Promoter App</a>
                                    </div>
                                    <div class="form-actions has-margin-top-20">
                                        <a href="https://www.youtube.com/watch?v=UufNxb76BNM" class="button blue  button-block  button-medium" target="_blank"><i class="fa fa-star"></i>Airtel promoter app video</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <a href="http://dftp.s3.amazonaws.com/Work%20Flow%28DFTAP%29.pdf" class="button button-block blue has-margin-bottom-15"><i class="fa fa-tasks"></i>Process Follow</a>
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                    <a href="http://dftp.s3.amazonaws.com/User_manual_for_VLEs-1.docx" class="button button-block blue has-margin-bottom-15"><i class="fa  fa-user-circle"></i>User Manual</a>  
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                    <a href="http://dftp.s3-ap-southeast-1.amazonaws.com/DFTAP.apk" class="button blue has-margin-bottom-15"><i class="fa  fa-download"></i>Download DFTAP</a>  
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                      <a href="https://assist.airtelbank.com/PromoterApp/" class="button blue has-margin-bottom-15"><i class="fa  fa-tags"></i>Airtel Promoter App</a>    
                                </div>
                                
                                <div class="col-sm-6 col-xs-12">
                                     <a href="https://www.youtube.com/watch?v=UufNxb76BNM" class="button blue has-margin-bottom-15"><i class="fa fa-video-camera"></i>Airtel promoter app video</a>    
                                </div>
                                  
                                  
                            </div>
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Begin Footer section -->

        <?php
        include("includes/_footer.php");
        ?>
        <!-- End Footer section -->
    </div>
</section>
<!-- End header section -->

<!-- Begin Script section -->
<?php
include("includes/_scripts.php");
?>
<!-- Begin Script section -->

</body>
</html>