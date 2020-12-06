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

                    <!-- Begin data grid section -->
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <section class="widget__wrapper">
                                        <!-- Begin data grid filter section -->
                                        <div class="widget__wrapper-searchFilter grey-theme">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <input class="form-control" placeholder="Search" name="CmsSearch[search]" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <input class="form-control" placeholder="Search" name="CmsSearch[search]" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <input class="form-control" placeholder="Search" name="CmsSearch[search]" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <input class="form-control" placeholder="Search" name="CmsSearch[search]" type="text">
                                                        </div>
                                                    </div>                                                
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="actoin-set">
                                                            <a href="javascript:;" class="button blue">Search</a>
                                                            <a href="javascript:;" class="button grey">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- End data grid filter section -->

                                        <!-- Begin data grid table section -->
                                        <div class="table-responsive margin-bottom-50 table__structure-scrollable">
                                            <div class="scrolling">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort asc" href="javascript:;">
                                                                    Title - 1
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort desc" href="javascript:;">
                                                                    Title - 2
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 3
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 4
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 5
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 6
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 7
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 8
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 9
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 10
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 11
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 12
                                                                </a>
                                                            </th>
                                                            <th class="scrolling__element head">
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="summary">Showing <b>1 - 5</b> of <b>5</b> items.</div>

                                            <ul class="pagination">

                                                <li><a href="#">&laquo;</a></li>

                                                <li class="active"><a href="#">1</a></li>

                                                <li><a href="#">2</a></li>

                                                <li><a href="#">3</a></li>

                                                <li><a href="#">4</a></li>

                                                <li><a href="#">5</a></li>

                                                <li><a href="#">&raquo;</a></li>

                                            </ul>


                                        </div>

                                        <!-- without scrolling -->

                                        <div class="table-responsive margin-bottom-50 table__structure-scrollable">
                                            <div class="">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 1
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 2
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 3
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 4
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 5
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 6
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 7
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 8
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 9
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 10
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 11
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 12
                                                                </a>
                                                            </th>
                                                            <th class="scrolling__element head">
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Title Description
                                                            </td>
                                                            <td>
                                                                Title Description -1
                                                            </td>
                                                            <td>
                                                                Title Description -2
                                                            </td>
                                                            <td>
                                                                Title Description -3
                                                            </td>
                                                            <td>
                                                                Title Description -4
                                                            </td>
                                                            <td>
                                                                Title Description -5
                                                            </td>
                                                            <td>
                                                                Title Description -6
                                                            </td>
                                                            <td>
                                                                Title Description -7
                                                            </td>
                                                            <td>
                                                                Title Description -8
                                                            </td>
                                                            <td>
                                                                Title Description -9
                                                            </td>
                                                            <td>
                                                                Title Description -10
                                                            </td>
                                                            <td>
                                                                Title Description -11
                                                            </td>
                                                            <td>
                                                                Title Description -12
                                                            </td>
                                                            <td class="scrolling__element">
                                                                <a href="javascript:;" class="icons icons__view">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:;" class="icons icons__edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="summary">Showing <b>1 - 5</b> of <b>5</b> items.</div>
                                        </div>

                                        <div class="table-responsive margin-bottom-50 table__structure-scrollable">
                                            <div class="scrolling no-data">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 1
                                                                </a>
                                                            </th>
                                                            <th>
                                                                <a class="sort" href="javascript:;">
                                                                    Title - 2
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="empty text-center">No results found.</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End data grid table section -->
                                    </section>
                                    <!-- End data grid section -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="clearfix"></div>
                <!-- Begin Footer section -->

                <?php
                include("includes/_footer.php");
                ?>
                <!-- End Footer section -->
            </div>
        </div>

        <div>

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