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

                    <!-- Begin Others section -->
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <section class="widget__wrapper">
                                        <div class="widget__wrapper-searchFilter">
                                            <!-- Begin Modal -->
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Modal</a></li>
                                                </ul>
                                            </div>
                                            
                                            <a href="#myModal" class="btn btn-lg btn-primary" data-toggle="modal">Launch Demo Modal</a>
                                            <!-- Modal HTML -->
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
                                                            <button type="button" class="button blue">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </div>
                                    </section>
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