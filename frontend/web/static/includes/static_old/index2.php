<!-- Begin global header section -->
<?php
$pageTitle = 'Admin Dashboard';
$bodyClass = 'walletIntegration2';
include("includes/_global-Head.php");
?>

<!-- End global header section -->

<!-- Begin header section -->
<section id="viewport">
    <div class="page-container">
        <!-- Begin Navigational Area -->
        <?php
        $dashSideActive = 'active';
        include("includes/_sidebar.php");
        ?>
        <!-- //End Navigational Area -->

        <!-- Begin Page Content Area -->
        <div class="page__content-wrapper">
            <div class="page__content-inner">
                <div class="page__content-section noSub__nav">
                    <!-- Begin Page Header Area -->
                    <?php
                    include("includes/_header.php");
                    ?>
                    <!-- //End Page Header Area -->

                    <!-- Begin Others section -->
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="dashboard__wrapper">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="counter__wrapper">
                                                            <!--CUSTOMER COUNTER -->
                                                            <h2 class="counterHead">Customer</h2>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design orange">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-cubes"></i>
                                                                                <h2>1556203</h2>
                                                                                <span>Total</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design green">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-shield"></i>
                                                                                <h2>143203</h2>
                                                                                <span>Approved</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design blue">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa  fa-info-circle"></i>
                                                                                <h2>1413000</h2>
                                                                                <span>Pending</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design red">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-ban"></i>
                                                                                <h2>11235</h2>
                                                                                <span>Rejected</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--CUSTOMER COUNTER -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="charts_wrapper-chart">
                                                            <h2 class="subHead orange">Customer</h2>
                                                            <div id="chart-1"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="counter__wrapper">
                                                            <!--Marchent COUNTER -->
                                                            <h2 class="counterHead">Marchant</h2>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design cyan">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-cubes"></i>
                                                                                <h2>1556203</h2>
                                                                                <span>Total</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design green">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-shield"></i>
                                                                                <h2>143203</h2>
                                                                                <span>Approved</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design blue">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa  fa-info-circle"></i>
                                                                                <h2>1413000</h2>
                                                                                <span>Pending</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="counter__wrapper-design red">
                                                                        <a href="javascript:;">
                                                                            <div class="content">
                                                                                <i class="fa fa-ban"></i>
                                                                                <h2>11235</h2>
                                                                                <span>Rejected</span>
                                                                            </div>
                                                                        </a>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--Marchent COUNTER -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="charts_wrapper-chart">
                                                            <h2 class="subHead cyan">Marchant</h2>
                                                            <div id="chart-2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>         
                                    </div>
                                </div>
                            </div>                   

                            <!-- End Others section -->
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