<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Holiday List';

$this->registerJs('CalendarController.show();');

$noDataClass = ($dataProvider->getTotalCount() <= 0) ? ' no-data' : '';
Pjax::begin(['id' => 'usersDataList']);
$gridView = GridView::begin([
            'options' => [
                'class' => 'margin-bottom-50 table__structure-scrollable'
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
            'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
            'layout' => "<div class='scrolling table-responsive $noDataClass'>{items}</div>\n{summary}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterSelector' => "input[name='UserSearch[search]']",
            'emptyTextOptions' => ['class' => 'empty text-center'],
            'pager' => [
                'prevPageLabel' => 'Previous',
                'nextPageLabel' => 'Next',
            ],
            'columns' => [
                [
                    'attribute' => 'title',
                    'header' => 'Title',
                    'format' => 'html',
                    'filter' => false,
                    'sortLinkOptions' => ['class' => 'sort'],
                ],
                [
                    'attribute' => 'date',
                    'format' => 'html',
                    'filter' => false,
                    'sortLinkOptions' => ['class' => 'sort'],
                ],
                [
                    'header' => \Yii::t('admin', 'action'),
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [

                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-trash"></i>', 'javascript:;', [
                                        'title' => Yii::t('yii', \Yii::t('admin', 'delete')),
                                        'data-url' => Url::toRoute(['holiday/delete', 'unqid' => $model->unqid]),
                                        'class' => 'icons icons__delete deleteHoliday',
                                        'pjax-container' => 'pjax-list',
                            ]);
                        },
                            ],
                            'headerOptions' => [
                                'width' => '15%',
                                'class' => 'scrolling__element head'
                            ],
                            'contentOptions' => [
                                'class' => 'scrolling__element'
                            ]
                        ],
                    ],
        ]);

        $gridView->end();

        Pjax::end();
        echo '<div id="hide-main-calender">';
        echo $calendar->show();
        echo '</div>';
        ?>
        <div id="show-calender"></div>
        <style>
            div#calendar{
                margin:0px auto;
                padding:0px;
                width: 602px;
                font-family:Helvetica, "Times New Roman", Times, serif;
            }

            div#calendar div.box{
                position:relative;
                top:0px;
                left:0px;
                width:100%;
                height:40px;
                background-color:   #787878 ;      
            }

            div#calendar div.header{
                line-height:40px;  
                vertical-align:middle;
                position:absolute;
                left:11px;
                top:0px;
                width:582px;
                height:40px;   
                text-align:center;
            }

            div#calendar div.header a.prev,div#calendar div.header a.next{ 
                position:absolute;
                top:0px;   
                height: 17px;
                display:block;
                cursor:pointer;
                text-decoration:none;
                color:#FFF;
            }

            div#calendar div.header span.title{
                color:#FFF;
                font-size:18px;
            }


            div#calendar div.header a.prev{
                left:0px;
            }

            div#calendar div.header a.next{
                right:0px;
            }




            /*******************************Calendar Content Cells*********************************/
            div#calendar div.box-content{
                border:1px solid #787878 ;
                border-top:none;
            }



            div#calendar ul.label{
                float:left;
                margin: 0px;
                padding: 0px;
                margin-top:5px;
                margin-left: 5px;
            }

            div#calendar ul.label li{
                margin:0px;
                padding:0px;
                margin-right:5px;  
                float:left;
                list-style-type:none;
                width:80px;
                height:40px;
                line-height:40px;
                vertical-align:middle;
                text-align:center;
                color:#000;
                font-size: 15px;
                background-color: transparent;
            }


            div#calendar ul.dates{
                float:left;
                margin: 0px;
                padding: 0px;
                margin-left: 5px;
                margin-bottom: 5px;
            }

            /** overall width = width+padding-right**/
            div#calendar ul.dates li{
                margin:0px;
                padding:0px;
                margin-right:5px;
                margin-top: 5px;
                line-height:80px;
                vertical-align:middle;
                float:left;
                list-style-type:none;
                width:80px;
                height:80px;
                font-size:25px;
                background-color: #DDD;
                color:#000;
                text-align:center; 
            }

            :focus{
                outline:none;
            }

            div.clear{
                clear:both;
            }  
            div#calendar ul.dates li.sunday {
                background-color: red;
            }
            div#calendar ul.dates li.general {
                background-color: greenyellow;
            }
        </style>
        <div id="holidayModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="holidayModal">
            <?= $this->render('partials/_form.php', ['model' => $model]) ?>
</div>