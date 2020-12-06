<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Discom Report Details';
$noDataClass = ($provider->getTotalCount() <= 0) ? ' no-data' : '';


$queryParams = \Yii::$app->request->queryParams;

$fromDate = date('d-m-Y');
$toDate = date('d-m-Y');
if (isset($searchModel->from_date) && !empty($searchModel->from_date)) {
    $fromDate = $searchModel->from_date;
}
if (isset($searchModel->to_date) && !empty($searchModel->to_date)) {
    $toDate = $searchModel->to_date;
}
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
$this->registerJs('StateController.initializeChozen();');
$this->registerJs('StateController.getDiscom();');
?>
<?= $this->render('partials/_sub-menu.php', ['discom' => TRUE]) ?>
<?= $this->render('partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <section class="widget__wrapper">
                        <div class="table__structure">
                            <div class="table__structure__head">
                                <div class="section-head">
                                    <div class="section-head--title"></div>
                                    <div class="section-head__optionSets">
                                        <div class="section-head__optionSets--filter">Search<i class="icon fa fa-angle-down"></i></div>
                                        <?php if (isset($queryParams['ReportSearch']['state_code'])) : ?>
                                            <div class="section-head__optionSets--addButton">
                                                <a class="export" href="<?= Url::toRoute(['report/discom']) ?>">Export</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?=
                                $this->render('_filter-form.php', [
                                    'searchModel' => $searchModel,
                                    'from_date'=>true,
                                    'to_date'=>true,
                                    'state'=>true,
                                    //'district'=>true,
                                    'discom'=>true
                                ])
                                ?>
                                <?php
                                        $gridView = GridView::begin([
                                        'tableOptions' => ['class' => 'table'],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => '<div class="table-responsive margin-bottom-50 table__structure-scrollable ' . $noDataClass . '"><div class="scrolling">{items}</div>{summary}{pager}</div>',
                                        'dataProvider' => $provider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'attribute' => 'districtName',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'villageName',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'mobile',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'email',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'grievance_no',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'grievanceType',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'application_status',
                                                'filter' => false,
                                                 
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'value'=>function($model){
                                                    $applicationStatus = common\models\Grievance::getApplicationStatus();
                                                    return isset($model['application_status']) ? $applicationStatus[$model['application_status']] : 'N/A';
                                                }
                                            ],
                                            [
                                                'attribute' => 'address',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ]
                                         ]
                            ]);
                            $gridView->end()
                            ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
$script = <<< JS
   $(document).on('click', 'a.export', function(event) {
    event.preventDefault(); 
    var url = $(this).attr("href"); 
    window.location = url + '?download=true&' + window.location.search.substring(1);
   });
JS;
$this->registerJs($script);
?>