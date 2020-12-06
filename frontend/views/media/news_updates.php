<?php

$formatter = \Yii::$app->formatter;

$this->title = 'News & Updates';

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
                        <img src="/static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="New &amp; Updates">
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
                        <h3 class="title">New &amp; Updates</h3>
                    </div>
                    <div class="new__wrapper">
                        <div class="new__wrapper-listview">
                            <ul>
                                <?php foreach($news as $row): ?>
                                <li>
                                    <div class="info">
                                        <div class="info-date">
                                            <?= $formatter->asDate($row->created_at, 'd') ?>
                                        </div>
                                        <div class="info-year">
                                            
                                            <p><?= $formatter->asDate($row->created_at,'MMM') ?><span class="year"><?= $formatter->asDate($row->created_at,'Y') ?></span></p>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4><?= $row->title ?></h4>
                                        <p><?= substr($row->content, 0, 135) ?><?= (strlen($row->content)>135)?'...':'' ?></p>
                                        
                                        <?= \yii\helpers\Html::a('Read More',['news-details','guid'=>$row->guid],['class'=>'button reset']) ?>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>