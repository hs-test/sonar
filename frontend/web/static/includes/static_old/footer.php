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

                    <!-- Begin Buttons section -->
                    <div class="footer">
                        <div class="container">
                            <div class="col-md-12 col-xs-12">
                                <div class="footer__content multi">
                                    <ul>
                                        <li class="">
                                            <a href="javascript:;">
                                                <figure>
                                                    <img src="dist/images/redox_logo.png" alt="Logo" />
                                                </figure>
                                            </a>
                                        </li>
                                        <li>2017 Project Name   |   All rights reserved</li>
                                    </ul>
                                </div>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="footer">
                        <div class="container">
                            <div class="col-md-12 col-xs-12">
                                <div class="footer__content multi">
                                    <ul>
                                        <li class="multi">
                                            <a href="javascript:;">
                                                <figure>
                                                    <img src="dist/images/redox_logo.png" alt="Logo" />
                                                </figure>
                                            </a>
                                            <a href="javascript:;">
                                                <figure>
                                                    <img src="dist/images/redox_logo.png" alt="Logo" />
                                                </figure>
                                            </a>
                                        </li>
                                        <li>2017 Project Name   |   All rights reserved</li>
                                    </ul>
                                </div>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="footer">
                        <div class="container">
                            <div class="col-md-12 col-xs-12">
                                <div class="footer__content">
                                    <ul>
                                        <li>2017 Project Name   |   All rights reserved</li>
                                    </ul>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <!-- End Buttons section -->
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