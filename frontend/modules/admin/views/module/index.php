<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Module Manager';

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';

$this->registerJs('ModuleController.summary();');
?>



<!-- Begin data grid section -->
<div class="page-main-content">
    <div class="container">
        <?= $this->render('/layouts/partials/flash-message.php') ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <section class="widget__wrapper">
                    
                    <!-- Begin data grid filter section -->
                    <div class="widget__wrapper-searchFilter grey-theme">
                        
                        <?php
                        $form = \yii\bootstrap\ActiveForm::begin([
                            'id' => 'SearchForm',
                            'action' => 'index',
                            'method' => 'GET',
                        ]);
                        ?>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($searchModel, 'name')->textInput([
                                    'placeholder' => 'Search'
                                ])->label(false) ?>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?=
                                        $form->field($searchModel, 'is_active', [
                                                'template' => "{label}\n{input}\n{hint}\n{error}",
                                            ])
                                            ->dropDownList([
                                                '' => 'Select Status', 
                                                '1' => 'Active', 
                                                '0' => 'Inactive'
                                                ], ['class' => 'chzn-select']
                                            )->label(false)
                                    ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="actoin-set">
                                        <?= Html::submitButton('Search', ['class' => 'button blue', 'type' => 'submit']) ?>
                                        <?= Html::a('Add Module', 'add', ['class'=>'button green pull-right']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php \yii\bootstrap\ActiveForm::end(); ?>
                    </div>
                    <!-- End data grid filter section -->
                    
                    <?php Pjax::begin(['id' => 'DataList']); ?>
                    <?php
                    $gridView = GridView::begin([
                        'tableOptions' => ['class' => 'table table-striped'],
                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                        'layout' => '<div class="table-responsive margin-bottom-50 table__structure-scrollable '.$noDataClass.'"><div class="scrolling">{items}</div>{summary}{pager}</div>',
                        'dataProvider' => $dataProvider,
                        'filterSelector' => "input[name='StateSearch[search]']",
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
                                'attribute' => 'name',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'value' => function ($model) {
                                    return strtoupper($model->name);
                                },
                            ],
                            [
                                'attribute' => 'is_active',
                                'format' => 'html',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'contentOptions' => function ($model) {
                                    return  ['class' => 'updateModuleStatus', 'data-url' => Url::toRoute(['status', 'guid' => $model->guid])];
                                },
                                'value' => function ($data) {
                                    return (($data->is_active) == 1) ? "<a href='javascript:void(0)' title='Active'><span class='badge badge-success'>".\Yii::t('admin','Active')."</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:void(0)' title='Inactive'><span class='badge badge-danger'>".\Yii::t('admin','Inactive')."</span><i class='fa fa-spin fa-spinner hide'></i></a>";
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
                                                    'class' => 'delete deleteModuleRecord'
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
                    $gridView->end();
                    ?>
                    <?php Pjax::end() ?>

                </section>
                <!-- End data grid section -->
            </div>
        </div>
    </div>
</div>