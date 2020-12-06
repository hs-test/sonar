<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SRN Manager';

$fromDate = date('d-m-Y');
$toDate = date('d-m-Y');

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
$this->registerJs('GrievanceController.summary();');
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
$this->registerJs('GrievanceController.createUpdate();');
$this->registerJs('StateController.initializeChozen();');
//$this->registerJs('GrievanceController.initializeChozen();');

$messageSentBtn = "";
if (Yii::$app->user->hasAssignmentOfficerRole() && $dataProvider->getTotalCount() > 0) {
    $messageSentBtn = <<<HTML
<button class="button blue small has-margin-top-20 has-margin-left-30 reassignedGrievance" name="reassignedGrievance" data-url=/admin/grievance/get-dealing-head><i class="fa fa-refresh"></i> Reassigned Grievances</button>
HTML;
}
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
                                         
                                    </div>
                                </div>
                                <?=
                                $this->render('/grievance/partials/_filter-form.php', [
                                    'searchModel' => $searchModel,
                                ]);
                                ?>
                                <!----------search flter form---->
                            </div>
                            <!-- End data grid filter section -->
                            <!-- Begin data grid table section -->
                            <?php Pjax::begin(['id' => 'DataList']) ?>
                            <?php
                            $gridView = GridView::begin([
                                        'tableOptions' => [
                                            'class' => 'table'
                                        ],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive scrolling  $noDataClass'>{items}</div>\n<div class='pull-left fullwidth has-margin-top-10 has-margin-bottom-10'>$messageSentBtn</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'id' => 'grievanceDataTable',
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'rowOptions' => function ($model, $key, $index, $grid) {

                                    return ['guid' => $model->guid, 'dh_id' => $model->dh_id]; //array('key' => $key, 'index' => $index, 'class' => $class);
                                },
                                        'columns' => [
                                            [
                                                'class' => 'yii\grid\CheckboxColumn',
                                                'name' => 'id',
                                                //'checkboxOptions' => ['class' => 'checkboxReassigned', 'label' => '<span></span>', 'labelOptions' => ['class' => 'custom-checkbox']],
                                                'visible' => Yii::$app->user->hasAssignmentOfficerRole(),
                                                'header' => Html::checkBox('id_all', false, [
                                                    'class' => 'select-on-check-all',
                                                    'label' => '<span></span>',
                                                    'labelOptions' => ['class' => 'custom-checkbox']
                                                ]),
                                                'checkboxOptions' => function ($model, $key, $index, $column) {
                                            return ['class' => 'checkboxReassigned', 'label' => '<span></span>', 'labelOptions' => ['class' => 'custom-checkbox'], 'data-guid' => $model->guid, 'data-dh' => $model->dh_id];
                                        }
                                            ],
                                            [
                                                'attribute' => 'posting_date',
                                                'filter' => false,
                                                'header' => 'Date',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'contentOptions' => function ($model) {
                                            return ['guid' => $model->guid, 'dh_id' => $model->dh_id];
                                        },
                                                'value' => function($model) {
                                            return isset($model->posting_date) ? date('d-m-Y', strtotime($model->posting_date)) : '-';
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
                                                'attribute' => 'dh_id',
                                                'filter' => false,
                                                'label' => 'Dealing Head',
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'visible'=>(!\Yii::$app->user->hasCallCenterRole()),
                                                'value' => function($model) {
                                            return !empty($model->dh_id) ? $model->dh->name : '-';
                                        }
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
                                                'template' => '{view}{update-status}{add-comment}{update-rack-details}{update-depository-type}{scan-review}',
                                                'visibleButtons' => [
                                                    'view' => function($model) {
                                                        $showView = TRUE;
                                                        if (Yii::$app->user->hasDealingHeadRole() && Yii::$app->user->id != $model->dh_id) {
                                                            $showView = FALSE;
                                                        }
                                                        return $showView;
                                                    },
                                                    'update-status' => function($model) {
                                                        $show = FALSE;
                                                        if (Yii::$app->user->hasDealingHeadRole() && !empty($model->rack_no)) {
                                                            if (Yii::$app->user->id == $model->dh_id) {
                                                                $show = TRUE;
                                                            }
                                                        }
                                                        else if (Yii::$app->user->hasDispatchExecuitveRole()) {
                                                            $show = TRUE;
                                                        }
                                                        else if (Yii::$app->user->hasAccountManagerRole()) {
                                                            $show = TRUE;
                                                        }
                                                        else if (Yii::$app->user->hasAdminRole()) {
                                                            $show = TRUE;
                                                        }
                                                        return $show;
                                                    },
                                                    'add-comment' => (Yii::$app->user->hasCallCenterRole() || Yii::$app->user->hasCallCenterSupervisor()) ? TRUE : FALSE,
                                                    'update-rack-details' => function($model) {

                                                        return Yii::$app->user->hasDealingHeadRole() && (Yii::$app->user->id == $model->dh_id);
                                                    },
                                                    'update-depository-type' => Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole(),
                                                    'scan-review' => function($model){
                                                        return (Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDealingHeadRole() ) && (empty($model->is_scan) || empty($model->is_review)) && (in_array($model->status, [common\models\Grievance::VR_ASSIGNED,common\models\Grievance::DR_ASSIGNED]));
                                                    },
                                                    
                                                        
                                                ],
                                                'buttons' => [
                                                    'add-comment' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-comments"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Add Comments'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['grievance/add-comment', 'guid' => $model->guid]),
                                                                    'class' => 'update addComment',
                                                        ]);
                                                    },
                                                            'update-rack-details' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-folder-open"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Update Rack No'),
                                                                    'data-url' => Url::toRoute(['grievance/additional-detail', 'guid' => $model->guid]),
                                                                    'data-guid' => $model->guid,
                                                                    'class' => 'updateAdditionalDetail',
                                                        ]);
                                                    },
                                                            'view' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'guid' => $model->guid]), [
                                                                    'title' => Yii::t('yii', 'View'),
                                                                    'class' => 'update',
                                                                    'data-pjax' => 0
                                                        ]);
                                                    },
                                                            'update-depository-type' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil-square-o"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Update Depository'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['grievance/update-depository', 'guid' => $model->guid]),
                                                                    'class' => 'update updateDepository',
                                                        ]);
                                                    },
                                                    'scan-review' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-qrcode"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Scan/Review'),
                                                                    'data-url' => Url::toRoute(['grievance/scan-review', 'guid' => $model->guid]),
                                                                    'class' => 'updateScanReviewDetail',
                                                        ]);
                                                    },
                                                            'update-status' => function ($url, $model, $key) {

                                                        $grievance_log_id = null;
                                                        $is_message_sent = 0;
                                                        $grievanceActivityModel = \common\models\GrievanceActivityLog::findByGrievanceId($model->id, ['selectCols' => ['grievance_activity_log.id', 'grievance_activity_log.is_msg_sent'], 'applicationStatus' => $model->status, 'limit' => 1, 'orderBy' => ['grievance_activity_log.id' => SORT_DESC]]);
                                                        if (!empty($grievanceActivityModel)) {
                                                            $grievance_log_id = $grievanceActivityModel['id'];
                                                            $is_message_sent = $grievanceActivityModel['is_msg_sent'];
                                                        }
                                                        return Html::a('<i class="fa fa-pencil"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Update'),
                                                                    'data-url' => Url::toRoute(['grievance/update-status', 'guid' => $model->guid]),
                                                                    'data-guid' => $model->guid,
                                                                    'data-status' => $model->status,
                                                                    'data-logid' => $grievance_log_id,
                                                                    'data-msgsent' => $is_message_sent,
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
                                    <?php Pjax::end() ?>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="newCommentModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newCommentModal">

</div>
<div id="updateStatusModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="updateStatusModal">

</div>
<div id="updateAdditionalDetailModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="updateAdditionalDetailModal">

</div>
<div id="reassignedGrievanceStatusModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="reassignedGrievanceStatusModal">

</div>
<div id="messageTemplateModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="messageTemplateModal">

</div>
<div id="updateDepositoryModel" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="updateDepositoryModel">

</div>
<div id="showReAssignedSuccessFailLogs" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="showReAssignedSuccessFailLogs">

</div>
<div id="newScanReviewModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="newScanReviewModal">

</div>

