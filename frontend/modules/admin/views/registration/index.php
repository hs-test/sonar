<?php
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Inflector;

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';

$this->title = 'Registration Listing';

$states = common\models\State::getStateList();

$this->registerJs('RegistrationController.createUpdate()');

?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper"><?= $indexConfig['title'] ?></h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="active">
                            <?= $indexConfig['title'] ?>
                        </li>
                    </ul>
                </aside>
                <aside class="section section__right">
                    <ul>
                        <li class="dropdown">
                            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle button blue" aria-expanded="false">Action <i class="right-icon fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="import?type=<?= $indexConfig['type'] ?>">Import Data</a></li>
                                <li><a href="javascript:;" class="exportData">Export Data</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="form?type=<?= $indexConfig['type'] ?>" class="button blue" >
                                <i class="fa fa-plus"></i> New
                            </a>
                        </li>
                        
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</div>
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
                            'action' => 'index?type='.$_GET['type'],
                            'method' => 'GET',
                        ]);
                        ?>
                        <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="sectionHead__wrapper">
                                            <ul class="upper">
                                                <li class="active"><a href="javascript:;">Filter Results</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'full_name')->textInput([
                                    'placeholder' => 'Full Name'
                                    ])->label(false) 
                                    ?>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <?= $form->field($searchModel, 'state_code')->dropDownList(
                                            $states,
                                            [
                                    'class' => 'chzn-select',
                                    'prompt' => 'Select'
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
                                        <?= ''// Html::a('Export', 'javascript:;', ['class'=>'button blue exportVleFacilitationData ']) ?>
                                        
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
                                'attribute' => 'full_name',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                            ],
                            [
                                'attribute' => 'state_code',
                                'label' => 'State',
                                'filter' => false,
                                'value' => function($model){
                                    return $model->stateCode->name;
                                },
                                'sortLinkOptions' => ['class' => 'sort'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Reg. Date',
                                'filter' => false,
                                'sortLinkOptions' => ['class' => 'sort'],
                                'format'=>'date'
                            ],
                            [
                                'header' => 'Action',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        
                                        return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['form','survey_guid'=>$model->survey->guid,'service_guid'=>$model->service->guid, 'guid' => $model->guid]), [
                                            'title' => Yii::t('yii', 'View'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                    'title' => Yii::t('yii', 'Delete'),
                                                    'data-url' => Url::toRoute(['delete', 'guid' => $model->guid]),
                                                    'class' => 'delete deleteClass'
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