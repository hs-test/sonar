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
                                            <li class=""><a href="profile.php">Edit Profile</a></li>
                                            <li class="active"><a href="table-view.php">Table View</a></li>
                                            <li class=""><a href="javascript:;">Network</a></li>
                                            <li class=""><a href="javascript:;">Notifications</a></li>
                                        </ul>
                                        <div class="tabbable__content">
                                            <div class="table__structure">
                                                <div class="table__structure-scrollable scrolling">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Page Name</th>
                                                                <th>No. of Sub Pages</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                                <th>ID</th>
                                                                <th>Page Name</th>
                                                                <th width="300px">No. of Sub Pages</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                                <th>Actions</th>
                                                                <th>Actions</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="editable_wrapper">
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td width="300px">Home</td>
                                                                <td>0</td>
                                                                <td>
                                                                    <div class="dropdown dropdown-bar">
                                                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><span>Publish</span> <span class="fa fa-angle-down"></span></button>
                                                                        <ul class="dropdown-menu simple__menu no-shadow pull-left">
                                                                            <li><a href="javascript:;">Publish</a></li>
                                                                            <li><a href="javascript:;">Draft</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <td>0</td>
                                                                <td>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-check green-color"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td>Home</td>
                                                                <td>0</td>
                                                                <td width="300px">
                                                                    <div class="attribute_block">
                                                                        <span class="text-label">Attributed to:</span>
                                                                        <div class="controls">
                                                                            <span class="editable-field">
                                                                                <span>Name</span>
                                                                                <span class="overlay-edit" title="Click to edit"><i class="fa fa-pencil"></i></span>
                                                                            </span>
                                                                            <div class="select-option">
                                                                                <select class="chosen integrationAttribute" tabindex="-1" name="integration_attribute"  data-placeholder="Choose an Attribute">
                                                                                    <option>Mayank</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </td>
                                                                <td>0</td>
                                                                <td>
                                                                    <div class="dropdown dropdown-bar">
                                                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><span>Publish</span> <span class="fa fa-angle-down"></span></button>
                                                                        <ul class="dropdown-menu simple__menu no-shadow pull-left">
                                                                            <li><a href="javascript:;">Publish</a></li>
                                                                            <li><a href="javascript:;">Draft</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <td>0</td>
                                                                <td>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-check green-color"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a href="javascript:;" class="nonstyled">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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