<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Grievance Type';

$this->registerJs('TypeController.createUpdate();');
$this->registerJs('TypeController.updateStatus();');
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title]) ?>
<div class="page-main-content">
    <div class="container">
        <?= $this->render('/layouts/partials/flash-message.php') ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <section class="widget__wrapper">
                    <div class="table__structure table__structure-scrollable">
                        <div class="table__structure__head">
                                <div class="section-head">
                                    <div class="section-head--title"></div>
                                    <div class="section-head__optionSets">
                                        <div class="section-head__optionSets--filter"></div>
                                        <div class="section-head__optionSets--addButton">
                                            <a href="<?=Url::toRoute(['type/create']);?>"><i class="fa fa-plus"></i> New</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php Pjax::begin(['id' => 'DataList']) ?>
                    <?php
                    $gridView = GridView::begin([
                                'tableOptions' => ['class' => 'table'],
                                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                'layout' => "<div class='table-responsive scrolling $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                'dataProvider' => $dataProvider,
                                'emptyTextOptions' => ['class' => 'empty text-center'],
                                'pager' => [
                                    'prevPageLabel' => 'Previous',
                                    'nextPageLabel' => 'Next',
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'id',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort'],
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort'],
                                        'value' => function ($model) {
                                    return strtoupper($model->title);
                                },
                                    ],
                                         [
                                                'attribute' => 'status',
                                                'format' => 'html',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'contentOptions' => function ($model) {
                                                    return ['class' => 'updateStatus', 'data-url' => Url::toRoute(['status', 'guid' => $model->guid])];
                                                },
                                                'value' => function ($data) {
                                                    return (($data->status) == 1) ? "<a href='javascript:void(0)' title='Active'><span class='badge badge-success'>" . \Yii::t('admin', 'Active') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:void(0)' title='Inactive'><span class='badge badge-danger'>" . \Yii::t('admin', 'Inactive') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>";
                                                },
                                            ],
                                    [
                                        'header' => 'Action',
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['edit', 'guid' => $model->guid]), [
                                                            'title' => Yii::t('yii', 'Update'),
                                                            'data-pjax' => '0',
                                                            'class' => 'update'
                                                ]);
                                            },
                                                    'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                            'title' => Yii::t('yii', 'Delete'),
                                                            'data-url' => Url::toRoute(['delete', 'guid' => $model->guid]),
                                                            'class' => 'delete deleteType'
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
                            <?php Pjax::end() ?>
  </div>
                </section>
                <!-- End data grid section -->
            </div>
          
        </div>
    </div>
</div>