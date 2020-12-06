<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
$this->registerJs('GrievanceController.summary();');
$this->registerJs('GrievanceController.createUpdate();');
$fromDate = date('d-m-Y');
$toDate = date('d-m-Y');
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
?>

<?php Pjax::begin(['id' => 'DataList']) ?>
<div class="table__structure table__structure-scrollable">

    <?php
    $gridView = GridView::begin([
                'tableOptions' => [
                    'class' => 'table'
                ],
                'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                'layout' => "<div class='table-responsive scrolling  $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                'dataProvider' => $dataProvider,
                //'filterSelector' => "input[name='StaffSearch[search]'], select[name='StaffSearch[departments][]']",
                'emptyTextOptions' => ['class' => 'empty text-center'],
                'id' => 'staffDataTable',
                'pager' => [
                    'prevPageLabel' => 'Previous',
                    'nextPageLabel' => 'Next',
                ],
                'columns' => [
                    [
                        'attribute' => 'posting_date',
                        'filter' => false,
                        'header' => 'Date',
                        'sortLinkOptions' => ['class' => 'sort'],
                        'value' => function($model) {
                    return isset($model->posting_date) ? date('Y-m-d', strtotime($model->posting_date)) : '-';
                }
                    ],
                    [
                        'attribute' => 'company_id',
                        'filter' => false,
                        'header' => 'Company',
                        'sortLinkOptions' => ['class' => 'sort'],
                        'value' => function($model) {
                    return $model->company->cin_no . '/' . $model->company->name;
                }
                    ],
                    [

                        'attribute' => 'srn_no',
                        'header' => 'SRN No',
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'applicant_name',
                        'filter' => false,
                        'sortLinkOptions' => ['class' => 'sort'],
                    ],
                    [
                        'attribute' => 'status',
                        'header' => 'STATUS',
                        'format' => 'html',
                        'value' => function ($data) {
                            $statusArr = common\models\Grievance::getGrievanceStatusArr(NULL, TRUE);
                            $status = isset($data->status) ? $statusArr[$data->status] : '-';

                            return "<div class='check-status'><span class='badge badge-success'>$status</span></div>";
                        },
                        'headerOptions' => array(
                            'width' => '10%'
                        ),
                        'contentOptions' => array(
                            'align' => 'center'
                        ),
                        'filter' => array('1' => 'Active', '0' => 'Inactive'),
                    ],
                    [
                        'header' => 'Action',
                        'class' => 'yii\grid\ActionColumn',
                        //'visible' => Yii::$app->user->hasAdminRole(),
                        'template' => '{view}{update-status}{add-comment}',
                        'visibleButtons' => [
                            'view' => TRUE,
                            'update-status' => (Yii::$app->user->hasCallCenterRole() || Yii::$app->user->hasCallCenterSupervisor()) ? FALSE : TRUE,
                            'add-comment' => (Yii::$app->user->hasCallCenterRole() || Yii::$app->user->hasCallCenterSupervisor()) ? TRUE : FALSE
                        ],
                        'buttons' => [
                           'add-comment' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-comments"></i>','javascript:;', [
                                                                    'title' => Yii::t('yii', 'Add Comments'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['grievance/add-comment', 'guid' => $model->guid]),
                                                                    'class' => 'update addComment',
                                                                    
                                                        ]);
                                                    },
                                    'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'guid' => $model->guid]), [
                                            'title' => Yii::t('yii', 'View'),
                                            'class' => 'update',
                                            'data-pjax' => 0
                                ]);
                            },
                                    'update-status' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-pencil"></i>', 'javascript:;', [
                                            'title' => Yii::t('yii', 'Update'),
                                            'data-url' => Url::toRoute(['grievance/update-status', 'guid' => $model->guid]),
                                            'data-guid' => $model->guid,
                                            'class' => 'updateGrievanceStatus',
                                ]);
                            },
                                ],
                                'headerOptions' => [
                                    'class' => 'scrolling__element head'
                                ],
                                'contentOptions' => [
                                    'class' => 'scrolling__element'
                                ]
                            ]
                        ]
            ]);
            $gridView->end()
            ?>
        </div>
        <?php Pjax::end() ?>

<div id="newCommentModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newCommentModal">

</div>