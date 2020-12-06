<?php
    $dashSideActive = isset($dashSideActive) ? $dashSideActive : '';
    $learnersSideActive = isset($learnersSideActive) ? $learnersSideActive : ''; 
?>


<aside class="page__sidebar">
    <div class="page__sidebar-wrapper navbar-collapse">
        <div class="page__sidebar-profile">
            <div class="page__sidebar-profile--image image-covered"><!-- Blank Tag --></div>
            
            <div class="caption">
                <a href="javascript:;">
                    <figure>
                        <img src="dist/images/logo.png" alt="Redox Logo"  class="img-responsive" />
                    </figure>
                </a>
            </div>
        </div>
        <div class="page__sidebar-standaloneNav">
            <ul class="page__sidebar-standaloneNav-listing"> 
                <li class="<?=$dashSideActive?>">
                    <a href="dashboard.php">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>               
                <li class="<?=$learnersSideActive?> sub-children">
                    <a href="javascript:;">
                        <i class="is is-group"></i>
                        <span class="title">Service Provider Managers</span>
                        <span class="arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-nav">
                            <li class="">
                                <a class="submenu-link" href="javascript:;">
                                    <i class="fa fa-angle-double-right"></i> Service Provider
                                </a>
                            </li>
                            <li class="">
                                <a class="submenu-link" href="javascript:;">
                                    <i class="fa fa-angle-double-right"></i> Service Provider Manager
                                </a>
                            </li>                           
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="is is-briefcase-alt"></i>
                        <span class="title">State Agency</span>
                    </a>
                </li> 
                <li>
                    <a href="javascript:;">
                        <i class="is is-clipboard2"></i>
                        <span class="title">VLE</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="is is-clipboard2"></i>
                        <span class="title">Sub VLE</span>
                    </a>
                </li>
                <li class="sub-children">
                    <a href="javascript:;">
                        <i class="is is-id-v3-alt"></i>
                        <span class="title">Customer Manager</span>
                        <span class="arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-nav">
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Customers
                            </a>
                        </li>                           
                    </ul>
                </li>
                <li class="sub-children">
                    <a href="javascript:;">
                        <i class="is is-id-alt"></i>
                        <span class="title">Merchant Manager</span>
                        <span class="arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-nav">
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Merchants
                            </a>
                        </li>                           
                    </ul>
                </li>
                <li class="sub-children">
                    <a href="javascript:;">
                        <i class="is is-pin"></i>
                        <span class="title">Location Managers</span>
                        <span class="arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-nav">
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> States
                            </a>
                        </li>
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Districts
                            </a>
                        </li>
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Blocks
                            </a>
                        </li>
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Panchayats
                            </a>
                        </li>
                        <li class="">
                            <a class="submenu-link" href="javascript:;">
                                <i class="fa fa-angle-double-right"></i> Villages
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- Begin Responsive Profile -->
<div class="responsive-standalone">
    <a href="javascript:;" class="responsive-standalone-close">
        <span class="close-text">Close</span>
        <span class="fa fa-close" aria-hidden="true"></span>
    </a>
    <div class="standalone-menu"></div>
</div>
<div class="responsive-standalone-overlay"></div>
<!-- //End Responsive Profile -->