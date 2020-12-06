<!-- Begin global header section -->
<?php
$pageTitle = 'Admin Dashboard';
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
                <div class="page__content-section">
                    <!-- Begin Page Header Area -->
                    <?php
                    include("includes/_header.php");
                    ?>
                    <!-- //End Page Header Area -->

                    <!-- Begin Page bar section -->

                    <!-- Design 1 -->
                    <div class="page__bar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <aside class="section section__left">
                                        <h2 class="section__heading upper">Page Head and breadcrumb only</h2>
                                        <ul class="page__bar-breadcrumb"><li class=""><a href="/admin/home/index"><i class="fa fa-home"></i></a></li>
                                            <li class="active">Tutorials Manager</li>
                                        </ul>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Design 1 -->
                    <div class="page__bar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <aside class="section section__left">
                                        <h2 class="section__heading upper">Breadcrumb with add option</h2>
                                        <ul class="page__bar-breadcrumb"><li class=""><a href="/admin/home/index"><i class="fa fa-home"></i></a></li>
                                            <li class="active">Tutorials Manager</li>
                                        </ul>
                                    </aside>
                                    <aside class="section section__right">
                                        <ul>
                                            <li><a href="/admin/tutorials/create" class="button blue"><i class="fa fa-plus"></i> New</a></li>
                                        </ul>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Design 1 -->
                    <div class="page__bar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <aside class="section section__left">
                                        <h2 class="section__heading upper">Breadcrumb with search</h2>
                                        <ul class="page__bar-breadcrumb"><li class=""><a href="/admin/home/index"><i class="fa fa-home"></i></a></li>
                                            <li class="active">Tutorials Manager</li>
                                        </ul>
                                    </aside>
                                    <aside class="section section__right">
                                        <ul>
                                            <li>
                                                <div class="search__single-bar">
                                                    <div class="input-group right-align">
                                                        <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                        <button type="submit" class="search__single-bar--button blue"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="/admin/tutorials/create" class="button blue"><i class="fa fa-plus"></i> New</a></li>
                                        </ul>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Page bar section -->
                </div>
                <div class="clearfix"></div>
                <!-- Begin Footer section -->

                <?php
                include("includes/_footer.php");
                ?>
                <!-- End Footer section -->
            </div>
        </div>
    </div>
    <!-- End header section -->
</section>

<!-- Begin Script section -->
<?php
include("includes/_scripts.php");
?>
<!-- Begin Script section -->

</body>
</html>