<!-- /.modal-dialog -->
<div class="modal-dialog content__preview" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= \Yii::t('admin', 'Logs') ?></h4>
        </div>
        <div class="modal-body">
            <!--------company logs------->
            <div class="table__structure has-margin-0 hidett">
                <div class="table-responsive grievancecomm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Month </th>
                                <th>Allocated SRN</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($taregtLogs) && !empty($taregtLogs)): ?>
                                <?php foreach ($taregtLogs as $log): ?>
                                    <tr>
                                        <td><?= $log['year']; ?></td>
                                        <td><?= date("F", mktime(0, 0, 0, $log['month'], 10)); ?></td>
                                        <td><?= $log['allocated']; ?></td>
                                        <td><?= date("d-M-Y H:i:s", $log['created_on']); ?></td>
                                    </tr>
                                <?php endforeach; ?> 
                            <?php endif; ?> 
                        </tbody>
                    </table>
                </div>
            </div>
            <!----------end company logs------->
        </div>
    </div>
</div>
