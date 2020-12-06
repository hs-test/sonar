<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Company';
$this->params['breadcrumbs'][] = ['label' => \Yii::t('admin', 'Company')];
$this->registerJs('CompanyController.createUpdate();');
?>
<?= $this->render('partials/_sub-menu.php', ['company' => TRUE]) ?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => FALSE]) ?>

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
<!--                                        <div class="section-head__optionSets--addButton">
                                        <a href="<?= Url::toRoute(['import']) ?>"><i class="fa fa-plus"></i> Import Company</a>
                                        </div>
                                        <div class="section-head__optionSets--addButton">
                                        <a href="<?= Url::toRoute(['import-company-details']) ?>"><i class="fa fa-plus"></i> Import Company Details</a>
                                        </div>-->
                                    </div>
                                </div>
                                <?= $this->render('/company/partials/_filter-form.php', ['model' => $searchModel]) ?>
                            </div>
                            <?php
                            Pjax::begin(['id' => 'companyDataList']);
                            $gridView = GridView::begin([
                                        'tableOptions' => [
                                            'class' => 'table'
                                        ],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive noFix scrolling'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'id' => 'classTable',
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            [
                                                'attribute' => 'name',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'cin_no',
                                                'header' => 'CIN NO',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'is_active',
                                                'format' => 'html',
                                                'filter' => false,
                                                'label'=>'Status',
                                                'visible' => Yii::$app->user->hasAdminRole(),
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'contentOptions' => function ($model) {
                                            return ['class' => 'updateStatus', 'data-url' => Url::toRoute(['status', 'guid' => $model->guid])];
                                        },
                                                'value' => function ($data) {
                                            return (($data->is_active) == 1) ? "<a href='javascript:void(0)' title='Active'><span class='badge badge-success'>" . \Yii::t('admin', 'Active') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:void(0)' title='Inactive'><span class='badge badge-danger'>" . \Yii::t('admin', 'Inactive') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>";
                                        },
                                            ],
                                            [
                                                'header' => \Yii::t('admin', 'Action'),
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{view}{update}',
                                                'buttons' => [
                                                    'update' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['edit', 'guid' => $model->guid]), [
                                                                    'title' => Yii::t('yii', 'Update'),
                                                                    'data-pjax' => '0',
                                                                    'class' => 'update'
                                                        ]);
                                                    },
                                                            'view' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-eye"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', \Yii::t('admin', 'view')),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['company/view', 'guid' => $model->guid]),
                                                                    'class' => 'view viewcompany',
                                                        ]);
                                                    },
                                                        ],
                                                        'headerOptions' => [
                                                            'class' => 'scrolling__element head'
                                                        ],
                                                        'contentOptions' => [
                                                            'class' => 'scrolling__element'
                                                        ]
                                                    ],
                                                ],
                                    ]);
                                    $gridView->end();
                                    ?>
                                    <?php Pjax::end() ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="viewCompanyModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="viewCompanyModal"></div>