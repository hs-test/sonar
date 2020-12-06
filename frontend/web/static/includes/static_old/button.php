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
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <section class="widget__wrapper">
                                        <div class="widget__wrapper-searchFilter">
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Fill Buttons</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="button yellow">Button</a>
                                            <a href="javascript:;" class="button yellowOrange">Button</a>
                                            <a href="javascript:;" class="button orange">Button</a>
                                            <a href="javascript:;" class="button redOrange">Button</a>
                                            <a href="javascript:;" class="button red">Button</a>
                                            <a href="javascript:;" class="button redViolet">Button</a>
                                            <a href="javascript:;" class="button violet">Button</a>
                                            <a href="javascript:;" class="button blueViolet">Button</a>
                                            <a href="javascript:;" class="button blue">Button</a>
                                            <a href="javascript:;" class="button blueGreen">Button</a>
                                            <a href="javascript:;" class="button green">Button</a>
                                            <a href="javascript:;" class="button yellowGreen">Button</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Outline Buttons</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="button yellow bordered">Button</a>
                                            <a href="javascript:;" class="button yellowOrange bordered">Button</a>
                                            <a href="javascript:;" class="button orange bordered">Button</a>
                                            <a href="javascript:;" class="button redOrange bordered">Button</a>
                                            <a href="javascript:;" class="button red bordered">Button</a>
                                            <a href="javascript:;" class="button redViolet bordered">Button</a>
                                            <a href="javascript:;" class="button violet bordered">Button</a>
                                            <a href="javascript:;" class="button blueViolet bordered">Button</a>
                                            <a href="javascript:;" class="button blue bordered">Button</a>
                                            <a href="javascript:;" class="button blueGreen bordered">Button</a>
                                            <a href="javascript:;" class="button green bordered">Button</a>
                                            <a href="javascript:;" class="button yellowGreen bordered">Button</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Buttons responsive fullwidth</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="button mob__fullwidth-599 responsive-button yellow bordered">Button</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Buttons set which include 2 or more buttons together</a></li>
                                                </ul>
                                            </div>
                                            <div class="actoin-set">
                                                <a href="javascript:;" class="button yellow bordered">Button</a>
                                                <a href="javascript:;" class="button yellowOrange bordered">Button</a>
                                            </div>
                                            
                                             <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Search button colors</a></li>
                                                </ul>
                                            </div>
                                            <div class="search__single-bar">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button yellow"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button yellowOrange"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button orange"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button redOrange"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button red"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button redViolet"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button violet"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button blueViolet"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button blue"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button blueGreen"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button green"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                             
                                             <div class="search__single-bar has-margin-top-20">
                                                <div class="input-group">
                                                    <input class="form-control" name="SectionSearch[search]" placeholder="Search" type="search">
                                                    <button type="submit" class="search__single-bar--button yellowGreen"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Links style</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="link link-grey">Link color</a>
                                            <a href="javascript:;" class="link link-yellow">Link color</a>
                                            <a href="javascript:;" class="link link-yellowOrange">Link color</a>
                                            <a href="javascript:;" class="link link-orange">Link color</a>
                                            <a href="javascript:;" class="link link-redOrange">Link color</a>
                                            <a href="javascript:;" class="link link-red">Link color</a>
                                            <a href="javascript:;" class="link link-redViolet">Link color</a>
                                            <a href="javascript:;" class="link link-violet">Link color</a>
                                            <a href="javascript:;" class="link link-blueViolet">Link color</a>
                                            <a href="javascript:;" class="link link-blue">Link color</a>
                                            <a href="javascript:;" class="link link-blueGreen">Link color</a>
                                            <a href="javascript:;" class="link link-green">Link color</a>
                                            <a href="javascript:;" class="link link-yellowGreen">Link color</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Links with underline style</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="link link-grey underline">Link color</a>
                                            <a href="javascript:;" class="link link-yellow underline">Link color</a>
                                            <a href="javascript:;" class="link link-yellowOrange underline">Link color</a>
                                            <a href="javascript:;" class="link link-orange underline">Link color</a>
                                            <a href="javascript:;" class="link link-redOrange underline">Link color</a>
                                            <a href="javascript:;" class="link link-red underline">Link color</a>
                                            <a href="javascript:;" class="link link-redViolet underline">Link color</a>
                                            <a href="javascript:;" class="link link-violet underline">Link color</a>
                                            <a href="javascript:;" class="link link-blueViolet underline">Link color</a>
                                            <a href="javascript:;" class="link link-blue underline">Link color</a>
                                            <a href="javascript:;" class="link link-blueGreen underline">Link color</a>
                                            <a href="javascript:;" class="link link-green underline">Link color</a>
                                            <a href="javascript:;" class="link link-yellowGreen underline">Link color</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Links with icon left align style</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="link link-grey"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-yellow"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-yellowOrange"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-orange"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-redOrange"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-red"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-redViolet"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-violet"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-blueViolet"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-blue"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-blueGreen"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-green"><i class="fa fa-user"></i>Link color</a>
                                            <a href="javascript:;" class="link link-yellowGreen"><i class="fa fa-user"></i>Link color</a>
                                            
                                            <div class="clearfix has-margin-top-20"></div>
                                            
                                            <div class="sectionHead__wrapper">
                                                <ul class="upper">
                                                    <li class="active"><a href="javascript:;">Links with icon right align style</a></li>
                                                </ul>
                                            </div>
                                            <a href="javascript:;" class="link link-grey">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-yellow">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-yellowOrange">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-orange">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-redOrange">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-red">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-redViolet">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-violet">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-blueViolet">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-blue">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-blueGreen">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-green">Link color <i class="right-icon fa fa-user"></i></a>
                                            <a href="javascript:;" class="link link-yellowGreen">Link color <i class="right-icon fa fa-user"></i></a>
                                        </div>
                                    </section>
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