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