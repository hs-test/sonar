<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Block Manager';

$this->registerJs('BlockController.createUpdate();');
$stateList = \common\models\State::getStateList();

$this->params['breadcrumbs'][] = ['label' => 'Block'];
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper">Block Manager</h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="active">
                            Block
                        </li>
                    </ul>
                </aside>
                <aside class="section section__right">
                    <ul>
                        <li>
                            <a href="javascript:;" class="button blue" data-toggle="modal" data-target="#newBlockModal">
                                <i class="fa fa-plus"></i> New
                            </a>
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
                                            <select class="chzn-select stateCascadeMain stateSearch" name="BlockSearch[state]" data-search='1' data-parent='state' data-child-class='districtCascadeMain'>
                                                <option value="">Select State</option>
                                                <?php foreach ($stateList as $key => $val): ?>
                                                    <option value="<?= $key ?>"><?= $val ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <select class="chzn-select districtCascadeMain districtSearch" name="BlockSearch[district]"  data-search='1' data-parent='district' data-child-class='blockCascadeMain'>
                                                <option value="">Select District</option>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control textSearch" placeholder="Search" name="BlockSearch[search]" type="text">
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
                                        'class' => 'table-responsive margin-bottom-50 table__structure-scrollable scrolling'
                                    ],
                                    'tableOptions' => [
                                        'class' => 'table table-striped'
                                    ],
                                    'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                    'layout' => "{items}\n{summary}\n<div class='pull-right'>{pager}</div>",
                                    'dataProvider' => $dataProvider,
                                    //'filterSelector' => ".textSearch, .stateSearch, .districtSearch",
                                    'pager' => [
                                        'prevPageLabel' => 'Previous',
                                        'nextPageLabel' => 'Next',
                                    ],
                                    'columns' => [
                                        [
                                            'attribute' => 'state_code',
                                            'label' => 'State',
                                            'value' => function ($data) {
                                                return $data->stateCode->name;
                                            },
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'district_code',
                                            'label' => 'District',
                                            'value' => function ($data) {
                                                return $data->districtCode->name;
                                            },
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'name',
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
                                                                'data-url' => Url::toRoute(['location/update-block', 'guid' => $model->guid]),
                                                                'class' => 'updateClass',
                                                    ]);
                                                },
                                                        'delete' => function ($url, $model, $key) {
                                                    return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                                'title' => Yii::t('yii', 'Delete'),
                                                                'data-url' => Url::toRoute(['location/delete-block', 'guid' => $model->guid]),
                                                                'class' => 'deleteClass',
                                                    ]);
                                                },
                                                    ],
                                                    'headerOptions' => array(
                                                        'width' => '15%',
                                                    ),
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
        <div id="newBlockModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newBlockModal">
            <?= $this->render('partials/_block-form.php', ['model' => $model, 'stateList' => $stateList, 'url' => Url::toRoute(['location/add-block'])]) ?>
</div>

<!-- Update class Modal -->
<div id="editBlockModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="editBlockModal"></div>