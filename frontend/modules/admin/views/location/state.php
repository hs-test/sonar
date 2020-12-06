<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'State Manager';


$this->params['submenu'][] = [
    'title' => 'State Manager',
    'route' => Url::toRoute(['location/state']),
    'active' => true,
    'visible' => true
];

$this->params['submenu'][] = [
    'title' => 'District Manager',
    'route' => Url::toRoute(['location/district']),
    'active' => false,
    'visible' => true
];
$this->params['submenu'][] = [
    'title' => 'Village Manager',
    'route' => Url::toRoute(['location/village']),
    'active' => false,
    'visible' => true
];
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
$this->registerJs('StateController.createUpdate();');
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>

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
                                            <a href="javascript:;" data-toggle="modal" data-target="#newStateModal"><i class="fa fa-plus"></i> New</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Search layout -->
                                
                                <?= $this->render('partials/search/_state.php', ['model' => $searchModel]) ?>
                            </div>
                            <!-- Begin data grid table section -->
                            <?php
                            Pjax::begin(['id' => 'classDataList']);
                            $gridView = GridView::begin([
                                        'tableOptions' => ['class' => 'table'],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive scrolling  $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'attribute' => 'code',
                                                'filter' => false
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'filter' => false,
                                            ],
                                            [
                                                'attribute' => 'search_name',
                                                'label' => 'Sort Name',
                                                'filter' => false,
                                            ],
                                            [
                                                'label' => 'CPM Head',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    $userModel = \common\models\UserLocation::findByStateCode($data->code, [
                                                                'selectCols' => ['user.name', 'user.guid'],
                                                                'joinUser' => 'innerJoin',
                                                                'roleId' => \common\models\User::ROLE_CPM
                                                    ]);
                                                    if (!empty($userModel)) {
                                                        return '<a class="link-blue" target="_blank" href="/admin/user/edit?guid='.$userModel['guid'].'">'.$userModel['name'].'</a>&nbsp;';
                                                    }
                                                    return '-';
                                                },
                                                'filter' => false,
                                            ],
                                            [
                                                'label' => 'Nodal Officer',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    $userModel = \common\models\UserLocation::findByStateCode($data->code, [
                                                                'selectCols' => ['user.name', 'user.guid'],
                                                                'joinUser' => 'innerJoin',
                                                                'roleId' => \common\models\User::ROLE_RAC_NODAL_OFFICER
                                                    ]);
                                                    if (!empty($userModel)) {
                                                        return '<a class="link-blue" target="_blank" href="/admin/user/edit?guid='.$userModel['guid'].'">'.$userModel['name'].'</a>&nbsp;';
                                                    }
                                                    return '-';
                                                },
                                                'filter' => false,
                                            ],
                                                        [
                                                'label' => 'State User',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    $userModel = \common\models\UserLocation::findByStateCode($data->code, [
                                                                'selectCols' => ['user.name', 'user.guid'],
                                                                'joinUser' => 'innerJoin',
                                                                'roleId' => \common\models\User::ROLE_STATE_USER
                                                    ]);
                                                    if (!empty($userModel)) {
                                                        return '<a class="link-blue" target="_blank" href="/admin/user/edit?guid='.$userModel['guid'].'">'.$userModel['name'].'</a>&nbsp;';
                                                    }
                                                    return '-';
                                                },
                                                'filter' => false,
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'format' => 'html',
                                                'value' => function ($data) {
                                                    return (($data->status) == 1) ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-danger'>Inactive</span>";
                                                },
                                                'filter' => false,
                                            ],
                                            [
                                                'header' => 'Action',
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{update} {delete}',
                                                'buttons' => [
                                                    'update' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Update'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['location/update-state', 'guid' => $model->guid]),
                                                                    'class' => 'update updateClass',
                                                        ]);
                                                    },
                                                    'delete' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Delete'),
                                                                    'data-url' => Url::toRoute(['location/delete-state', 'guid' => $model->guid]),
                                                                    'class' => 'delete deleteClass',
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





<!-- New class Modal -->
<div id="newStateModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newStateModal">
    <?= $this->render('partials/_state-form.php', ['model' => $model, 'url' => Url::toRoute(['location/add-state'])]) ?>
</div>

<!-- Update class Modal -->
<div id="editStateModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="editStateModal"></div>