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

                    <!-- Begin Accordion section -->
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <section class="widget__wrapper">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="accordian__view">
                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                <h4 class="panel-title extra-icons">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        <div class="title__section">
                                                                            <span class="title__section-content">
                                                                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.
                                                                            </span>
                                                                        </div>
                                                                        <ul class="option-set">
                                                                            <li class="arrowBg">
                                                                                <i class="arrow fa fa-angle-down"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                                <div class="panel-body">
                                                                    <p class="descriptionSection">
                                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                                <h4 class="panel-title extra-icons">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                                        <div class="title__section">
                                                                            <span class="title__section-content">
                                                                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took.
                                                                            </span>
                                                                        </div>
                                                                        <ul class="option-set">
                                                                            <li class="arrowBg">
                                                                                <i class="arrow fa fa-angle-down"></i>
                                                                            </li>
                                                                        </ul>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                <div class="panel-body">
                                                                    <p class="descriptionSection">
                                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div><!-- panel-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Accordion section -->
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