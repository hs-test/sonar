<?php

$this->title = $page['title'];

$this->params['breadcrumbs'][] = [
    'label' => 'Services',
    'url'=>'javascript:;'
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template'=>'<li class="breadcrumb-item active">{link}</li>'
];


?>
<div class="clearfix"></div>
<div class="page-header">
    <div class="page-header__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <?= $this->render('/layouts/partials/breadcrumb.php') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header__innerbanner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 no-padding">
                    <figure>
                        <img src="/static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="<?= $this->title ?>">
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
                <?= $this->render('/layouts/partials/services.php') ?>
                <div class="content--area">
                    <div class="section-head">
                        <h3 class="title"><?= $this->title ?></h3>
                    </div>
                    
                    <?= $page['content'] ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>