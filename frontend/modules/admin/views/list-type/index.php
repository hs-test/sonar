<?php
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;
$this->title = 'List Type';
$this->params['breadcrumbs'][] = ['label' => \Yii::t('admin', 'List Type')];
$this->registerJs('ListTypeController.createUpdate();');
?>

<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title]) ?>

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
                                        <div class="section-head__optionSets--addButton">
                                            <a href="<?= Url::toRoute(['list-type/create']) ?>"><i class="fa fa-plus"></i> New</a>
                                        </div>
                                    </div>
                                </div>
                                <?= $this->render('/list-type/partials/_filter-form.php', ['model' => $searchModel]) ?>
                            </div>
                            <?php
                            Pjax::begin(['id' => 'listtypeDataList']);
                            $gridView = GridView::begin([
                                        'tableOptions' => [
                                            'class' => 'table'
                                        ],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive scrolling'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'id' => 'classTable',
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            [
                                                'attribute' => 'category',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'title',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'header' => \Yii::t('admin', 'action'),
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{update} {delete}',
                                                //'visible' => (in_array(TRUE, $actionList)) ? TRUE : FALSE,
                                                'visibleButtons' => [
                                                    'update' => true,
                                                    'delete' => true,
                                                ],
                                                'buttons' => [
                                                    'update' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['update', 'guid' => $model->guid]), [
                                                                    'title' => Yii::t('yii', \Yii::t('admin', 'update')),
                                                                    'class' => 'update',
                                                        ]);
                                                    },
                                                    'delete' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', \Yii::t('admin', 'delete')),
                                                                    'data-url' => Url::toRoute(['delete', 'guid' => $model->guid]),
                                                                    'class' => 'delete deletelist',
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