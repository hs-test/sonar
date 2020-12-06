<!-- Begin global header section -->
<?php
$pageTitle = 'Login | School';
include("includes/global_header.php");
?>
<script>
    bodyClass = 'login__Class'; 
</script>
<!-- End global header section -->
<!-- Begin header section -->
<section id="viewport">
    <div class="page-container">
        <div class="page__content-wrapper">
            <div class="page__content-inner">
                <!-- Begin Page Header Area -->
                <?php
                include("includes/page_header.php");
                ?>
                <!-- //End Page Header Area -->
                
                <!-- Begin Login container -->
                <div class="login__content">
                    <form class="login__content-form" method="post" action="#">
                        <h3 class="login__content-form-title">Login to your account</h3>                        
                        <!-- <div class="login__content-form-social">
                            <ul>
                                <li class="fb">
                                    <a href="javascript:;"><i class="fa fa-facebook"></i> Login with Facebook</a>
                                </li>
                                <li class="tweet">
                                    <a href="javascript:;"><i class="fa fa-twitter"></i>  Login with Twitter</a>
                                </li>
                            </ul>
                        </div>
                        <p class="login__content-form-option"><span>Login with Email</span></p> -->
                        <div class="form-group">
                            <div class="form-group has-success">
                                <label class="control-label visible-ie8 visible-ie9" for="loginform-username">Username / Email</label>
                                <div class="input-icon">
                                    <i class="fa fa-user"></i>
                                    <input class="form-control" name="LoginForm[username]" placeholder="Enter Username or Email" type="text">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group has-error">
                                <label class="control-label visible-ie8 visible-ie9" for="loginform-username">Username / Email</label>
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control" name="LoginForm[password]" placeholder="Password" type="password">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6 mob-fullwidth-599">
                                <div class="custom-checkbox pull-left field-RememberMe">
                                    <label>
                                        <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="checkbox">
                                        <span for="RememberMe">Remember Me</span>
                                    </label>
                                    <p class="help-block help-block-error"></p>
                                </div>    
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 mob-fullwidth-599 forgot_password">
                                <a href="javascript:;" id="forgot-password" class="link-blue">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="button blue button-block button-medium" name="login-button"><i class="fa fa-check"></i>Login</button>
                        </div>
                        <p class="login__content-signup">
                            If you are not a registered user
                            <span><a href="javascript:;" class="link-blue">Signup here</a></span>
                        </p>
                    </form>
                </div>
                <!-- //End Login container -->
            
            </div>
        </div>
    </div>
</section>
<!-- Begin Script section -->
<?php 
  include("includes/scripts.php");
?>
<!-- Begin Script section -->

</body>
</html>