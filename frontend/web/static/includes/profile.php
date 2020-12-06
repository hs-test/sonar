<!-- Begin global header section -->
<?php
$pageTitle = 'Notification | School';
include("includes/global_header.php");
?>

<!-- End global header section -->

<!-- Begin header section -->
<section id="viewport">
    <div class="page-container">
        <!-- Begin Navigational Area -->
        <?php
        include("includes/page-sidebar-navigation.php");
        ?>
        <!-- //End Navigational Area -->

        <!-- Begin Page Content Area -->
        <div class="page__content-wrapper">
            <div class="page__content-inner">
                <!-- Begin Page Header Area -->
                <?php
                include("includes/page_header.php");
                ?>
                <!-- //End Page Header Area -->

                <!-- Begin Page Bar -->
                <?php
                $pageHead = 'Dashboard';
                include("includes/page_bar.php");
                ?>
                <!-- //End Page Bar -->
                <!-- Begin page content section -->
                <main class="page-main-content">
                    <section class="container">
                        <div class="content__wrap">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="tabbable tabbable__custom">
                                        <h3 class="menuSlide">
                                            Select Menu
                                            <span class="fa fa-angle-down"></span>
                                        </h3>
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="profile.php">Edit Profile</a></li>
                                            <li class=""><a href="table-view.php">Table View</a></li>
                                            <li class=""><a href="javascript:;">Network</a></li>
                                            <li class=""><a href="javascript:;">Notifications</a></li>
                                        </ul>
                                        <div class="tabbable__content">
                                            <form class="tabbable__content-form">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-4 col-xs-12">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <label>Profile Image</label>
                                                                            <div class="tabbable__content-form-profile text-center">
                                                                                <div class="tabbable__content-form-profile-avatar">
                                                                                    <span class="image-covered" style="background-image:url(http://res.cloudinary.com/cognitives/image/upload/c_fill,dpr_auto,f_auto,fl_lossy,g_face,h_140,q_auto,r_max,w_140/y8ng5tnev6nst1r3otsv);"></span>
                                                                                </div>
                                                                                <a href="javascript:void(0)" class="uploadFileBtn">
                                                                                    <i class="fa fa-plus-circle green"></i> 
                                                                                    add new image
                                                                                </a>
                                                                                <div class="tabbable__content-form-profile-status">
                                                                                    <h4>Profile Status</h4>
                                                                                    <div class="tabbable__content-form-profile-status-section">
                                                                                        <div class="progress">
                                                                                            <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%;">100%</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-9 col-md-8 col-xs-12">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <label>Username</label>
                                                                            <input class="form-control" placeholder="Username" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group no-margin-bottom">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-xs-12 has-margin-bottom-15">
                                                                            <label>First Name</label>
                                                                            <input class="form-control" placeholder="First Name" type="text">
                                                                        </div>
                                                                        
                                                                        <div class="col-md-6 col-xs-12 has-margin-bottom-15">
                                                                            <label>Last Name</label>
                                                                            <input class="form-control" placeholder="Last Name" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <label>Email</label>
                                                                            <input class="form-control" placeholder="Email" type="email">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group no-margin-bottom">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-xs-12 has-margin-bottom-15">
                                                                            <label>Password</label>
                                                                            <input class="form-control" placeholder="Password" type="text">
                                                                        </div>
                                                                        
                                                                        <div class="col-md-6 col-xs-12 has-margin-bottom-15">
                                                                            <label>Confirm Password</label>
                                                                            <input class="form-control" placeholder="Confirm Password" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-12">
                                                                <div class="form-group no-margin-bottom">
                                                                    <div class="radio-buttons-section form-group clearfix">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                <label>Byline</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-sm-6 col-xs-12 radio-or-checkbox-spacer">
                                                                                <div class="custom-radio pull-left">
                                                                                    <label>
                                                                                        <input name="radio" value="0" type="hidden"><input id="RememberMe" name="radio" value="1" hidefocus="" type="radio">
                                                                                        <span for="RememberMe">Remember Me</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-6 col-xs-12 radio-or-checkbox-spacer">
                                                                                <div class="custom-radio pull-left">
                                                                                    <label>
                                                                                        <input name="radio" value="0" type="hidden"><input id="RememberMe" name="radio" value="1" hidefocus="" type="radio">
                                                                                        <span for="RememberMe">Remember Me</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group clearfix">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-sm-6 col-xs-12 radio-or-checkbox-spacer">
                                                                            <div class="custom-checkbox pull-left">
                                                                                <label>
                                                                                    <input name="checkbox" value="0" type="hidden"><input id="RememberMe" name="checkbox" value="1" checked="" hidefocus="" type="checkbox">
                                                                                    <span for="RememberMe">Remember Me</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12 radio-or-checkbox-spacer">
                                                                            <div class="custom-checkbox pull-left">
                                                                                <label>
                                                                                    <input name="checkbox" value="0" type="hidden"><input id="RememberMe" name="checkbox" value="1" checked="" hidefocus="" type="checkbox">
                                                                                    <span for="RememberMe">Remember Me</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group clearfix no-margin-bottom">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-sm-6 col-xs-12 has-margin-bottom-20">
                                                                            <label for="country">Country</label>
                                                                            <select class="chzn-select">
                                                                                <option>Choose...</option>
                                                                                <option>jQuery</option>
                                                                                <option selected="selected">MooTools</option>
                                                                                <option>Prototype</option>
                                                                                <option>Dojo Toolkit</option>
                                                                                <option>jQuery</option>
                                                                                <option>MooTools</option>
                                                                                <option>Prototype</option>
                                                                                <option>Dojo Toolkit</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 col-xs-12 has-margin-bottom-20">
                                                                            <label for="author">Author</label>
                                                                            <div class="cog-select">
                                                                                <select name="user_id" id="user_id" class="chzn-select">
                                                                                    <option>Choose...</option>
                                                                                    <option>jQuery</option>
                                                                                    <option selected="selected">MooTools</option>
                                                                                    <option>Prototype</option>
                                                                                    <option>Dojo Toolkit</option>
                                                                                    <option>jQuery</option>
                                                                                    <option>MooTools</option>
                                                                                    <option>Prototype</option>
                                                                                    <option>Dojo Toolkit</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-xs-12">
                                                                            <label>Textarea</label>
                                                                            <textarea class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="actoin-set text-center has-margin-top-50">
                                                                    <button type="submit" class="button blue bordered large">Save</button>
                                                                </div>
                                                                
                                                                <div class="actoin-set grouping equal-button text-center has-margin-top-50">
                                                                    <button class="button blue large" type="button">Save</button>
                                                                    <a href="" target="_blank" class="button grey large">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
                <!-- //End page content section -->
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Begin Footer section -->

        <?php
        include("includes/page_footer.php");
        ?>
        <!-- End Footer section -->
    </div>
    <!-- End header section -->
</section>

<!-- Begin Script section -->
<?php
include("includes/scripts.php");
?>
<!-- Begin Script section -->

</body>
</html>