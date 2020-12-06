<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'User Manager';

$this->registerJs('UserController.updateStatus();');
$this->registerJs('UserController.deleteUser();');
$this->registerJs('UserController.changepassword();');
$this->registerJs('UserController.allowedgrievance();');
$this->registerJs('UserController.viewTargetLogs();');
$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';

$roles = [\common\models\User::ROLE_ADMIN => 'ADMIN'] + \common\models\User::roleArray();
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => FALSE]) ?>

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
                                        <?php if (Yii::$app->user->hasAdminRole()): ?>
                                            <div class="section-head__optionSets--addButton">
                                                <a href="<?= Url::toRoute(['user/create']) ?>"><i class="fa fa-plus"></i> New</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Search layout -->
                                <?=$this->render('partials/_search-form.php', ['model' => $searchModel]) ?>
                            </div>
                            <!-- Begin data grid table section -->
                            <?php Pjax::begin(['id' => 'userDataList']) ?>
                            <?php
                            $gridView = GridView::begin([
                                        'tableOptions' => [
                                            'class' => 'table'
                                        ],
                                        'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                                        'layout' => "<div class='table-responsive scrolling  $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                                        'dataProvider' => $dataProvider,
                                        'emptyTextOptions' => ['class' => 'empty text-center'],
                                        'id' => 'userDataTable',
                                        'pager' => [
                                            'prevPageLabel' => 'Previous',
                                            'nextPageLabel' => 'Next',
                                        ],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'attribute' => 'username',
                                                'visible' => Yii::$app->user->hasAdminRole(),
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'mobile',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'email',
                                                'filter' => false,
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'role_id',
                                                'label' => 'Role',
                                                'filter' => false,
                                                'visible' => Yii::$app->user->hasAdminRole(),
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'value' => function ($model) use ($roles) {
                                            return $roles[$model->role_id];
                                        }
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'format' => 'html',
                                                'filter' => false,
                                                'visible' => Yii::$app->user->hasAdminRole(),
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'contentOptions' => function ($model) {
                                            return ['class' => 'updateStatus', 'data-url' => Url::toRoute(['status', 'guid' => $model->guid])];
                                        },
                                                'value' => function ($data) {
                                            return (($data->status) == 10) ? "<a href='javascript:void(0)' title='Active'><span class='badge badge-success'>" . \Yii::t('admin', 'Active') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>" : "<a href='javascript:void(0)' title='Inactive'><span class='badge badge-danger'>" . \Yii::t('admin', 'Inactive') . "</span><i class='fa fa-spin fa-spinner hide'></i></a>";
                                        },
                                            ],
                                            [
                                                'attribute' => 'allocated_grievance',
                                                'label' => 'Allocated SRN',
                                                'filter' => false,
                                                'visible' => Yii::$app->user->hasAssignmentOfficerRole(),
                                                'sortLinkOptions' => ['class' => 'sort'],
                                            ],
                                            [
                                                'attribute' => 'allowed_grievance',
                                                'label' => 'Targeted SRN',
                                                'filter' => false,
                                                'visible' => Yii::$app->user->hasAssignmentOfficerRole(),
                                                'sortLinkOptions' => ['class' => 'sort'],
                                                'value' => function($model) {
                                            return !empty($model->allowed_grievance) ? $model->allowed_grievance : 0;
                                        }
                                            ],
                                            [
                                                'header' => 'Action',
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{update} {delete} {change_password}{allowed_grievance}{view-logs}',
                                                'visibleButtons' => [
                                                    'update' => Yii::$app->user->hasAdminRole(),
                                                    'delete' => Yii::$app->user->hasAdminRole(),
                                                    'change_password' => Yii::$app->user->hasAdminRole(),
                                                    'allowed_grievance' => Yii::$app->user->hasAssignmentOfficerRole(),
                                                ],
                                                'buttons' => [
                                                    'update' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['edit', 'guid' => $model->guid]), [
                                                                    'title' => Yii::t('yii', 'Update'),
                                                                    'data-pjax' => '0',
                                                                    'class' => 'update'
                                                        ]);
                                                    },
                                                            'delete' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                                                    'title' => Yii::t('yii', 'Delete'),
                                                                    'data-url' => Url::toRoute(['delete', 'guid' => $model->guid]),
                                                                    'class' => 'deleteUser'
                                                        ]);
                                                    },
                                                            'change_password' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-key"></i>', 'javascript:void(0)', [
                                                                    'title' => Yii::t('yii', 'Change Password'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['user/change-password', 'guid' => $model->guid]),
                                                                    'class' => 'icons icons__edit changePassword',
                                                        ]);
                                                    },
                                                            'allowed_grievance' => function ($url, $model, $key) {
                                                        return Html::a('<i class="fa fa-pencil"></i>', 'javascript:void(0)', [
                                                                    'title' => Yii::t('yii', 'Update Allowed grievance'),
                                                                    'data-pjax' => '0',
                                                                    'data-url' => Url::toRoute(['user/update-allowed-grievance', 'guid' => $model->guid]),
                                                                    'class' => 'icons icons__edit updateAllowedGrievance',
                                                        ]);
                                                    },
                                                        'view-logs'=>function($url,$model,$key){
                                                        return Html::a('<i class="fa fa-eye"></i>', 'javascript:;', [
                                                        'title' => Yii::t('yii', \Yii::t('admin', 'view')),
                                                        'data-pjax' => '0',
                                                        'data-url' => Url::toRoute(['user/view-target-logs', 'id' => $model->id]),
                                                        'class' => 'view viewTargetLogs',
                                            ]);
                                       
                                                            }
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
<div id="changePasswordModel"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="changePasswordModel"></div>
<div id="updateAllowedGrievanceModel"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="updateAllowedGrievanceModel"></div>
<div id="viewTargetLogsModel"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="viewTargetLogsModel"></div>
