<?php

use yii\widgets\ActiveForm;

$this->title = "Import Manager";
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <aside class="section section__left">
                    <h2 class="section__heading upper">Import Manager</h2>
                    <ul class="page__bar-breadcrumb">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="active">
                            Import Manager
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</div>
<div class="page-main-content">
    <div class="container">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <section class="widget__wrapper">
                        <?php
                        $form = ActiveForm::begin(['options' => [
                                        'enctype' => 'multipart/form-data',
                                        'class' => 'widget__wrapper-searchFilter']
                                ])
                        ?>

                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="file-upload-wrapper">
                                    <div class="row file-upload">
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <?=
                                                    $form->field($model, 'file', [
                                                        'template' => '<div class="input-group"><input class="form-control" type="text" value="Choose .csv file"><label class="input-group-btn"><span class="btn button blue"><i class="fa fa-upload"></i>
                                                        Browse…{input}</span></label></div>{hint}{error}',
                                                    ])
                                                    ->fileInput(['style' => 'display:none'])
                                                    ->label(FALSE)
                                            ?>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <?= \yii\bootstrap\Html::submitButton('Import', ['class' => 'button blue button-block', 'name' => 'impott-std-button']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($results) && !empty($results)): ?>
                                <div class="col-md-12 col-xs-12">
                                    <?php if(isset($results['errors'])):?>
                                    <div class="alert <?= (count($results['errors']) > 0) ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade in" role="alert">
                                        <button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                                        <?php if (count($results['errors']) > 0): ?> 
                                            <?php foreach ($results['errors'] as $error): ?>
                                                <p><?= $error ?></p>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>File imported successfully.</p>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <div style="width:100%">
                                        <div style="width:25%;float: left;"><b style="font-weight:bold">Total Record : <?= $results['failedRecords'] + $results['successRecords'] ?></b></div>
                                        <div  style="width:25%;float: left;"><b style="color:green;">Total Inserted Record : <?= $results['successRecords'] ?> </b></div>
                                        <div  style="width:25%;float: left;"><b style="color:red;">Total Failed Record : <?= $results['failedRecords'] ?></b></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </section>
                </div>
               
            </div>
        </div> 
    </div>
</div>