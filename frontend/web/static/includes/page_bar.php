<?php
    $pageHead = isset($pageHead) ? $pageHead : '';
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-10">
                <ul class="page__bar-breadcrumb">
                    <li><?= $pageHead ?></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;">Creative<span class="drop"><i class="fa fa-angle-down"></i></span></a>
                        <ul class="dropdown-menu simple__menu simple__menu-iconRight">
                            <li><a href="#">Blogs <i class="fa fa-pencil"></i></a></li>
                            <li><a href="#">Pages <i class="fa fa-copy"></i></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 text-right">
                <div class="ellipsisControl pull-right"><button type="button" class="button button-noborder-Bg" data-toggle="dropdown" data-close-others="true" data-hover="dropdown"><i class="fa fa-ellipsis-h"></i></button>
                    <ul class="dropdown-menu pull-right simple__menu">
                        <li>
                            <ul class="dropdown-menu-list scroller-dropdown">
                                <li class="switchery__click"><a href="javascript:void(0);">Active <input type="checkbox" class="js-switch" checked /></a></li>
                                <li><a href="#">Commented</a></li>
                                <li><a href="#">Liked</a></li>
                                <li><a href="#">Searched</a></li>
                                <li><a href="#">Viewed</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>