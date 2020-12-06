<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Status Report';

$fromDate = date('Y-m-d');
$toDate = date('Y-m-d');
if (isset($searchModel->from_date) && !empty($searchModel->from_date)) {
    $fromDate = $searchModel->from_date;
}
if (isset($searchModel->to_date) && !empty($searchModel->to_date)) {
    $toDate = $searchModel->to_date;
}
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
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
                                            <a class="export" href="<?= Url::toRoute(['report/status']) ?>">Export</a>
                                        </div>
                                    </div>
                                </div>
                                <?=
                                $this->render('_filter-form.php', [
                                    'searchModel' => $searchModel,
                                    'from_date' => TRUE,
                                    'to_date' => TRUE,
                                ])
                                ?>
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
                                                <td>No. of claims filed</td>
                                                <td><?= $grievanceList['pending']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of Verification Report Received</td>
                                                <td><?= $grievanceList['vrRecieved']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of Resubmitted Claims Received</td>
                                                <td><?= $grievanceList['underProcess']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Paid</td>
                                                <td><?= $grievanceList['paid']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Approved (Either share transfer/Amount transfer taken place)</td>
                                                <td><?= $grievanceList['approved']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims Rejected</td>
                                                <td><?= $grievanceList['rejected']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims pending (Fresh Claim Pending +Resubmitted claim pending)</td>
                                                <td><?= $grievanceList['underProcessVrRecieved']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Claims sent for Resubmission</td>
                                                <td><?= $grievanceList['discrepancy']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Number of Discrepancy Mail Sent</td>
                                                <td><?= $grievanceList['mailSentCount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of shares Refunded (NSDL)</td>
                                                <td><?= $grievanceList['nsdlShares']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of shares Refunded (CDSL)</td>
                                                <td><?= $grievanceList['cdslShares']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of shares Refunded (CDSL+NSDL)</td>
                                                <td><?= $grievanceList['totalShares']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Amount Refunded</td>
                                                <td><?= $grievanceList['refundAmount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of only amount refunded cases</td>
                                                <td><?= $grievanceList['onlyAmountRefundCount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of only shares refunded cases</td>
                                                <td><?= $grievanceList['onlyShareRefundCount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. of cases in which both shared & amount transferred</td>
                                                <td><?= $grievanceList['bothRefundCount']; ?></td>
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
    var from = $(".fromDatePicker").val();
    var to = $(".toDatePicker").val();    
    if(from == "" || from == ""){
        alert("Select The Dates and Search");
        return ;
   } 
    window.location = url + '?download=true&' + window.location.search.substring(1);
   });
JS;
$this->registerJs($script);
?>
