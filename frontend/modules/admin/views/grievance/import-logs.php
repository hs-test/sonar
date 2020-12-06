<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Import Logs Summary';
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
?>
<?= $this->registerJs('GrievanceController.import();'); ?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => false,'showBackButton' => TRUE]) ?>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <section class="widget__wrapper">
                        <div class="table__structure table__structure-scrollable">
                            <div class="table__structure__head">
                                <div class="section-head">
                                    <div class="section-head--title"></div>
                                    <div class="section-head__optionSets">
                                        <div class="section-head__optionSets--filter">Search<i class="icon fa fa-angle-down"></i></div>
                                    </div>
                                </div>
                                <!----------search flter form---->
                            </div>
                            <!-- End data grid filter section -->
                            <!-- Begin data grid table section -->
                            <?php Pjax::begin(['id' => 'DataList']) ?>
                            <?php
                            $gridView = GridView::begin([
                                        'tableOptions' => [
                                            'class' => 'table'
                                        ],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive noFix scrolling  $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        //'filterSelector' => "input[name='StaffSearch[search]'], select[name='StaffSearch[departments][]']",
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'id' => 'grievanceLogDataTable',
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            [
                                                'header' => 'S.no',
                                                'class' => 'yii\grid\SerialColumn'
                                            ],
                                            [
                                                'header' => 'Date',
                                                'value' => function($model) {
                                                    return isset($model->created_on) && !empty($model->created_on) ? date('d-m-Y', $model->created_on) : '-';
                                                }
                                            ],
                                            [
                                                'header' => 'File',
                                                'format' => 'raw',
                                                'filter' => false,
                                                'value' => function ($model) {
                                                    $link = '<i class="fa fa-close"></i>';
                                                    if (!empty($model->media->cdn_path)) {
                                                        $url = Yii::$app->amazons3->getPrivateMediaUrl($model->media->cdn_path);
                                                        $link = "<a class='icons__download' href='$url'  target='_blank' data-pjax='0'><i class='fa fa-download active'></i></a>";
                                                    }
                                                    return $link;
                                                }
                                            ],
                                            [

                                                'attribute' => 'total',
                                                'header' => 'Total Records',
                                                'filter' => false,
                                            ],
                                            [

                                                'attribute' => 'success',
                                                'header' => 'Success Records',
                                                'filter' => false,
                                            ],
                                            [

                                                'attribute' => 'failed',
                                                'header' => 'Failed Records',
                                                'filter' => false,
                                            ],
                                            [
                                                'attribute' => 'logs',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'format' => 'raw',
                                                'value' => function($model) {
                                            return Html::a('<i class="fa fa-eye"></i>', 'javascript:;', [
                                                        'title' => Yii::t('yii', \Yii::t('admin', 'view')),
                                                        'data-pjax' => '0',
                                                        'data-url' => Url::toRoute(['grievance/import-stat-view', 'id' => $model->id]),
                                                        'class' => 'view viewStat',
                                            ]);
                                        }
                                            ],
                                        ]
                            ]);
                            $gridView->end()
                            ?>
                            <?php Pjax::end() ?>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="viewStatModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="viewStatModal"></div>