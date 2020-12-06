<?php
use common\models\Media;

$this->title = 'Gallery';

$this->params['breadcrumbs'][] = [
    'label' => 'Media',
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
                        <img src="/static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="Gallery">
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
                        <h3 class="title">Gallery</h3>
                    </div>
                    <div class="tabs__wrapper">
                        <!-- Nav pills -->
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#photos" aria-expanded="true">Photos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#videos" aria-expanded="false">Videos</a>
                            </li> 
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="photos" class="container tab-pane active" aria-expanded="true">
                                <br>
                                <?php foreach ($sliderList as $slider): ?>
                                <h3><?= $slider['title'] ?></h3> 
                                <div class="gallery__view">
                                    <ul>
                                        
                                        <?php 
                                        
                                        $mediaList = common\models\SliderMedia::getSliderMedia($slider['id']);
                                        if (isset($mediaList) && count($mediaList) > 0):
                                            
                                            foreach($mediaList as $media):
                                        
                                                if($media['media_type'] == Media::TYPE_IMAGE):  ?>
                                        
                                                <li>
                                                    <figure> 
                                                        <a data-fancybox="Our Gallery" href="<?= $media['cdn_path'] ?>">
                                                            <img src="<?= $media['cdn_path'] ?>" alt="Our Gallery" class="img-fluid">
                                                            <span class="caption"><span class="fa fa-search icon"></span></span>
                                                        </a>
                                                    </figure>
                                                </li>
                                        
                                        <?php endif; ?>
                                        
                                        <?php endforeach;?>
                                                
                                        <?php endif; ?>
                                        
                                    </ul>
                                </div>
                                <div class="clearfix"><!-- blank tag --></div>
                                <div class="divider-lineV2"><!-- blank tag --></div>
                                <?php endforeach; ?>
                                
                            </div>
                            <div id="videos" class="container tab-pane" aria-expanded="false">
                                <br>
                                <?php foreach ($sliderList as $slider): ?>
                                <h3><?= $slider['title'] ?></h3> 
                                <div class="gallery__view">
                                    <ul>
                                        
                                        <?php 
                                        
                                        $mediaList = common\models\SliderMedia::getSliderMedia($slider['id']);
                                        if (isset($mediaList) && count($mediaList) > 0):
                                        
                                            foreach($mediaList as $media):
                                        
                                                if(in_array($media['media_type'], [Media::TYPE_VIDEO, Media::TYPE_ATTACHMENT]) ): ?>
                                                    <li>
                                                        <figure> 
                                                            <a data-fancybox="Our Gallery" href="<?= $media['cdn_path'] ?>">
                                                                <img src="<?= $media['cdn_path'] ?>" alt="Our Gallery" class="img-fluid">
                                                                <span class="caption"><span class="fa fa-play icon"></span>Lorem I Ispum dymmy text will goes here spum dymmy text will goes here...</span>
                                                            </a>
                                                        </figure>
                                                    </li>
                                        
                                        <?php endif; ?>
                                        
                                        <?php endforeach; ?>
                                                    
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="clearfix"><!-- blank tag --></div>
                                <div class="divider-lineV2"><!-- blank tag --></div>
                                <?php endforeach; ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
