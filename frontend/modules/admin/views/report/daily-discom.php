<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = (isset($title)) ? $title : 'New Daily Discom Reports';
$noDataClass = ($provider->getTotalCount() <= 0) ? ' no-data' : '';
$fromDate = date('d-m-Y');
$toDate = date('d-m-Y');

$date1 = date('Y-m-d', strtotime(' -2 day'));
$date2 = date('Y-m-d', strtotime(' -1 day'));
if (isset($searchModel->from_date) && !empty($searchModel->from_date)) {
    $fromDate = $searchModel->from_date;
    $date1 = date('Y-m-d', strtotime($searchModel->from_date . ' -2 day')); //date('Y-m-d', strtotime(' -2 day'));
    $date2 = date('Y-m-d', strtotime($searchModel->from_date . ' -1 day'));
}
if (isset($searchModel->to_date) && !empty($searchModel->to_date)) {
    $toDate = $searchModel->to_date;
}
$this->registerJs("GrievanceController.datePicker('$fromDate','$toDate')");
$this->registerJs('StateController.initializeChozen();');
?>
<?= $this->render('partials/_sub-menu.php', ['daily' => TRUE]) ?>
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
                                            <a class="export" href="<?= Url::toRoute(['report/daily-report']) ?>">Export</a>
                                        </div>
                                    </div>
                                </div>
                                <?=
                                    $this->render('_filter-form.php', [
                                        'searchModel' => $searchModel,
                                        'from_date' => TRUE
                                    ])
                                ?>
                            </div>
                            <div class="table__structure">
                                <div class="table-responsive noFix fixWidTbale">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>State</th>
                                                <th colspan="4">
                                                    <table class="table">
                                                        <tr>
                                                            <th width="150">Discom</th>
                                                            <th width="150">Upto <?= $date1; ?></th>
                                                            <th width="150">On <?= $date2; ?></th>
                                                            <th width="150">Upto <?= $date2; ?></th>
                                                            <th width="150">Complaints resolved/ settled all grievances with status 'closed' and 'completed'(Nos.)</th>
                                                            <th width="150">Complaints being resolved all grievances with status 'pending', 'ongoing' and 'reopen'</th>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sumtotalReceivedDay1 = $sumtotalReceivedDay2 = $sumtotalCompletedDay1 = $sumtotalCompletedDay2 = $sumtotalPendingDay1 = $sumtotalPendingDay2 = 0;
                                            if (isset($grievanceList) && !empty($grievanceList)) :
                                                ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($grievanceList as $grievance) : ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= ucwords($grievance['name']) ?></td>
                                                        <td colspan="4">
                                                            <table class="table fixWidTbale">
                                                                <?php
                                                                $totalReceivedDay1 = 0;
                                                                $totalReceivedDay2 = 0;
                                                                $totalCompletedDay1 = 0;
                                                                $totalCompletedDay2 = 0;
                                                                $totalPendingDay1 = 0;
                                                                $totalPendingDay2 = 0;

                                                                if (isset($grievance['discom']) && !empty($grievance['discom'])) :
                                                                    foreach ($grievance['discom'] as $discomCode => $discomArr) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $discomCode; ?></td>
                                                                            <?php
                                                                            $receivedDay1 = $receivedDay2 = $pendingDay1 = $pendingDay2 = $completedDay1 = $completedDay2 = 0;
                                                                            foreach ($discomArr as $date => $data) :
                                                                                ?>
                                                                                <?php
                                                                                if ($date <= $date1) :
                                                                                    $receivedDay1 = $discomArr[$date]['recieved'] + $receivedDay1;
                                                                                    if (isset($discomArr[$date]['completed'])) {
                                                                                        $completedDay1 = $discomArr[$date]['completed'] + $completedDay1;
                                                                                    }
                                                                                    if (isset($discomArr[$date]['pending'])) {
                                                                                        $pendingDay1 = $discomArr[$date]['pending'] + $pendingDay1;
                                                                                    }
                                                                                    ?>

                                                                                <?php endif; ?>
                                                                                <?php
                                                                                if ($date == $date2) :
                                                                                    $receivedDay2 = $discomArr[$date]['recieved'] + $receivedDay2;
                                                                                    //$completedDay2 = $discomArr[$date]['completed'] + $completedDay2;
                                                                                    if (isset($discomArr[$date]['completed'])) {
                                                                                        $completedDay2 = $discomArr[$date]['completed'] + $completedDay2;
                                                                                    }
                                                                                    if (isset($discomArr[$date]['pending'])) {
                                                                                        $pendingDay2 = $discomArr[$date]['pending'] + $pendingDay2;
                                                                                    }
                                                                                    ?>
                                                                                <?php endif; ?>
                                                                            <?php
                                                                        endforeach;
                                                                        $totalReceivedDay1 = $totalReceivedDay1 + $receivedDay1;
                                                                        $totalReceivedDay2 = $totalReceivedDay2 + $receivedDay2;
                                                                        $totalPendingDay1 = $totalPendingDay1 + $pendingDay1;
                                                                        $totalPendingDay2 = $totalPendingDay2 + $pendingDay2;
                                                                        $totalCompletedDay1 = $totalCompletedDay1 + $completedDay1;
                                                                        $totalCompletedDay2 = $totalCompletedDay2 + $completedDay2;
                                                                        ?>
                                                                            <td><?= $receivedDay1; ?></td>
                                                                            <td><?= $receivedDay2; ?></td>
                                                                            <td><?= $receivedDay1 + $receivedDay2; ?></td>
                                                                            <td><?= $completedDay1 + $completedDay2; ?></td>
                                                                            <td><?= $pendingDay1 + $pendingDay2; ?></td>
                                                                        </tr>


                                                                    <?php
                                                                }
                                                            endif;
                                                            if (count($grievance['discom']) > 1) :
                                                                ?>
                                                                    <tfoot>
                                                                        <tr>

                                                                            <td><strong>Total</strong></td>
                                                                            <td><?= $totalReceivedDay1; ?></td>
                                                                            <td><?= $totalReceivedDay2; ?></td>
                                                                            <td><?= $totalReceivedDay1 + $totalReceivedDay2; ?></td>
                                                                            <td><?= $totalCompletedDay1 + $totalCompletedDay2; ?></td>
                                                                            <td><?= $totalPendingDay1 + $totalPendingDay2; ?></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                <?php endif; ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                    <?php
                                                    $sumtotalReceivedDay1 = $sumtotalReceivedDay1 + $totalReceivedDay1;
                                                    $sumtotalReceivedDay2 = $sumtotalReceivedDay2 + $totalReceivedDay2;
                                                    $sumtotalCompletedDay1 = $sumtotalCompletedDay1 + $totalCompletedDay1;
                                                    $sumtotalCompletedDay2 = $sumtotalCompletedDay2 + $totalCompletedDay2;
                                                    $sumtotalPendingDay1 = $sumtotalPendingDay1 + $totalPendingDay1;
                                                    $sumtotalPendingDay2 = $sumtotalPendingDay2 + $totalPendingDay2;

                                                endforeach;
                                                ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td class="text-center" colspan="15">Result not found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <td></td>
                                            <td></td>
                                            <td colspan="4">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td><?= $sumtotalReceivedDay1; ?></td>
                                                        <td><?= $sumtotalReceivedDay2; ?></td>
                                                        <td><?= $sumtotalReceivedDay1 + $sumtotalReceivedDay2; ?></td>
                                                        <td><?= $sumtotalCompletedDay1 + $sumtotalCompletedDay2; ?></td>
                                                        <td><?= $sumtotalPendingDay1 + $sumtotalPendingDay2; ?></td>
                                                    </tr>
                                                </table> 
                                            </td> 
                                        </tfoot>
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
    window.location = url + '?download=true&' + window.location.search.substring(1);
   });
JS;
$this->registerJs($script);
?>