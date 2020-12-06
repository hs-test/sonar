<!-- Begin global header section -->
<?php
$pageTitle = 'Dual Login | School';
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
                <div class="login__dualSection">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="login__dualSection-content">
                                    <div class="login__dualSection-content-seprator">
                                        <span>O</span>
                                        <span class="chge-clr">R</span>
                                    </div>
                                    <aside class="login__dualSection-content-first">
                                        <div class="login-form">
                                            <h3><span>Login as Admin</span></h3>
                                            <form>
                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                                                    <div class="input-icon">
                                                        <i class="fa fa-user"></i>
                                                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                                                    <div class="input-icon">
                                                        <i class="fa fa-lock"></i>
                                                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div class="custom-checkbox pull-left">
                                                            <label>
                                                                <input id="RememberMe" type="checkbox" value="RememberMe" name="RememberMe" hidefocus="true" checked>
                                                                <span for="RememberMe">Remember Me</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right"><a href="javascript:;" id="forget-password" class="link-green">Forgot password ?</a></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 loading text-center has-margin-top-20"><i class="fa fa-spinner fa-pulse"></i> Please wait</div>
                                                </div>
                                                <div class="text-right has-margin-top-20">
                                                    <button type="submit" class="button green button-medium"><i class="fa fa-check"></i>Login</button>
                                                </div>

                                            </form>
                                        </div>

                                    </aside>
                                    <aside class="login__dualSection-content-second">
                                        <div class="login-form">
                                            <h3><span>Login as Parent</span></h3>
                                            <form>
                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                                                    <div class="input-icon">
                                                        <i class="fa fa-user"></i>
                                                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="custom-checkbox pull-left">
                                                            <label>
                                                                <input id="RememberMe" type="checkbox" value="RememberMe" name="RememberMe" hidefocus="true" checked>
                                                                <span for="RememberMe">If you have login details then click on checkbox</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 loading text-center has-margin-top-20"><i class="fa fa-spinner fa-pulse"></i> Please wait</div>
                                                </div>
                                                <div class="text-right has-margin-top-20">
                                                    <button type="submit" class="button green button-medium"><i class="fa fa-check"></i>Login</button>
                                                </div>

                                            </form>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>

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