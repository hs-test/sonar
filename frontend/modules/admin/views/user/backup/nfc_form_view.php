<?php
use yii\widgets\DetailView;

$this->title = 'Facilitation Centre Registration View';

?>
<!-- Begin Form section -->
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <section class="widget__wrapper">
                    <form class="widget__wrapper-searchFilter">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="sectionHead__wrapper">
                                    <ul class="upper">
                                        <li class="active"><a href="javascript:;"><?= $this->title ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                
                                <?=
                                 DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'vle_name',
                                        'gender',
                                        'father_name',
                                        'mobile',
                                        'email',
                                        'vle_pan_number',
                                        [
                                            'attribute'=>'vle_pan_media_id',
                                            'label'=>'Pan Card Image',
                                            'format'=>'raw',
                                            'value'=>function($model){
                                                if(!empty($model->vle_pan_media_id)){
                                                    $media = common\models\Media::findOne($model->vle_pan_media_id);
                                                    return yii\helpers\Html::a('Download', $media->cdn_path,['class'=>'button small green','target'=>'_blank']);
                                                }
                                                
                                                return '';
                                            }
                                        ],
                                    ],
                                ]);
                                ?>
                                
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                
                                <?=
                                 DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'attribute'=>'state_code',
                                            'label'=>'State',
                                            'value'=>function($model){
                                                return $model->stateCode->name;
                                            }
                                        ],
                                        [
                                            'attribute'=>'district_code',
                                            'label'=>'District',
                                            'value'=>function($model){
                                                return $model->districtCode->name;
                                            }
                                        ],
                                        [
                                            'attribute'=>'block_code',
                                            'label'=>'Block',
                                            'value'=>function($model){
                                                return $model->blockCode->name;
                                            }
                                        ],
                                        [
                                            'attribute'=>'panchayat_code',
                                            'label'=>'Panchayat',
                                            'value'=>function($model){
                                                return $model->panchayatCode->name;
                                            }
                                        ],
                                        [
                                            'attribute'=>'village_code',
                                            'label'=>'Village',
                                            'value'=>function($model){
                                                return $model->villageCode->name;
                                            }
                                        ],
                                        'centre_address',
                                        'pin',
                                    ],
                                ]);
                                ?>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <?=
                                 DetailView::widget([
                                    'model' => $model,
                                    'attributes'=>[
                                        'no_of_computers',
                                        'connectivity_type',
                                        [
                                            'attribute'=>'is_facilitation_center_already_registered',
                                            'value'=>function($model){
                                                return ($model->is_facilitation_center_already_registered=='1')?'Yes':'No';
                                            }
                                        ],
                                        [
                                            'attribute'=>'facilitation_center_no',
                                            'label'=>'Facilitation Center Number'
                                            
                                        ],
                                        [
                                            'attribute'=>'facilitation_center_certificate_media_id',
                                            'format'=>'raw',
                                            'label'=>'Facilitation Center Certificate',
                                            'value'=>function($model){
                                            
                                                if($model->facilitation_center_certificate_media_id){
                                                    return yii\helpers\Html::a('Download', $model->facilitationCenterCertificateMedia->cdn_path,['class'=>'button small green','target'=>'_blank']);
                                                }
                                                return '';
                                            
                                                
                                            }
                                        ],
                                        
                                        [
                                            'attribute'=>'is_vle_ccc_certified',
                                            'value'=>function($model){
                                                return ($model->is_vle_ccc_certified=='1')?'Yes':'No';
                                            }
                                        ],
                                        'vle_ccc_certificate_roll_no',
                                        'vle_ccc_grade',
                                        [
                                            'attribute'=>'vle_ccc_certificate_media_id',
                                            'label'=>'Vle Ccc Certificate',
                                            'format'=>'raw',
                                            'value'=>function($model){
                                                if($model->vle_ccc_certificate_media_id){
                                                    return yii\helpers\Html::a('Download', $model->vleCccCertificateMedia->cdn_path,['class'=>'button small green','target'=>'_blank']);
                                                }
                                                return '';
                                            }
                                        ],
                                        
                                        'equivalent_qualification',
                                        'equivalent_person',
                                        'equivalent_university_name',
                                        'equivalent_roll_no',
                                        'equivalent_grade',
                                        [
                                            'attribute'=>'equivalent_certificate_media_id',
                                            'format'=>'raw',
                                            'label'=>'Equivalent Certificate',
                                            'value'=>function($model){
                                                if($model->equivalent_certificate_media_id){
                                                    return yii\helpers\Html::a('Download', $model->equivalentCertificateMedia->cdn_path,['class'=>'button small green','target'=>'_blank']);
                                                }
                                                return '';
                                            }
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>

                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End Form section -->