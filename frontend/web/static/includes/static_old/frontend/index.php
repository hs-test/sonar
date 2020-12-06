<!-- Begin global header section -->
<?php
$pageTitle = 'REC';
$bodyClass = '';
include("includes/_global-Head.php");
include("includes/_header.php");
?>
<div class="clearfix"></div>
<!-- Begin Home Banner -->
<div class="banner__wrapper">
    <div class="banner__wrapper-home home--slide"> 
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="static/images/banners/home/banner-1.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="static/images/banners/home/banner-2.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
        <div class="banner__wrapper-home--item">
            <figure>
                <img src="static/images/banners/home/banner-3.png" alt="banner" class="img-fluid">  
            </figure>
        </div>
    </div>  
    <div class="banner__wrapper-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Growing Hands for Every One<span>Submit your grievance today</span></h3>
                    <div class="action__form">
                        <div class="action__form-main">
                            <form>
                                <div class="form-group">
                                    <label class="label" for="Name"><span class="">Name</span></label>
                                    <input type="text" id="Name" placeholder="Enter Name" class="form-control" name="RegistrationForm[name]" aria-required="true"> 
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group">
                                    <label class="label" for="Mobile Number"><span class="">Mobile Number</span></label>
                                    <input type="text" id="Name" placeholder="Enter Mobile Number" class="form-control" name="RegistrationForm[mobilenumber]" aria-required="true"> 
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group">
                                    <label class="label" for="Email"><span class="">Email</span></label>
                                    <input type="text" id="Name" placeholder="Enter Email" class="form-control" name="RegistrationForm[mobilenumber]" aria-required="true"> 
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <button type="button"  class="button theme__btn" data-toggle="modal" data-target="#exampleModalCenter">Submit Now</button>
                            </form>
                        </div>
                        <div class="action__form-helpline">
                            <p>Do you need any help? Call Now</p>
                            <span class="helpline--number">1800 121 5555 <i class="fas fa-phone-square"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- End Home Banner -->
<!-- Begin Counter Wrapper -->
<div class="counter__wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="counter__wrapper-block">
                    <li class="counter__wrapper-block-tile clr1">
                        <h3 class="tile--head">Total Complaint</h3>
                        <span class="tile--count">98586954</span>
                        <span class="tile--icon">
                            <figure> 
                                <img src="static/images/icons/svg/total-c.svg" alt="Total Complaint" class="img-fluid">
                            </figure>
                        </span>
                    </li>
                    <li class="counter__wrapper-block-tile clr2">
                        <h3 class="tile--head">Completed Complaint</h3>
                        <span class="tile--count">98586000</span>
                        <span class="tile--icon">
                            <figure> 
                                <img src="static/images/icons/svg/completed-c.svg" alt="Completed Complaint" class="img-fluid">
                            </figure>
                        </span>
                    </li>
                    <li class="counter__wrapper-block-tile clr3">
                        <h3 class="tile--head">Pending Complaint</h3>
                        <span class="tile--count">954</span>
                        <span class="tile--icon">
                            <figure> 
                                <img src="static/images/icons/svg/pending-c.svg" alt="Pending Complaint" class="img-fluid">
                            </figure>
                        </span>
                    </li> 
                </ul>
            </div> 
        </div>
    </div>
</div>
<!-- End Counter Wrapper -->
<div class="home-body">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">
                        <div class="content--wrap">
                            <div class="section-head">
                                <h3 class="title">About REC</h3>
                            </div>
                            <p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries  , but also the leap into electronic typesetting,</p>
                            <p>remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages Ipsum....</p>
                            <a href="about-digital-village.php" class="button theme__btn">Read More</a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
                        <figure>
                            <img src="static/images/content-images/about-img.png" alt="About Us" class="img-fluid">
                        </figure>
                    </div>
                </div> 
            </div>
        </div>
    </div> 
</div>
<div class="state__info">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="infotile">
                    <div class="infotile__view">
                        <div class="infotile__view-content">
                            <span class="fa fa-map"></span>
                            <p>State Covered</p>
                            <h4>77</h4>
                        </div>
                    </div>
                    <div class="infotile__view">
                        <div class="infotile__view-content">
                            <span class="fas fa-map-marker-alt"></span>
                            <p>District Covered</p>
                            <h4>9856</h4>
                        </div>
                    </div>
                    <div class="infotile__view">
                        <div class="infotile__view-content">
                            <span class="fa fa-envelope"></span>
                            <p>Registered Offices</p>
                            <h4>235</h4>
                        </div>
                    </div><div class="infotile__view">
                        <div class="infotile__view-content">
                            <span class="fa fa-home"></span>
                            <p>Village Covered</p>
                            <h4>895689</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="clearfix"></div>
<?php
include("includes/_footer.php");
include("includes/_scripts.php");
