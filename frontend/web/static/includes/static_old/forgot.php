<!-- Begin global header section -->
<?php
$pageTitle = 'Forgot';
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
                        <h3 class="login__content-form-title">Reset Password</h3>
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
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-actions">
                                    <button type="submit" class="button blue  button-block  button-medium" name="login-button"><i class="fa fa-check"></i>Reset Password</button>
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