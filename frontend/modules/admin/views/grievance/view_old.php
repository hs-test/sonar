<?php

use yii\widgets\DetailView;

$this->title = 'Grievance View';
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper">Grievance Manager</h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?= yii\helpers\Url::toRoute(['grievance/index']); ?>">
                                Grievance
                            </a>
                        </li>
                        <li class="active">
                            <?= "Grievance View" ?> 
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</div>
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
                        <!-- Begin One column section -->
                        <div class="row">
                            <div class="col-md-12 col-xs-12">

                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'name',
                                        'gender',
                                        'email:email',
                                        'grievance_no',
                                        'address',
                                        'pincode',
                                        'type',
                                        'description_complaint',
                                        'mobile_no',
                                        [                      // the owner name of the model
                                            'label' => 'State',
                                            'value' => (isset($model->state_code)) ? $model->stateCode->name : '',
                                        ],
                                        [                      // the owner name of the model
                                            'label' => 'District',
                                            'value' => (isset($model->district_code)) ? $model->districtCode->name : '',
                                        ],
                                        [                      // the owner name of the model
                                            'label' => 'Block',
                                            'value' => (isset($model->block_code)) ? $model->blockCode->name : '',
                                        ],
                                        [                      // the owner name of the model
                                            'label' => 'Panchayat',
                                            'value' => (isset($model->panchayat_code)) ? $model->panchayatCode->name : '',
                                        ],
                                        [                      // the owner name of the model
                                            'label' => 'Village',
                                            'value' => (isset($model->village_code)) ? $model->villageCode->name : '',
                                        ],
                                        [                      // the owner name of the model
                                            'label' => 'Status',
                                            'value' => (isset($model->status) && $model->status === common\models\caching\ModelCache::RECORD_IS_ACTIVE_YES) ? 'Active' : 'Inactive',
                                        ],
                                        'created_at:date:Submit Date', // creation date formatted as datetime
                                    ],
                                ]);
                                ?>
                            </div>    
                        </div>    
                        <!-- End One column section -->
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- End Form section -->