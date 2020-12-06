<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Aging Report';


if (isset($searchModel->date) && !empty($searchModel->date)) {
    $Date = $searchModel->date;
}
$this->registerJs("GrievanceController.date('$Date')");
?>
<?= $this->render('partials/_sub-menu.php', ['aging' => TRUE]) ?>
<?= $this->render('partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>
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
                                        <div class="section-head__optionSets--addButton">
                                            <a class="export" href="<?= Url::toRoute(['report/aging']) ?>">Export</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $form = \yii\bootstrap\ActiveForm::begin([
                                            'id' => 'ReportSearchForm',
                                            'method' => 'GET',
                                ]);
                                ?>
                                <div class="filters-wrapper" style="display:block">
                                    <ul>
                                        <?php if (isset($Date) && $Date): ?>
                                            <li>
                                                <?=
                                                $form->field($searchModel, 'date')->textInput([
                                                    'autofocus' => false,
                                                    'autocomplete' => 'off',
                                                    'class' => 'form-control js-datePicker',
                                                    'placeholder' => \Yii::t('admin', 'Date')
                                                ])->label(false)
                                                ?>
                                            </li>
                                        <?php endif; ?>
                                        <li class="action-button">
                                            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>

                                        </li>
                                        <li class="action-button">
                                            <?= \yii\helpers\Html::button('Reset', ['class' => 'button blue small resetForm', 'type' => 'button']) ?>
                                        </li>
                                    </ul>
                                </div>
                                <?php \yii\bootstrap\ActiveForm::end(); ?>
                            </div>
                            <div class="table__structure">
                                <div class="table-responsive noFix fixWidTbale">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Particulars
                                                </th>
                                                <th>
                                                    Count
                                                </th>
                                            </tr>   

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span style="color:black">Fresh Claims Pending (To be calculated from the Date of Receipt of the Fresh claim)</span></td>
                                                <td><span style="color:black"><?= $grievanceList['freshClaimPending'] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>More than 120 Days</td>
                                                <td><?= $grievanceList['vrgreaterthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 90 Days</td>
                                                <td><?= $grievanceList['vrlessthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 60 Days</td>
                                                <td><?= $grievanceList['vrlessthanninety'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 30 Days</td>
                                                <td><?= $grievanceList['vrlessthansixty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 15 Days</td>
                                                <td><?= $grievanceList['vrlessthanthirty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Equal to or Less than 15 Days</td>
                                                <td><?= $grievanceList['vrlessthanfifteen'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><span style="color:black">Re submitted claims Pending (To be calculated from the Date of Receipt of the Re submitted claims )</span></td>
                                                <td><span style="color:black"><?= $grievanceList['resubmitted'] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>More than 120 Days</td>
                                                <td><?= $grievanceList['drgreaterthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 90 Days</td>
                                                <td><?= $grievanceList['drlessthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 60 Days</td>
                                                <td><?= $grievanceList['drlessthanninety'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 30 Days</td>
                                                <td><?= $grievanceList['drlessthansixty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 15 Days</td>
                                                <td><?= $grievanceList['drlessthanthirty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Equal to or Less than 15 Days</td>
                                                <td><?= $grievanceList['drlessthanfifteen'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><span style="color:black">Verification Report not received (To be calculated from the Date of Posting)</span></td>
                                                <td><span style="color:black"><?= $grievanceList['verificationReportPending'] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>More than 120 Days</td>
                                                <td><?= $grievanceList['pendinggreaterthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 90 Days</td>
                                                <td><?= $grievanceList['pendinglessthanonetwenty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 60 Days</td>
                                                <td><?= $grievanceList['pendinglessthanninety'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 30 Days</td>
                                                <td><?= $grievanceList['pendinglessthansixty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>More than 15 Days</td>
                                                <td><?= $grievanceList['pendinglessthanthirty'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Equal to or Less than 15 Days</td>
                                                <td><?= $grievanceList['pendinglessthanfifteen'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
$script = <<< JS
   $(document).on('click', 'a.export', function(event) {
    event.preventDefault(); 
    var url = $(this).attr("href"); 
    var date = $(".js-datePicker").val();
    if(date == ""){
        alert("Select The Date and Search");
        return ;
   } 
    window.location = url + '?download=true&' + window.location.search.substring(1);
   });
JS;
$this->registerJs($script);
?>
