<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
$this->registerJs("GrievanceController.viewMessageLog()");
?>

<?php Pjax::begin(['id' => 'DataList']) ?>
<div class="table__structure table__structure-scrollable">

    <?php
    $gridView = GridView::begin([
                'tableOptions' => [
                    'class' => 'table'
                ],
                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                'layout' => "<div class='table-responsive scrolling  $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                'dataProvider' => $dataProvider,
                //'filterSelector' => "input[name='StaffSearch[search]'], select[name='StaffSearch[departments][]']",
                'emptyTextOptions' => ['class' => 'empty text-center'],
                //'id' => 'staffDataTable',
                'pager' => [
                    'prevPageLabel' => 'Previous',
                    'nextPageLabel' => 'Next',
                ],
                'columns' => [
                    [
                        'attribute' => 'date',
                    ],
                    [
                        'attribute' => 'subject',
                    ],
                    [
                        'attribute' => 'receiverName',
                    ],
                    [
                        'header' => 'Action',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'visibleButtons' => [

                            'view' => TRUE,
                        ],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-eye"></i>', 'javascript:void(0);', [
                                            'title' => Yii::t('yii', 'View'),
                                            'class' => 'update viewMessageSummary',
                                            'data-url'=>Url::toRoute(['grievance-message-view', 'id' => $model['logId']]),
                                            'data-pjax' => 0,
                                ]);
                            },
                                ],
                                'headerOptions' => [
                                    'class' => 'scrolling__element head'
                                ],
                                'contentOptions' => [
                                    'class' => 'scrolling__element'
                                ]
                            ]
                        ]
            ]);
            $gridView->end()
            ?>
        </div>
        <?php Pjax::end() ?>
<div id="viewMessageLogModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="viewMessageLogModal"></div>