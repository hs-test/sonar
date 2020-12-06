<!-- Begin global header section -->
<?php
$pageTitle = 'Admin Dashboard';
$bodyClass = 'walletIntegration';
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
                                        <!--CUSTOMER COUNTER -->
                                        <div class="counter__wrapper">
                                            <h2 class="counterHead">Customer</h2>
                                            <ul>
                                                <li>
                                                    <a href="javascript:;" class="covered"  style="background: url('dist/images/counter-pt-1.jpg');">
                                                        <div class="counter__wrapper-main overlay__orange">
                                                            <div class="content">
                                                                <span class="is is-book-alt"></span>
                                                                <h2>15860</h2>
                                                                <p>Total</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li> 
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__green">
                                                            <div class="content">
                                                                <span class="is is-easel-alt"></span>
                                                                <h2>14400</h2>
                                                                <p>Approved</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__darkPurple">
                                                            <div class="content">
                                                                <span class="is is-clipboard2"></span>
                                                                <h2>1360</h2>
                                                                <p>Pending</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__red">
                                                            <div class="content">
                                                                <span class="is is-book-alt"></span>
                                                                <h2>100</h2>
                                                                <p>Rejected</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>  
                                            </ul> 
                                        </div>
                                        <!-- CUSTOMER COUNTER End -->
                                        <!--Marchent COUNTER -->
                                        <div class="counter__wrapper">
                                            <h2 class="counterHead">Marchent</h2>
                                            <ul>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__skyBlue">
                                                            <div class="content">
                                                                <span class="is is-book-alt"></span>
                                                                <h2>15860</h2>
                                                                <p>Total</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li> 
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__green">
                                                            <div class="content">
                                                                <span class="is is-easel-alt"></span>
                                                                <h2>14400</h2>
                                                                <p>Approved</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__darkPurple">
                                                            <div class="content">
                                                                <span class="is is-clipboard2"></span>
                                                                <h2>1360</h2>
                                                                <p>Pending</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="counter__wrapper-main overlay__red">
                                                            <div class="content">
                                                                <span class="is is-book-alt"></span>
                                                                <h2>100</h2>
                                                                <p>Rejected</p>
                                                            </div>
                                                         </div>  
                                                    </a>
                                                </li>  
                                            </ul> 
                                        </div>
                                        <!-- Marchent COUNTER End -->
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="charts_wrapper-chart">
                                                    <h2 class="subHead">Customers</h2>
                                                    <div id="chart-1"></div>
                                                </div>
                                            </div> 
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="charts_wrapper-chart">
                                                    <h2 class="subHead">Marchant</h2>
                                                    <div id="chart-2"></div>
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