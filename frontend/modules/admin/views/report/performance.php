<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Peformance Report';
//$noDataClass = ($provider->getTotalCount() <= 0) ? ' no-data' : '';

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
<?= $this->render('partials/_sub-menu.php', ['peformance' => TRUE]) ?>
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
                                            <a class="export" href="<?= Url::toRoute(['report/performance']) ?>">Export</a>
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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:50px !important;">S.No.</th>
                                                <th style="width:110px !important;">Name of DH</th>
                                                <th colspan="3">FRESH CLAIMS
                                        <table class="table">
                                            <tr>
                                                <th width="50">No of claim pending <br> for processing with start of period</th>
                                                <th width="50">Fresh claim alloted<br> during the period</th>
                                                <th width="50">Total Claim (Fresh)</th>
                                            </tr>
                                        </table>
                                        </th>
                                        <th colspan="3">RESUBMITTED CLAIM
                                        <table class="table">
                                            <tr>
                                                <th width="50">Letter pending for processing <br>during the period</th>
                                                <th width="50">letters received during <br>the period</th>
                                                <th width="50">Total Letter Pending</th>
                                            </tr>
                                        </table>
                                        </th>
                                        <th colspan="3">No. of claim processed
                                        <table class="table">
                                            <tr>
                                                <th width="50">New</th>
                                                <th width="50">Resubmitted</th>
                                                <th width="50">Total</th>
                                            </tr>
                                        </table>
                                        </th>
                                        <th colspan="4">Processed claim bifucation
                                        <table class="table">
                                            <tr>
                                                <th width="50">Resubmission/ Discrepancy</th>
                                                <th width="50">Approval</th>
                                                <th width="50">rejection</th>
                                                <th width="50">Total</th>
                                            </tr>
                                        </table>
                                        </th>
                                        <th colspan="3">Pendency
                                        <table class="table">
                                            <tr>
                                                <th width="50">No. of Fresh Claims pending<br> at the end of the period</th>
                                                <th width="50">pending of resubmitted <br>claims for processing</th>
                                                <th width="50">Total (claims + letters Pending at end )</th>
                                            </tr>
                                        </table>
                                        </th>
                                        <th colspan="2">Performance of DH
                                        <table class="table">
                                            <tr>
                                                <th width="50">Monthly Target Asigned</th>
                                                <th width="50">% of Target achieved (of total file processing up to the Month end)=T/S*100</th>

                                            </tr>
                                        </table>
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($grievanceList) && !empty($grievanceList)) : ?>
                                                <?php
                                                $i = 1;
                                                $sum_fresh_claim_start_week = array_sum(array_column($grievanceList, 'fresh_claim_start_week'));
                                                $sum_fresh_claim_alloted_week = array_sum(array_column($grievanceList, 'fresh_claim_alloted_week'));
                                                $sum_total_fresh_claim_alloted_week = array_sum(array_column($grievanceList, 'total_fresh_claim_alloted_week'));
                                                $sum_resubmitted_claim_start_week = array_sum(array_column($grievanceList, 'resubmitted_claim_start_week'));
                                                $sum_resubmitted_claim_alloted_week = array_sum(array_column($grievanceList, 'resubmitted_claim_alloted_week'));
                                                $sum_total_resubmitted_claim_alloted_week = array_sum(array_column($grievanceList, 'total_resubmitted_claim_alloted_week'));
                                                $sum_claim_processes_new = array_sum(array_column($grievanceList, 'claim_processes_new'));
                                                $sum_claim_processed_resubmitted = array_sum(array_column($grievanceList, 'claim_processed_resubmitted'));
                                                $sum_total_claim_processed = array_sum(array_column($grievanceList, 'total_claim_processed'));
                                                $sum_bifucation_processed_claim_resubmitted_discrepancy = array_sum(array_column($grievanceList, 'bifucation_processed_claim_resubmitted_discrepancy'));
                                                $sum_bifucation_processed_claim_approved = array_sum(array_column($grievanceList, 'bifucation_processed_claim_approved'));
                                                $sum_bifucation_processed_claim_rejected = array_sum(array_column($grievanceList, 'bifucation_processed_claim_rejected'));
                                                $sum_total_bifucation_processed = array_sum(array_column($grievanceList, 'total_bifucation_processed'));
                                                $sum_resubmitted_claim_start_week = array_sum(array_column($grievanceList, 'resubmitted_claim_start_week'));
                                                $sum_fresh_claim_end_week = array_sum(array_column($grievanceList, 'fresh_claim_end_week'));
                                                $sum_resubmitted_claim_end_week = array_sum(array_column($grievanceList, 'resubmitted_claim_end_week'));
                                                $sum_total_fresh_claim_alloted_end_week = array_sum(array_column($grievanceList, 'total_fresh_claim_alloted_end_week'));
                                                $sum_monthly_target_assigned = array_sum(array_column($grievanceList, 'monthly_target_assigned'));
                                                $percentage_target = !empty($sum_total_claim_processed) && $sum_monthly_target_assigned != 0 ? ($sum_total_claim_processed / $sum_monthly_target_assigned) * 100 : 0.00;
                                                foreach ($grievanceList as $grievance):
                                                    ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $grievance['dealingHead']; ?></td>
                                                        <td colspan="3">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['fresh_claim_start_week']; ?></td>
                                                                    <td><?= $grievance['fresh_claim_alloted_week']; ?></td>
                                                                    <td><?= $grievance['total_fresh_claim_alloted_week']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['resubmitted_claim_start_week']; ?></td>
                                                                    <td><?= $grievance['resubmitted_claim_alloted_week']; ?></td>
                                                                    <td><?= $grievance['total_resubmitted_claim_alloted_week']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                        <td colspan="3">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['claim_processes_new']; ?></td>
                                                                    <td><?= $grievance['claim_processed_resubmitted']; ?></td>
                                                                    <td><?= $grievance['total_claim_processed']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="4">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['bifucation_processed_claim_resubmitted_discrepancy']; ?></td>
                                                                    <td><?= $grievance['bifucation_processed_claim_approved']; ?></td>
                                                                    <td><?= $grievance['bifucation_processed_claim_rejected']; ?></td>
                                                                    <td><?= $grievance['total_bifucation_processed']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="3">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['fresh_claim_end_week']; ?></td>
                                                                    <td><?= $grievance['resubmitted_claim_end_week']; ?></td>
                                                                    <td><?= $grievance['total_fresh_claim_alloted_end_week']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="2">
                                                            <table class="table fixWidTbale">
                                                                <tr>
                                                                    <td><?= $grievance['monthly_target_assigned']; ?></td>
                                                                    <td><?= $grievance['percentage_target']; ?></td>

                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                                ?>
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td>Total</td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td><?= $sum_fresh_claim_start_week; ?></td>
                                                            <td><?= $sum_fresh_claim_alloted_week; ?></td>
                                                            <td><?= $sum_total_fresh_claim_alloted_week; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td><?= $sum_resubmitted_claim_start_week; ?></td>
                                                            <td><?= $sum_resubmitted_claim_alloted_week; ?></td>
                                                            <td><?= $sum_total_resubmitted_claim_alloted_week; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td><?= $sum_claim_processes_new; ?></td>
                                                            <td><?= $sum_claim_processed_resubmitted; ?></td>
                                                            <td><?= $sum_total_claim_processed; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="4">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td><?= $sum_bifucation_processed_claim_resubmitted_discrepancy; ?></td>
                                                            <td><?= $sum_bifucation_processed_claim_approved; ?></td>
                                                            <td><?= $sum_bifucation_processed_claim_rejected; ?></td>
                                                            <td><?= $sum_total_bifucation_processed; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td><?= $sum_fresh_claim_end_week; ?></td>
                                                            <td><?= $sum_resubmitted_claim_end_week; ?></td>
                                                            <td><?= $sum_total_fresh_claim_alloted_end_week; ?></td>

                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="2">
                                                    <table class="table fixWidTbale">
                                                        <tr>
                                                            <td><?= $sum_monthly_target_assigned; ?></td>
                                                            <td><?= number_format((float) $percentage_target, 2, '.', ''); ?></td>
                                                        </tr>
                                                    </table>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td></td>
                                                            <td><?= $sum_total_fresh_claim_alloted_week; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td></td>
                                                            <td><?= $sum_total_resubmitted_claim_alloted_week; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td></td>
                                                            <td><?= $sum_total_claim_processed; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="4">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td></td>
                                                            <td><?= $sum_total_bifucation_processed; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="3">
                                                    <table class="table fixWidTbale">
                                                        <tr>

                                                            <td></td>
                                                            <td><?= $sum_total_fresh_claim_alloted_end_week; ?></td>
                                                            <td></td>

                                                        </tr>
                                                    </table>
                                                </td>
                                                

                                            </tr>
                                        </tfoot>
                                         <?php else: ?>
                                                <tr><td colspan="14"><div class="empty text-center">No results found.</div></td></tr>
                                            <?php endif; ?>
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