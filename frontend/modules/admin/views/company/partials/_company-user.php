<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$noDataClass = ($users->getTotalCount() <= 0) ? ' no-data' : '';
?>
<?php Pjax::begin(['id' => 'DataList']) ?>
<div class="table__structure table__structure-scrollable">

    <?php
    $gridView = GridView::begin([
                'tableOptions' => [
                    'class' => 'table'
                ],
                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                'layout' => "<div class='table-responsive scrolling  noFix $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                'dataProvider' => $users,
                'emptyTextOptions' => ['class' => 'empty text-center'],
                'id' => 'commentTable',
                'pager' => [
                    'prevPageLabel' => 'Previous',
                    'nextPageLabel' => 'Next',
                ],
                'columns' => [
                    [
                        'attribute' => 'contact_person',
                    ],
                    [
                        'attribute' => 'email',
                    ],
                    [
                        'attribute' => 'address',
                    ],
                    [
                        'header' => 'Action',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'visibleButtons' => [
                            'delete' => Yii::$app->user->hasAdminRole(),
                        ],
                        'buttons' => [
                             
                                    'delete' => function ($url, $model, $key) {
        
                                return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-url' => Url::toRoute(['delete-user', 'id' => $model['id']]),
                                            'class' => 'deleteCompanyUser'
                                ]);
                            },
                                   
                                 
                                ],
                                'headerOptions' => [
                                    'width' => '15%',
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