<?php
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = "Discom Manager";
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data': '';

$this->registerJs("DiscomController.createUpdate();");
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
                                    <div class="section-head--title"><?= $this->title  ?></div>
                                    <div class="section-head__optionSets">
                                        <div class="section-head__optionSets--filter"></div>
                                        <div class="section-head__optionSets--addButton">
                                          <a href="javascript:;" data-toggle="modal" data-target="#newDiscomModal"><i class="fa fa-plus"></i> New</a>
                                        </div>
                                    </div>
                                </div>
                            <!-- Search layout -->
                            </div>

                            <?php
                            Pjax::begin(['id' => 'discomDataList']);
                            $gridView = GridView::begin([
                                'tableOptions' => [
                                    'class' => 'table'
                                ],
                                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                'layout' => "<div class='table-responsive scrolling $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                'dataProvider' => $dataProvider,
                                'filterSelector' => "input[name='DiscomSearch[search]']",
                                'emptyTextOptions' => ['class' => 'empty text-center'],
                                'id' => 'cmsTable',
                                'pager' => [
                                    'prevPageLabel' => 'Previous',
                                    'nextPageLabel' => 'Next',
                                ],
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'discom_code',
                                        'filter' => false,
                                        'sortLinkOptions' => ['class' => 'sort']
                                    ],
                                    [
                                      'header'=>'State',
                                      'value'=>function($model){
                                            $userState = common\models\User::findByRoleId(common\models\User::ROLE_DISCOM_MD, [
                                                'selectCols'=>['state.name'],
                                                'discomId' => $model->id,
                                                'joinUserLocation'=>'innerJoin',
                                                'joinWithState'=>'innerJoin'
                                                
                                            ]);
                                            return  (isset($userState) && !empty($userState['name'])) ? $userState['name'] : '-';
                                      }
                                    ],
                                     [
                                        'label' => 'Discom MD',
                                        'filter' => false,
                                        'format' => 'raw',
                                        'sortLinkOptions' => ['class' => 'sort'],
                                        'value' => function($model) {
                                
                                            $users = common\models\User::findByRoleId(common\models\User::ROLE_DISCOM_MD, [
                                                'discomId' => $model->id,
                                                 
                                            ]);
                                            $html = '';
                                            if(!empty($users)) {
                                                    $html .= '<a class="link-blue target="_blank" href="/admin/user/edit?guid='.$users['guid'].'">'.$users['name'].'</a>&nbsp;';
                                            }
                                
                                            return $html;
                                        }
                                    ],
                                    [
                                        'header' => 'Action',
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['discom/update', 'guid' => $model->guid]), [
                                                    'title' => 'Update',
                                                    'class' => 'update updateDiscom',
                                                ]);
                                            },
                                            'delete' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-trash"></i>',  Url::toRoute(['discom/delete', 'guid' => $model->guid]), [
                                                    'title' => 'Delete',
                                                    'class' => 'delete deleteDiscom',
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
<!-- New class Modal -->
<div id="newDiscomModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newStateModal">
    <?= $this->render('partials/_form.php', ['model' => $model, 'url' => Url::toRoute(['discom/create'])]) ?>
</div>

<!-- Update class Modal -->
<div id="editDiscomModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="editDiscomModal"></div>
