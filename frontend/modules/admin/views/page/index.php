<?php
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = "Content Manager";
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data': '';
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
                                        <div class="section-head__optionSets--filter">Search<i
                                                    class="icon fa fa-angle-down"></i></div>
                                        <div class="section-head__optionSets--addButton">
                                            <a href="<?= Url::toRoute(['page/create']) ?>"><i class="fa fa-plus"></i> New</a>
                                        </div>
                                    </div>
                                </div>
<!-- Search layout -->
                            </div>

                            <?php
                            Pjax::begin(['id' => 'pageDataList']);
                            $gridView = GridView::begin([
                                'tableOptions' => [
                                    'class' => 'table'
                                ],
                                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                'layout' => "<div class='table-responsive scrolling $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                'dataProvider' => $dataProvider,
                                'filterSelector' => "input[name='PageSearch[search]']",
                                'emptyTextOptions' => ['class' => 'empty text-center'],
                                'id' => 'cmsTable',
                                'pager' => [
                                    'prevPageLabel' => 'Previous',
                                    'nextPageLabel' => 'Next',
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'title',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort'],

                                    ],
                                    [
                                        'attribute' => 'external_url',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort'],

                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'html',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort'],
                                        'value' => function ($data) {
                                            return (($data->status) == 1) ? "<a href='javascript:;' title='Active'><span class='badge badge-success'>Active</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:;' title='Inactive'><span class='badge badge-danger'>Inactive</span><i class='fa fa-spin fa-spinner hide'></i></a>";
                                        },

                                    ],
                                    [
                                        'header' => 'Action',
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['page/update', 'guid' => $model->guid]), [
                                                    'title' => 'Update',
                                                    'class' => 'update',
                                                ]);
                                            },
                                            'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                    'title' => 'Delete',
                                                    'data-url' => Url::toRoute(['page/delete', 'guid' => $model->guid]),
                                                    'class' => 'delete deletePageManager',
                                                ]);
                                            }
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
