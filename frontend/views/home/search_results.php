<div class="clearfix"></div>
<div class="page-header">
    <div class="page-header__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('/layouts/partials/breadcrumb.php')?>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header__innerbanner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 no-padding">
                    <figure>
                        <img src="static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="New &amp; Updates">
                    </figure>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="inner-body">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?= $this->render('/layouts/partials/comman.php') ?>
                <div class="content--area">
                    <div class="section-head">
                        <h3 class="title">Serach Results</h3>
                    </div>
                    <div class="new__wrapper">
                        <div class="new__wrapper-listview">
                            <div class="section-head">
                                <h4 class="sub-title">You are searching for "<span><?= $q ?></span>"</h4>
                            </div> 
                            <ul> 
                                <?php foreach($dataProvider as $row): ?>
                                
                                <li>
                                    <div class="content">
                                        <h4><?= $row->title ?></h4>
                                        <p><?= substr(strip_tags($row->content),0,135) ?>...</p>
                                        <a href="/<?= $row->slug ?>" class="button reset">Read More</a>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if(!count($dataProvider)): ?>
                            Nothing Found.
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>