<?php

use yii\widgets\ActiveForm;

$this->title = "SRN Discrepancy Rejected Import";
?>
<?= $this->registerJs('GrievanceController.import();'); ?>
<?= $this->render('partials/_sub-menu.php', ['discripancyrejectedimport' => TRUE]) ?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>
<div class="page__main-content">
    <div class="page-main-content">
        <div class="container">
            <div class="content-wrap">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <section class="widget__wrapper">
                            <div class="table__structure table__structure-scrollable">
                                <div class="table__structure__head">
                                    <div class="section-head">
                                        <div class="section-head--title"></div>
                                        <div class="section-head__optionSets">
                                            <div class="section-head__optionSets--filter"><div class="top_buttonWrap">
                                                    <aside class="leftWrap">
                                                    </aside>
                                                    <aside class="rightWrap">
                                                        <a class="addComment button blue" href="<?= \Yii::$app->params['staticHttpPath'] . '/dist/deploy/format/discrepancy_rejected_import_format.csv'; ?>" title="Download Format"><i class="fa fa-file-excel-o"></i>Download Format</a>
                                                        <a class="button green" href="<?= yii\helpers\Url::toRoute(['grievance/import-logs', 'type' => common\models\GrievanceStat::TYPE_DISCRIPENCY_REJECTED]) ?>" title="View Logs" target="_blank"><i class="fa fa-eye"></i>View Logs</a>
                                                    </aside>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                            'template' => '<div class="input-group"><input class="form-control file-name" type="text" value="Choose .csv file"><label class="input-group-btn"><span class="btn button blue"><i class="fa fa-upload"></i>
                                                            Browse…{input}</span></label></div>{hint}{error}',
                                                        ])
                                                        ->fileInput(['style' => 'display:none'])
                                                        ->label(FALSE)
                                                ?>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <?= \yii\bootstrap\Html::submitButton(\yii::t('admin', 'Submit'), ['class' => 'button blue button-block', 'name' => 'impott-std-button']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($results) && !empty($results)): ?>
                                    <div class="col-md-12 col-xs-12">
                                        <div class="alert <?= (isset($results['errors']) && count($results['errors']) > 0) ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade in" role="alert">
                                            <button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                                            <?php if (isset($results['errors']) && count($results['errors']) > 0): ?>
                                                <?php foreach ($results['errors'] as $error): ?>
                                                    <p><?= $error ?></p>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>File imported successfully.</p>
                                            <?php endif; ?>
                                        </div>
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