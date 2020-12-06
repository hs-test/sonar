<?php

use yii\helpers\Url;
use \common\models\Grievance;

$this->title = 'Dashboard';

$showPending = $showApproved = $showRejected = $showDiscrepancy = $showUnderProcess = $showPaid = $showLink = TRUE;
if (\Yii::$app->user->hasDispatchExecuitveRole()) {
    $showApproved = $showRejected = $showPaid = $showUnderProcess = FALSE;
}
else if (\Yii::$app->user->hasAccountManagerRole()) {
    $showPending = $showRejected = $showDiscrepancy = $showUnderProcess = FALSE;
}
else if (\Yii::$app->user->hasAccountManagerRole()) {
    $showPending = $showRejected = $showDiscrepancy = $showUnderProcess = FALSE;
}
else if (\Yii::$app->user->hasCallCenterRole()) {
    $showLink = FALSE;
}
else if (\Yii::$app->user->hasCallCenterSupervisor()) {
    $showLink = FALSE;
}
else if (\Yii::$app->user->hasAssignmentOfficerRole()) {
    $showLink = FALSE;
}
else if (\Yii::$app->user->hasSupervisorRole()) {
    $showLink = FALSE;
}
?>
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="dashboard__wrapper padding-zero">
                    <div class="counters__wrapper">
                        <div class="counters__wrapper__main">
                            <div class="counters__wrapper__main--tile clr4" style="flex: 0 0 calc(100% / 3 - 24px)">
                                <a href="<?= ($showLink) ? Url::toRoute(['grievance/index']) : 'javascript:;'; ?>">
                                    <div class="counters__wrapper__main--tile--icon"><span class="fa fa-users"></span></div>
                                    <div class="counters__wrapper__main--tile--content">
                                        <span class="title">TOTAL SRN</span>
                                        <span class="counter"><?= array_sum($counters); ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php if ($showPending): ?>
                                <div class="counters__wrapper__main--tile clr1" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::PENDING]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-television"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">VR NOT RECEIVED</span>
                                            <span class="counter"><?= $counters['pending']; ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($showPending): ?>
                                <div class="counters__wrapper__main--tile clr3" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::VR_ASSIGNED]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-television"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">FRESH CLAIM PENDING</span>
                                            <span class="counter"><?= $counters['vr_assigned']; ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($showPending): ?>
                                <div class="counters__wrapper__main--tile clr1" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::DR_ASSIGNED]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-television"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">RESUBMITTED PENDING</span>
                                            <span class="counter"><?= $counters['dr_assigned'] ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($showDiscrepancy): ?>
                                <div class="counters__wrapper__main--tile clr4" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::DISCREPANCY]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">SENT FOR RESUBMISSION</span>
                                            <span class="counter"><?= $counters['discrepancy'] ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($showApproved): ?>
                                <div class="counters__wrapper__main--tile clr3" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::APPROVED]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">SRN APPROVED (Pending For Payment)</span>
                                            <span class="counter"><?= $counters['approved'] ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?> 
                            <?php if ($showUnderProcess): ?>
                                <div class="counters__wrapper__main--tile clr2" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::UNDER_PROCESS]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">SRN UNDER PROCESS</span>
                                            <span class="counter"><?= $counters['under_process'] ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                           <?php if ($showRejected): ?>
                                <div class="counters__wrapper__main--tile clr2" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::REJECTED]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">SRN REJECTED</span>
                                            <span class="counter"><?= $counters['rejected'] ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($showPaid): ?>
                                <div class="counters__wrapper__main--tile clr4" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="<?= ($showLink) ? Url::toRoute(['grievance/index', 'GrievanceSearch' => ['grievanceStatus' => Grievance::PAID]]) : 'javascript:;'; ?>">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">SRN PAID</span>
                                            <span class="counter"><?= $counters['paid'] ?></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="counters__wrapper__main--tile clr4" style="flex: 0 0 calc(100% / 3 - 24px)">
                                    <a href="#">
                                        <div class="counters__wrapper__main--tile--icon"><span class="fa fa-street-view"></span></div>
                                        <div class="counters__wrapper__main--tile--content">
                                            <span class="title">Total SRN Approved</span>
                                            <span class="counter"><?= ($counters['paid'] + $counters['approved']); ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Others section -->
    </div>
    <!-- End Others section -->
</div>