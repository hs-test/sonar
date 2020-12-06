<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Sub VLEs';

$this->registerJs('UserController.createUpdate();');

$this->params['breadcrumbs'][] = ['label' => 'Sub VLE'];
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper">Sub Vle</h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="active">
                               Sub Vle
                        </li>
                    </ul>
                </aside>
                <aside class="section section__right">
                    <ul>
                        <li>
                            <div class="search__single-bar">
                                <div class="input-group">
                                    <input type="search" class="form-control" name="UserSearch[search]" placeholder="Search" />
                                    <button type="submit" class="search__single-bar--button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="button blue" data-toggle="modal" data-target="#newUserModal">
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
                                    'filterSelector' => "input[name='UserSearch[search]']",
                                    'pager' => [
                                        'prevPageLabel' => 'Previous',
                                        'nextPageLabel' => 'Next',
                                    ],
                                    'columns' => [
                                        [
                                            'attribute' => 'name',
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'phone',
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'email',
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'username',
                                            'filter' => false,
                                            'value' => function($data) {
                                                return $data->user->username;
                                            }
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
                                                                'data-url' => Url::toRoute(['user/update-sub-vle', 'guid' => $model->user->guid]),
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
                                                                'data-url' => Url::toRoute(['user/delete-sub-vle', 'guid' => $model->guid]),
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
        <div id="newUserModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newUserModal">
            <?= $this->render('partials/_user-form.php', ['model' => $model, 'url' => Url::toRoute(['user/add-sub-vle'])]) ?>
</div>

<!-- Update class Modal -->
<div id="editUserModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="editUserModal"></div>