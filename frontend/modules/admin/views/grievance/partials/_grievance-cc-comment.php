<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$noDataClass = ($comments->getTotalCount() <= 0) ? ' no-data' : '';
?>
<section class="widget__wrapper">
    <div class="section_head withLink section_head__accordian">
        <h2><a href="javascript:;">CC Comments<i><!--plus icon--></i></a></h2>
    </div>
    <?php Pjax::begin(['id' => 'DataList']) ?>
    <div class="table__structure table__structure-scrollable">

        <?php
        $gridView = GridView::begin([
                    'tableOptions' => [
                        'class' => 'table'
                    ],
                    'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                    'layout' => "<div class='table-responsive scrolling  noFix $noDataClass'>{items}</div>\n<div class='table__bottom-section'>{summary}\n<div class='table__bottom-section--pagination'>{pager}</div></div>",
                    'dataProvider' => $comments,
                    'emptyTextOptions' => ['class' => 'empty text-center'],
                    'id' => 'commentTable',
                    'pager' => [
                        'prevPageLabel' => 'Previous',
                        'nextPageLabel' => 'Next',
                    ],
                    'columns' => [
                        [
                            'attribute' => 'date',
                            'value' => function($model) {
                                return $model['created_on'] ? date('d-m-Y', $model['created_on']) : '-';
                            }
                        ],
                        [
                            'header' => 'Commented By /Role',
                            'value' => function($model) {

                                return $model['name'] . '/' . $model['roleName'];
                            }
                        ],
                        [
                            'attribute' => 'comment',
                            'format'=>'html',
                            'value' => function($model) {
                                 $text = '';
                                if (isset($model['comment']) && !empty($model['comment'])) {
                                    $decodeJson = json_decode($model['comment'], TRUE);
                                    foreach ($decodeJson['comments'] as $key => $value) {
                                        $text .=  $key + 1 . ". {$value} <br>";
                                    }
                                }
                                return $text;
                            }
                        ],
                    ]
        ]);
        $gridView->end()
        ?>
    </div>
    <?php Pjax::end() ?>
</section>




