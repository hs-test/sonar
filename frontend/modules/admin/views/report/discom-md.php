<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Discom Report Summary';
$noDataClass = ($provider->getTotalCount() <= 0) ? ' no-data' : '';

$queryParams = \Yii::$app->request->queryParams;
 
$this->registerJs('StateController.initializeChozen();');
$this->registerJs('StateController.getDiscom();');
?>
<?= $this->render('partials/_sub-menu.php', ['discom_md' => TRUE]) ?>
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
                                                <a class="export" href="<?= Url::toRoute(['report/discom-md']) ?>">Export</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?=
                                $this->render('_filter-form.php', [
                                    'searchModel' => $searchModel,
                                    'state' => TRUE,
                                    //'district' => TRUE,
                                    'discom'=>TRUE
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
                                              'attribute' => 'stateName',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],  
                                            ],
                                            [
                                              'attribute' => 'discom',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],  
                                            ],
                                            
                                            [
                                                'attribute' => 'districtName',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'totalRecords',
                                                'filter' => false,
                                                'label' => 'No. of Grievances Received',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],[
                                                'attribute' => 'resolved',
                                                'filter' => false,
                                                'label' => 'No. of Grievances Resolved',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'ongoing',
                                                'filter' => false,
                                                'label'=>'No. of Grievances Ongoing',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'pending',
                                                'filter' => false,
                                                 'label'=>'No. of Grievances pending',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                     
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