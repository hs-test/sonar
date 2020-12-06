<?php
$this->title = 'SRN View';
$applicationStatus = \common\models\Grievance::getGrievanceStatusArr(NULL, TRUE);
$this->registerJs('GrievanceController.createUpdate();');

//get last activity id for approved and rejected
$rejectedActivityId = $approvedActivityId = 0;
if (Yii::$app->user->hasAccountManagerRole()) {

    $grievanceActivityModel = \common\models\GrievanceActivityLog::findByGrievanceId($model->id, ['selectCols' => ['grievance_status', 'MAX(id) AS activity_log_id', 'grievance_id', 'MAX(`date`) AS max_date'], 'applicationStatus' => [common\models\Grievance::APPROVED, common\models\Grievance::REJECTED], 'groupBy' => ['grievance_activity_log.grievance_status'], 'resultCount' => common\models\caching\ModelCache::RETURN_ALL]);

    if (!empty($grievanceActivityModel)) {
        foreach ($grievanceActivityModel as $grievanceActivity) {
            $rejectedActivityId = $grievanceActivity['grievance_status'] == common\models\Grievance::REJECTED ? $grievanceActivity['activity_log_id'] : $rejectedActivityId;
            $approvedActivityId = $grievanceActivity['grievance_status'] == common\models\Grievance::APPROVED ? $grievanceActivity['activity_log_id'] : $approvedActivityId;
        }
    }
}
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'showBackButton' => TRUE]) ?>
<!-- Begin Form section -->
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="grievance__wrapper"> 
                    <!-- Top Buttons row-->
                    <div class="top_buttonWrap">
                        <aside class="leftWrap">
                        </aside>
                        <aside class="rightWrap">
                            <?php if (Yii::$app->user->hasCallCenterRole() || Yii::$app->user->hasCallCenterSupervisor()) : ?>
                                <a class="addComment button blue" href="javascript:;" title="Add Comments" data-url="<?= \yii\helpers\Url::toRoute(['grievance/add-comment', 'guid' => $guid]); ?>"><i class="fa fa-comments"></i>Add Comments</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->hasAccountManagerRole() && $model->status == \common\models\Grievance::PAID && !Yii::$app->user->hasAssistantAccountManagerRole()) : ?>
                                <a class="button blue" href="<?= \yii\helpers\Url::toRoute(['grievance/download-letter', 'guid' => $guid]); ?>" title="Download Sanction Letter" target="_blank"><i class="fa fa-download"></i>Download Sanction Letter</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->hasAccountManagerRole() && $model->status == \common\models\Grievance::APPROVED && !empty($model->refund_amount) && !Yii::$app->user->hasAssistantAccountManagerRole()) : ?>
                                <a class="button blue" href="<?= \yii\helpers\Url::toRoute(['grievance/download-gar', 'guid' => $guid]); ?>" title="Download GAR Letter" target="_blank"><i class="fa fa-download"></i>Download GAR Letter</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->hasAccountManagerRole() && !empty($approvedActivityId) && !Yii::$app->user->hasAssistantAccountManagerRole()) : ?>
                                <a class="button green sendEmailMessage" href="javascript:;" data-activity-log-id ="<?= $approvedActivityId; ?>" title="Send Approval Letter"><i class="fa fa-envelope"></i>Send Approval Letter</a>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->hasAccountManagerRole() && !empty($rejectedActivityId) && !Yii::$app->user->hasAssistantAccountManagerRole()) : ?>
                                <a class="button red sendEmailMessage" href="javascript:;" data-activity-log-id ="<?= $rejectedActivityId; ?>" title="Send Rejection Letter"><i class="fa fa-envelope"></i>Send Rejection Letter</a>
                            <?php endif; ?>
                        </aside>
                    </div>
                    <!--Basic view start-->
                    <section class="widget__wrapper">
                        <div class="section_head">
                            <h2>Basic</h2>
                        </div>
                        <div class="basicDetail">
                            <div class="basicDetail_listing">
                                <ul>
                                    <?php if (!empty($model->posting_date)): ?>
                                        <li><span>Date</span> <?= date('d-m-Y', strtotime($model->posting_date)); ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->srn_no)): ?>
                                        <li><span>SRN No</span> <?= $model->srn_no; ?></li>
                                    <?php endif; ?>
                                    <?php if (isset($model->company->name) && !empty($model->company->name)): ?>
                                        <li><span>Company</span> <?= $model->company->name; ?></li>
                                    <?php endif; ?>
                                    <?php if (isset($applicationStatus[$model->status]) && !empty($applicationStatus[$model->status])): ?>
                                        <li><span>Status</span> <?= $applicationStatus[$model->status]; ?></li>
                                    <?php endif; ?>
                                    <?php if (isset($model->dh_id) && !empty($model->dh_id) && !\Yii::$app->user->hasCallCenterRole()): ?>
                                        <li><span>Dealing Head</span> <?= isset($model->dh_id) && !empty($model->dh_id) ? $model->dh->name : '-'; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->srn_no)): ?> 
                                        <li><span>Name</span><?= $model->applicant_name; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_std_code)): ?> 
                                        <li><span>Std Code</span> <?= $model->applicant_std_code; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_mobile)): ?> 
                                        <li><span>Phone</span> <?= $model->applicant_mobile; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_email)): ?> 
                                        <li><span>Email</span> <?= $model->applicant_email; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->requested_shares)): ?> 
                                        <li><span>Requested Shares</span> <?= $model->requested_shares; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->requested_nominal_share_amount)): ?> 
                                        <li><span>Requested Nomial Share Amount</span> <?= $model->requested_nominal_share_amount; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->requested_total_amount)): ?> 
                                        <li><span>Requested total amount</span> <?= $model->requested_total_amount; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->security_depository_type)): ?> 
                                        <li><span>Security Depository Type</span> <?= $model->security_depository_type; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->rack_no)): ?>
                                        <li><span>Rack No</span> <?= $model->rack_no; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->approved_amount)): ?> 
                                        <li><span>Approved Amount</span> <?= $model->approved_amount; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->approved_shares)): ?> 
                                        <li><span>Approved Shares</span> <?= $model->approved_shares; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->refund_amount)): ?> 
                                        <li><span>Refunded Amount</span> <?= $model->refund_amount; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->refund_shares)): ?> 
                                        <li><span>Refunded Shares</span> <?= $model->refund_shares; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->refund_amount_date)): ?> 
                                        <li><span>Refunded Amount Date</span> <?= $model->refund_amount_date; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->refund_share_date)): ?> 
                                        <li><span>Refunded Share Date</span> <?= $model->refund_share_date; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->approved_rejected_date)): ?> 
                                        <li><span>Approved Rejected Date</span> <?= $model->approved_rejected_date; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->transaction_number)): ?> 
                                        <li><span>Transaction Number</span> <?= $model->transaction_number; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->transaction_refund_date)): ?> 
                                        <li><span>Transaction Refund Date</span> <?= $model->transaction_refund_date; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_accountno)): ?> 
                                        <li><span>Applicant Account No</span> <?= $model->applicant_accountno; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_dmat_accountno)): ?> 
                                        <li><span>Applicant Dmat Account No</span> <?= $model->applicant_dmat_accountno; ?></li>
                                    <?php endif; ?>
                                    <?php if (!empty($model->applicant_address)): ?> 
                                        <li><span>Address</span><?= $model->applicant_address; ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </section>
                    <!--Basic view end-->
                    <?= $this->render('partials/_grievance-scan-review-log', ['scanreviewLogs' => $scanreviewModel]); ?>
                    <?= $this->render('partials/_grievance-log', ['grievanceLogs' => $grievanceLogs]); ?>
                    <?= $this->render('partials/_grievance-allocation', ['grievanceAssignLogs' => $grievanceAssignLogs]); ?>
                    <?= $this->render('partials/_grievance-cc-comment', ['comments' => $comments]); ?>
                    <section class="widget__wrapper">
                        <div class="section_head withLink section_head__accordian">
                            <h2><a href="javascript:;">Applicant Message Logs<i><!--plus icon--></i></a></h2>
                        </div>
                        <?= $this->render('partials/_grievance-message-log', ['dataProvider' => $applicantMessageLog]); ?>
                    </section>
                    <section class="widget__wrapper">
                        <div class="section_head withLink section_head__accordian">
                            <h2><a href="javascript:;">Company Message Logs<i><!--plus icon--></i></a></h2>
                        </div>
                        <?= $this->render('partials/_grievance-message-log', ['dataProvider' => $companyMessageLog]); ?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form section -->
<div id="newCommentModal"  class="modal modal__wrapper fade" tabindex="-1" role="dialog"  aria-labelledby="newCommentModal">

</div>
<div id="messageTemplateModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="messageTemplateModal">

</div>