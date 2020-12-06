<!-- Begin global header section -->
<?php
$pageTitle = 'Dashboard | School';
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
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8 col-xs-12">
                                            <label>Date Picker</label>
                                            <input type="text" class="form-control datetimepicker4" placeholder="Select date and time" />
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <div class="button-setting-panel" title="Settings"><span class="circularButtonView"><i class="fa fa-user"></i></span></div>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <div class="responsive_tipped" title="Mayank">Mayank</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Begin Pagination markup -->
                                <nav>
                                    <ul class="pagination">
                                        <li>
                                            <a href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li>
                                            <a href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                <!-- End Pagination markup -->

                                <div class="clearfix"></div>

                                <!-- Begin search markup -->
                                <div class="search__bar pull-left">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Search" type="text">
                                        <button class="search__bar-button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                                <!-- Begin search with toggle markup -->
                                <div class="search__filter search__toggle">
                                    <button id="SearchToggle" class="btn btn-default has-margin-left-30" type="button"><i class="fa fa-search"></i></button>
                                    <form class="searchblock" method="get" action="/admin/user/index">
                                        <div class="input-group">
                                            <input class="form-control selectTitle " name="username" placeholder="Search for..." type="text">
                                            <div class="input-group-btn">
                                                <button class="btn btn-grey dropdown-toggle" data-toggle="dropdown" type="button"><span class="chooseSelect">Username</span>  <span class="caret"></span></button>
                                                <ul class="dropdown-menu simple__menu dropdown-menu-right">
                                                    <li class="active"><a href="javascript:void(0)">Username</a></li>
                                                    <li class=""><a href="javascript:void(0)">Name</a></li>
                                                    <li class=""><a href="javascript:void(0)">Email</a></li>
                                                </ul>
                                                <button class="btn btn-default search-button" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- End search with toggle markup -->

                                <!-- End search markup -->

                                <!-- Begin Loading markup -->
                                <div class="text-center has-margin-bottom-15 has-margin-top-15">
                                    <div class="load__more-theme1"><span>&nbsp;&nbsp;</span>Load More<span>&nbsp;&nbsp;</span></div>
                                    <div class="load__more-theme1">
                                        <span class="svgIcon">
                                            <svg version="1.1" class="svgIconLoading" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve"><path opacity="0.25" enable-background="new" d="M16,0C7.163,0,0,7.163,0,16s7.163,16,16,16s16-7.163,16-16S24.837,0,16,0 M16,4c6.627,0,12,5.373,12,12s-5.373,12-12,12S4,22.627,4,16S9.373,4,16,4"/><path d="M16,0c8.837,0,16,7.163,16,16h-4c0-6.627-5.373-12-12-12V0z"><animateTransform type="rotate" fill="remove" calcMode="linear" repeatCount="indefinite" additive="replace" accumulate="none" restart="always" dur="0.8s" to="360 16 16" attributeName="transform" from="0 16 16"/></path></svg>
                                        </span>
                                        Loading
                                        <span class="one">.</span>
                                        <span class="two">.</span>
                                        <span class="three">.</span>
                                    </div>
                                </div>
                                <!-- End Loading markup -->

                                <!-- Begin Browse file markup -->
                                <div class="file-upload-wrapper">
                                    <div class="row file-upload">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control">
                                                <label class="input-group-btn">
                                                    <span class="btn button blue"><i class="fa fa-upload"></i>
                                                        Browse&hellip; <input type="file" style="display:none;" multiple>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <button type="submit" class="button blue button-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Browse file markup -->

                                <!-- Start Modal markup -->
                                <a href="#" class="btn btn-lg modal__button btn-primary">Launch Demo Modal</a>

                                <!-- Start Modal markup -->
                                <div id="myModal" class="modal modal__wrapper fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to save changes you made to document before closing?</p>
                                                <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="button grey" data-dismiss="modal">Close</button>
                                                <button type="button" class="button green">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal markup -->
                            </div>
                        </div>
                        <!-- Begin Setting Sliding Panel -->
                        <div class="SettingPanel">
                            <?php
                            include("includes/setting_panel.php");
                            ?>
                        </div>
                        <div class="setting-overlay"></div>
                        <!-- //End Setting Sliding Panel -->



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