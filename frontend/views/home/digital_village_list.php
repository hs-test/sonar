<?php
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\State;
use common\models\District;
use common\models\Block;
use yii\bootstrap\ActiveForm;

$stateList = State::getStateList();
$districtList = [];
$blockList = [];

if(isset(\Yii::$app->request->queryParams['VleSearch']['state'])){
    $districtList = District::getDistrictList(\Yii::$app->request->queryParams['VleSearch']['state']);
}
if(isset(\Yii::$app->request->queryParams['VleSearch']['district'])){
    $blockList = Block::getBlockList(\Yii::$app->request->queryParams['VleSearch']['district']);
}

$this->title = 'Digital Village List';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template'=>'<li class="breadcrumb-item active">{link}</li>'
];


$this->registerJs('LocationController.initializeChange();');
?>
<div class="clearfix"></div>
<div class="page-header">
    <div class="page-header__breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('/layouts/partials/breadcrumb.php')?>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header__innerbanner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 no-padding">
                    <figure>
                        <img src="static/dist/images/banners/inner/about-digital-village.png" class="img-fluid" alt="Digital Village List">
                    </figure>
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="inner-body">
    <div class="container">
        <div class="row">
            <div class="col-12">  
                <div class="section-head">
                    <h3 class="title">Digital Village List</h3>
                </div>
                <div class="filter__wrapper">
                    
                    <?php
                        $form = ActiveForm::begin([
                            'id' => 'SearchForm',
                            'action' => '/digital-village-list',
                            'method' => 'GET',
                        ]);
                        ?>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?=
                                    $form->field($searchModel, 'state' )
                                ->dropDownList($stateList, [
                                    'class' => 'chzn-select form-control',
                                    'prompt' => 'Select',
                                    'data-parent' => 'state',
                                    'data-child-class' => 'districtSearch',
                                    ])
                                ->label('State')
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?=
                                    $form->field($searchModel, 'district' )
                                ->dropDownList($districtList, [
                                    'class' => 'form-control chzn-select districtCascadeMain districtSearch',
                                    'prompt' => 'Select',
                                    'data-parent' => 'district',
                                    'data-child-class' => 'blockSearch',
                                    ])
                                ->label('District')
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <?=
                                    $form->field($searchModel, 'block' )
                                ->dropDownList($blockList, [
                                    'class' => 'form-control chzn-select blockCascadeMain blockSearch',
                                    'prompt' => 'Select',
                                    ])
                                ->label('Block')
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="filter__wrapper-form">
                                    <button class="button button--radius button--blue" type="submit">Search</button>
                                    
                                </div>
                            </div>
                        </div> 
                    <?php ActiveForm::end(); ?>
                    
                </div>
                <div class="clearfix"><!-- blank tag --></div>
                <div class="divider-lineV2"><!-- blank tag --></div>
                <div class="theme__table">
                    <div class="table-responsive">                           
                        <?php
                        Pjax::begin(['id' => 'vleDataList']);
                        $gridView = GridView::begin([
                            'options' => [
                                'class' => 'table-responsive margin-bottom-50 table__structure-scrollable scrolling'
                            ],
                            'tableOptions' => [
                                'class' => 'table table-striped'
                            ],
                            'summary' => "<div class='summary'>Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> items.</div>",
                            'layout' => "<div class='scrolling'>{items}</div>\n{summary}\n{pager}",
                            'dataProvider' => $dataProvider,
                            //'filterSelector' => ".textSearch, .stateSearch, .districtSearch, .blockSearch, .panchayatSearch", //input[name='VillageSearch[search]'], select[name='VillageSearch[state]'], select[name='VillageSearch[district]]', select[name='VillageSearch[block]'], select[name='VillageSearch[panchayat]']",
                            'pager' => [
                                'prevPageLabel' => 'Previous',
                                'nextPageLabel' => 'Next',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'S.No'
                                ],
                                [
                                    'attribute' => 'state_code',
                                    'label' => 'State',
                                    'sortLinkOptions' => ['class' => 'sort'],
                                    'value' => function ($data) {
                                        return (isset($data->stateCode->name)) ? $data->stateCode->name : NULL;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'district_code',
                                    'label' => 'District',
                                    'sortLinkOptions' => ['class' => 'sort'],
                                    'value' => function ($data) {
                                        return (isset($data->districtCode->name)) ? $data->districtCode->name : NULL;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'block_code',
                                    'label' => 'Block',
                                    'sortLinkOptions' => ['class' => 'sort'],
                                    'value' => function ($data) {
                                        return (isset($data->blockCode->name)) ? $data->blockCode->name : NULL;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'village_code',
                                    'label' => 'Village',
                                    'sortLinkOptions' => ['class' => 'sort'],
                                    'value' => function ($data) {
                                        return (isset($data->villageCode->name)) ? $data->villageCode->name : NULL;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'name',
                                    'header' => 'VLE Name',
                                    'sortLinkOptions' => ['class' => 'sort'],
                                    'filter' => false,
                                ],
//                                [
//                                    'attribute' => 'phone',
//                                    'header' => 'Contact No / Email ID',
//                                    'sortLinkOptions' => ['class' => 'sort'],
//                                    'filter' => false,
//                                    'value'=>function($model){
//                                        return $model->phone.' / '.$model->email;
//                                    }
//                                ],
                            ],
                        ]);

                        $gridView->end();
                        ?>
                        <?php Pjax::end() ?>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>