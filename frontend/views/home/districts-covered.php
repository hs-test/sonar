<?php
$this->title = 'Districts Covered';

$this->params['breadcrumbs'][] = [
    'label' => $this->title, 
    'url' => yii\helpers\Url::toRoute(['/home/districts-covered'])
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template'=>'<li class="breadcrumb-item active">{link}</li>'
];

if($type == 'survey') {
    $title = 'Survey';
}
elseif($type == 'facilitation') {
    $title = 'Facilitation Centre';
}
elseif($type == 'health_kit') {
    $title = 'Tele-Consultation Centre';
}
elseif($type == 'bcc') {
    $title = 'Education - BCC';
}
elseif($type == 'ccc') {
    $title = 'Education - CCC';
}
else {
    $title = 'Education - Tally';
}
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
                        <img style="width:100%;" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/images/banners/inner/districtscover.jpg" class="img-fluid" alt="<?= $this->title ?>">
                    </figure>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="inner-body">
    <div class="container">
        <div class="section-head">
            <h3 class="title"><?= $title?></h3>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="has-margin-bottom-15 text-center">Districts of <?= $state['name']?></h3>
                <div class="page-content-section">
                        <div class="content-wrapper">
                            <div class="theme__table theme__table-withColoredRow theme__table-withColoredHead theme__table-withActionSection">
                                <div class="table-responsive">
                                    <table class="table table-bordered"> 
                                        <thead>
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>District </th>
                                                <th><?= ($type == 'facilitation' || $type == 'health_kit')? 'VLEs' : 'Beneficiaries'?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($districts as $district): ?>
                                            <tr>
                                                <td><?= $i?></td>
                                                <td><?= $district['name'] ?></td>
                                                <td><?= $district['total'] ?></td>
                                            </tr>
                                            <?php $i++;endforeach; ?>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>