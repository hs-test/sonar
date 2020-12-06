<?php
$showName = TRUE;
if (\Yii::$app->user->hasCallCenterRole()) {
    $showName = FALSE;
}
?>
<section class="widget__wrapper">
    <div class="section_head withLink section_head__accordian">
        <h2><a href="javascript:;">SRN Allocation Logs<i><!--plus icon--></i></a></h2>
    </div>
    <div class="table__structure has-margin-0">
        <div class="table-responsive grievancecomm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Assigned By /Role</th>
                        <th>Previous Dealing Head</th>
                        <th>New Dealing Head</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($grievanceAssignLogs) && !empty($grievanceAssignLogs)): ?>
                        <?php foreach ($grievanceAssignLogs as $grievanceAssign): ?>
                            <tr>
                                <td><?= $grievanceAssign['date']; ?></td>
                                <td><?= $showName ? $grievanceAssign['assignedBy'] . '/' : '' . $grievanceAssign['role']; ?></td>
                                <td><?= $showName ? $grievanceAssign['previousDealingHead'] : ''; ?></td>
                                <td><?= $showName ? $grievanceAssign['newDealingHead'] : ''; ?></td>
                            </tr>
                        <?php endforeach; ?> 
                    <?php else: ?>
                    <td colspan="6"><div class="empty text-center">No results found.</div></td>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>