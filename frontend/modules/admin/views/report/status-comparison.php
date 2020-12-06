<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Status Comparison Report';
$first = date('d-m-Y');
$second = date('d-m-Y');
$third = date('d-m-Y');
$fourth = date('d-m-Y');

if (isset($searchModel->first_date_range) && !empty($searchModel->first_date_range)) {
    $first = substr($searchModel->first_date_range,0,10);
    $second = substr($searchModel->first_date_range,13,10);        
}
if (isset($searchModel->second_date_range) && !empty($searchModel->second_date_range)) {
    $third = substr($searchModel->second_date_range,0,10);
    $fourth = substr($searchModel->second_date_range,13,10); 
}
$this->registerJs("GrievanceController.dateRangePickerStatusComparison('$first','$second','$third','$fourth')");
?>
<?= $this->render('partials/_sub-menu.php', ['status' => TRUE]) ?>
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
                                            <a class="export" href="<?= Url::toRoute(['report/status-comparison']) ?>">Export</a>
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
                                        <li>
                                            <?=
                                            $form->field($searchModel, 'first_date_range')->textInput([
                                                'autofocus' => false,
                                                'autocomplete' => 'off',
                                                'required' => TRUE,
                                                'class' => 'form-control firstDatePickerRange',
                                                'placeholder' => \Yii::t('admin', 'Range')
                                            ])->label(false)
                                            ?>
                                        </li>
                                        <li>
                                            <?=
                                            $form->field($searchModel, 'second_date_range')->textInput([
                                                'autofocus' => false,
                                                'autocomplete' => 'off',
                                                'required' => TRUE,
                                                'class' => 'form-control secondDatePickerRange',
                                                'placeholder' => \Yii::t('admin', 'Range')
                                            ])->label(false)
                                            ?>
                                        </li>
                                        <li class="action-button">
                                            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
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
                                                    Range One Count <?= !empty($searchModel->first_date_range) ? ' ('.$searchModel->first_date_range.')' : '' ?>
                                                </th>
                                                <th>
                                                    Range Two Count <?= !empty($searchModel->second_date_range) ? ' ('.$searchModel->second_date_range.')' : ''?>
                                                </th>
                                            </tr>   

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>No of claims filed</td>
                                                <td><?= isset($grievanceList['rangeOne']['pending']) && !empty($grievanceList['rangeOne']['pending']) ? $grievanceList['rangeOne']['pending'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['pending']) && !empty($grievanceList['rangeTwo']['pending']) ? $grievanceList['rangeTwo']['pending'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>No.of Verification Report received</td>
                                                <td><?= isset($grievanceList['rangeOne']['vrRecieved']) && !empty($grievanceList['rangeOne']['vrRecieved']) ? $grievanceList['rangeOne']['vrRecieved'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['vrRecieved']) && !empty($grievanceList['rangeTwo']['vrRecieved']) ? $grievanceList['rangeTwo']['vrRecieved'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Paid</td>
                                                <td><?= isset($grievanceList['rangeOne']['paid']) && !empty($grievanceList['rangeOne']['paid']) ? $grievanceList['rangeOne']['paid'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['paid']) && !empty($grievanceList['rangeTwo']['paid']) ? $grievanceList['rangeTwo']['paid'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Approved (Either share transfer/Amount transfer taken place)</td>
                                                <td><?= isset($grievanceList['rangeOne']['approved']) && !empty($grievanceList['rangeOne']['approved']) ? $grievanceList['rangeOne']['approved'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['approved']) && !empty($grievanceList['rangeTwo']['approved']) ? $grievanceList['rangeTwo']['approved'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Rejected</td>
                                                <td><?= isset($grievanceList['rangeOne']['rejected']) && !empty($grievanceList['rangeOne']['rejected']) ? $grievanceList['rangeOne']['rejected'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['rejected']) && !empty($grievanceList['rangeTwo']['rejected']) ? $grievanceList['rangeTwo']['rejected'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims pending (Fresh Claim Pending +Resubmitted claim pending)</td>
                                                <td><?= isset($grievanceList['rangeOne']['underProcess']) && !empty($grievanceList['rangeOne']['underProcess']) ? $grievanceList['rangeOne']['underProcess'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['underProcess']) && !empty($grievanceList['rangeTwo']['underProcess']) ? $grievanceList['rangeTwo']['underProcess'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims sent for Resubmission</td>
                                                <td><?= isset($grievanceList['rangeOne']['discrepancy']) && !empty($grievanceList['rangeOne']['discrepancy']) ? $grievanceList['rangeOne']['discrepancy'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['discrepancy']) && !empty($grievanceList['rangeTwo']['discrepancy']) ? $grievanceList['rangeTwo']['discrepancy'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Number of Discrepancy Mail Sent</td>
                                                <td><?= isset($grievanceList['rangeOne']['mailSentCount']) && !empty($grievanceList['rangeOne']['mailSentCount']) ? $grievanceList['rangeOne']['mailSentCount'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['mailSentCount']) && !empty($grievanceList['rangeTwo']['mailSentCount']) ? $grievanceList['rangeTwo']['mailSentCount'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>No.of shares Refunded (NSDL)</td>
                                                <td><?= isset($grievanceList['rangeOne']['nsdlShares']) && !empty($grievanceList['rangeOne']['nsdlShares']) ? $grievanceList['rangeOne']['nsdlShares'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['nsdlShares']) && !empty($grievanceList['rangeTwo']['nsdlShares']) ? $grievanceList['rangeTwo']['nsdlShares'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>No.of shares Refunded (CDSL)</td>
                                                <td><?= isset($grievanceList['rangeOne']['cdslShares']) && !empty($grievanceList['rangeOne']['cdslShares']) ? $grievanceList['rangeOne']['cdslShares'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['cdslShares']) && !empty($grievanceList['rangeTwo']['cdslShares']) ? $grievanceList['rangeTwo']['cdslShares'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>No.of shares Refunded (CDSL+NSDL)</td>
                                                <td><?= isset($grievanceList['rangeOne']['totalShares']) && !empty($grievanceList['rangeOne']['totalShares']) ? $grievanceList['rangeOne']['totalShares'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['totalShares']) && !empty($grievanceList['rangeTwo']['totalShares']) ? $grievanceList['rangeTwo']['totalShares'] : '0' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Amount Refunded</td>
                                                <td><?= isset($grievanceList['rangeOne']['refundAmount']) && !empty($grievanceList['rangeOne']['refundAmount']) ? $grievanceList['rangeOne']['refundAmount'] : '0' ?></td>
                                                <td><?= isset($grievanceList['rangeTwo']['refundAmount']) && !empty($grievanceList['rangeTwo']['refundAmount']) ? $grievanceList['rangeTwo']['refundAmount'] : '0' ?></td>
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
    var queryparams = window.location.search.substring(1); 
    if(queryparams == '' || queryparams == null){
        alert('Select Both range');
        return;
    }
    window.location = url + '?download=true&' + window.location.search.substring(1);
   });
JS;
$this->registerJs($script);
?>
