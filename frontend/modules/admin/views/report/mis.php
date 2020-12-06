<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = (isset($title)) ? $title : 'Mis Report';
$noDataClass = ($provider->getTotalCount() <= 0) ? ' no-data' : '';

$fromDate = date('d-m-Y');
$toDate = date('d-m-Y');
if (isset($searchModel->from_date) && !empty($searchModel->from_date)) {
    $fromDate = $searchModel->from_date;
}
if (isset($searchModel->to_date) && !empty($searchModel->to_date)) {
    $toDate = $searchModel->to_date;
}
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
?>
<?= $this->render('partials/_sub-menu.php', ['mis' => TRUE]) ?>
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
                                        <div class="section-head__optionSets--addButton">
                                            <a class="export" href="<?= Url::toRoute(['report/mis']) ?>">Export</a>
                                        </div>
                                    </div>
                                </div>
                                <?=
                                $this->render('_filter-form.php', [
                                    'from_date' => true,
                                    'to_date' => true,
                                    'status' => true,
                                    'searchModel' => $searchModel,
                                ])
                                ?>
                                <?php
                                $gridView = GridView::begin([
                                            'tableOptions' => ['class' => 'table'],
                                            'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                            'layout' => '<div class="table-responsive margin-bottom-50 table__structure-scrollable ' . $noDataClass . '"><div class="scrolling">{items}</div>{summary}{pager}</div>',
                                            'dataProvider' => $provider,
                                            'emptyTextOptions' => [ 'class' => 'empty text-center'],
                                            'pager' => [
                                                'prevPageLabel' => 'Previous',
                                                'nextPageLabel' => 'Next',
                                            ],
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                   'header' => 'Posting Month',
                                                   'filter' => false,
                                                    'value'=>function($model){
                                                        return !empty($model['posting_date']) ? date('M',  strtotime($model['posting_date'])) : '-';
                                                    }
                                                     
                                                ],
                                                [
                                                    'attribute' => 'posting_date',
                                                    'filter' => false,
                                                    'sortLinkOptions' => [ 'class' => 'sort'],
                                                    'format' => ['date', 'php:d-m-Y']
                                                ],
                                                [
                                                    'attribute' => 'srn_no',
                                                    'filter' => false,
                                                    'sortLinkOptions' => [ 'class' => 'sort'],
                                                ],
                                                [
                                                    'attribute' => 'name',
                                                    'header' => 'Dealing Head',
                                                    'filter' => false,
                                                    'sortLinkOptions' => ['class' => 'sort'],
                                                    'value' => function($model) {
                                                return isset($model['name']) && !empty($model['name']) ? $model['name'] : '-';
                                            }
                                                ],
                                                [
                                                    'attribute' => 'applicant_name',
                                                    'filter' => false,
                                                    'sortLinkOptions' => [ 'class' => 'sort'],
                                                ],
                                                [
                                                    'header' => 'CIN/Company Name',
                                                    'filter' => false,
                                                    'sortLinkOptions' => ['class' => 'sort'],
                                                    'value' => function($model) {
                                                    $companyName = (!empty($model['cin_no']) && !empty($model['companyName'])) ? $model['cin_no'] . '/' . $model['companyName'] : '-';
                                                      return $companyName;//$model->cin_no . '/' . $model->companyName;
                                            }
                                                ],
                                                [
                                                    'header' => 'Status',
                                                    'filter' => false,
                                                    'sortLinkOptions' => ['class' => 'sort'],
                                                    'value' => function($model) {
                                                      
                                                    return (!empty($model['applicationStatus'])) ?  \common\models\Grievance::getGrievanceStatusArr($model['applicationStatus'], TRUE): '-';
                                            }
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