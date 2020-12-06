<?php
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';

$this->title = 'Facilitation Centre Registration Data';

$stateList = common\models\State::getStateList();

$this->registerJs('VleController.CreateUpdate.init()');



?>

<!-- Begin data grid section -->
<div class="page-main-content">
    <div class="container">
        <?= $this->render('/layouts/partials/flash-message.php') ?>
        <div class="row">    
                        <div class="col-md-12 col-xs-12">
                            <div class="sectionHead__wrapper">
                                <ul class="upper">
                                    <li class="active"><a href="javascript:;"><?= $this->title ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <section class="widget__wrapper">
                    <!-- Begin data grid filter section -->
                    <div class="widget__wrapper-searchFilter grey-theme">
                        <?php
                        $form = \yii\bootstrap\ActiveForm::begin([
                            'id' => 'SearchForm',
                            'action' => 'vle-facilitation-registration-listing',
                            'method' => 'GET',
                        ]);
                        ?>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'omtid')->textInput([
                                    'placeholder' => 'CSC ID'
                                    ])->label(false) 
                                    ?>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'state_code')->dropDownList(
                                    $stateList,
                                    [
                                    'prompt' => 'Select',
                                    'class' => 'chzn-select'
                                    ])->label(false) 
                                    ?>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'startdate')->textInput([
                                    'placeholder' => 'From Date',
                                    'id' => 'startdate',
                                    'autocomplete'=>'Off'
                                    ])->label(false) 
                                    ?>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'enddate')->textInput([
                                    'placeholder' => 'To Date',
                                    'id' => 'enddate',
                                    'autocomplete'=>'Off'
                                    ])->label(false) 
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="actoin-set">
                                        <?= Html::submitButton('Search', ['class' => 'button blue', 'type' => 'submit']) ?>
                                        <?= Html::a('Export', 'javascript:;', ['class'=>'button blue exportVleFacilitationData ']) ?>
                                        
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
                                'attribute' => 'vle_id',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'value'=>function($model){
                                    return $model->vle->omtid;
                                }
                            ],
                            [
                                'attribute' => 'state_code',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'value'=>function($model){
                                    return $model->stateCode->name;
                                }
                            ],
                            [
                                'attribute' => 'vle_name',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                            ],
                            [
                                'attribute' => 'father_name',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'format'=>'date'
                            ],
                            [
                                'header' => 'Action',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-edit"></i>', Url::toRoute(['vle-facilitation-registration-view', 'guid' => $model->guid]), [
                                            'title' => Yii::t('yii', 'View'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash"></i>', Url::toRoute(['delete-vle-facilitation', 'guid' => $model->guid]), [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-url' => Url::toRoute(['user/delete-vle-facilitation', 'guid' => $model->guid]),
                                            'onclick' => 'return confirm("Do You really want to delete this record?")',
                                            'class' => 'icons icons__delete',
                                        ]);
                                    }
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