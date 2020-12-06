<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Vle Manager';

$this->registerJs('VleController.createUpdate();');
$districtList = \common\models\District::getDistrictList();
$stateList = \common\models\State::getStateList();
$this->params['breadcrumbs'][] = ['label' => 'Vle'];
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper">Operator Manager</h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="active">
                            Operator
                        </li>
                    </ul>
                </aside>
                <aside class="section section__right">
                    <ul>
                        <li>
                            <a href="javascript:;" class="button blue" data-toggle="modal" data-target="#newVleModal">
                                <i class="fa fa-plus"></i> New
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle button blue" aria-expanded="false">Action <i class="right-icon fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/user/vle-import">Import</a></li>
                                <li><a href="/admin/user/download-vle-format">Sample CSV</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</div>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <section class="widget__wrapper">                        
                        <!-- Begin data grid filter section -->
                        <div class="widget__wrapper-searchFilter grey-theme">
                            <form class="filterForm" method="get">
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
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <select class="chzn-select stateCascadeMain stateSearch" name="VleSearch[state]" data-search='1' data-parent='state' data-child-class='districtCascadeMain'>
                                                <option value="">Select State</option>
                                                <?php foreach ($stateList as $key => $val): ?>
                                                    <option value="<?= $key ?>"><?= $val ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <select class="chzn-select districtCascadeMain districtSearch" name="VleSearch[district]"  data-search='1' data-parent='district' data-child-class='blockCascadeMain'>
                                                <option value="">Select District</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control textSearch" placeholder="Search" name="VleSearch[search]" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="actoin-set">
                                            <input type="submit" value="Search" class="button blue">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End data grid filter section -->
                        <?php
                        Pjax::begin(['id' => 'classDataList']);
                        $gridView = GridView::begin([
                                    'options' => [
                                        'class' => 'table-responsive margin-bottom-50 table__structure-scrollable'
                                    ],
                                    'tableOptions' => [
                                        'class' => 'table table-striped'
                                    ],
                                    'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                    'layout' => "<div class='scrolling'>{items}</div>\n{summary}\n{pager}",
                                    'dataProvider' => $dataProvider,
                                    //'filterSelector' => ".textSearch, .stateSearch, .districtSearch, .blockSearch, .panchayatSearch", //input[name='VillageSearch[search]'], select[name='VillageSearch[state]'], select[name='VillageSearch[district]]', select[name='VillageSearch[block]'], select[name='VillageSearch[panchayat]']",
                                    'pager' => [
                                        'prevPageLabel' => 'Previous',
                                        'nextPageLabel' => 'Next',
                                    ],
                                    'columns' => [
                                        [
                                            'attribute' => 'state_code',
                                            'label' => 'State',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'value' => function ($data) {
                                                return (isset($data->state->name)) ? $data->state->name : NULL;
                                            },
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'district_id',
                                            'label' => 'District',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'value' => function ($data) {
                                                return (isset($data->district->name)) ? $data->district->name : NULL;
                                            },
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'type',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'omtid',
                                            'label' => 'Csc ID',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'name',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'phone',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'email',
                                            'sortLinkOptions' => ['class' => 'sort'],
                                            'filter' => false,
                                        ],
                                        [
                                            'header' => 'Action',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{update} {change_password} {delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model, $key) {
                                                    return Html::a('<i class="fa fa-pencil"></i>', 'javascript:;', [
                                                                'title' => Yii::t('yii', 'Update'),
                                                                'data-pjax' => '0',
                                                                'data-url' => Url::toRoute(['user/update-vle', 'guid' => $model->guid]),
                                                                'class' => 'icons icons__edit updateClass',
                                                    ]);
                                                },
                                                'change_password' => function ($url, $model, $key) {
                                                    return Html::a('<i class="fa fa-key"></i>', 'javascript:;', [
                                                                'title' => Yii::t('yii', 'Change Password'),
                                                                'data-pjax' => '0',
                                                                'data-url' => Url::toRoute(['user/change-password', 'guid' => $model->user->guid]),
                                                                'class' => 'icons icons__edit updateClass',
                                                    ]);
                                                },
                                                'delete' => function ($url, $model, $key) {
                                                    return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                                'title' => Yii::t('yii', 'Delete'),
                                                                'data-url' => Url::toRoute(['user/delete-vle', 'guid' => $model->guid]),
                                                                'class' => 'icons icons__delete deleteClass',
                                                    ]);
                                                },
                                                    ],
                                                    'headerOptions' => array(
                                                        'width' => '15%',
                                                        'class' => 'scrolling__element head'
                                                    ),
                                                    'contentOptions' => [
                                                        'class' => 'scrolling__element'
                                                    ]
                                                ],
                                            ],
                                ]);

                                $gridView->end();
                                ?>
                                <?php Pjax::end() ?>
                            </section>
                        </div> 
                    </div>
                </div>
            </section>
        </div>

        <!-- New class Modal -->
        <div id="newVleModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newVleModal">
            <?= $this->render('partials/_vle-form.php', ['model' => new \app\modules\admin\models\VleForm, 'stateList' => $stateList, 'districtList' => $districtList, 'url' => Url::toRoute(['user/add-vle'])]) ?>
</div>

<!-- Update class Modal -->
<div id="editVleModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="editVleModal"></div>