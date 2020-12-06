<?php
$logs = explode('#', unserialize(base64_decode($model['logs'])));
$companyLogs = isset($model['company_logs']) && !empty($model['company_logs']) ? unserialize(base64_decode($model['company_logs'])) : [];
?>
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
            <div class="row">
                <div class="col-sm-12 col-xs-12  ">
                    <div class="page__highlight">
                        <span class="upper">General Logs</span>
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): ?>
                                <h2><?= $log; ?></h2>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--------company logs------->
            <?php if (!empty($companyLogs)): ?>
                <div class="row">
                    <div class="col-sm-12 col-xs-12  ">
                        <div class="page__highlight">
                            <span class="upper">Company Logs</span>
                        </div>
                    </div>
                </div>
                <?php foreach ($companyLogs as $status => $data): ?>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="page__highlight">
                                <span class="upper"></span>
                                <h2><?= $status; ?></h2>
                            </div>
                            <?php foreach ($data as $value): ?>
                                <div class="page__highlight">
                                    <span class="upper"></span>
                                    <h2><?= 'Row -' . $value['row']; ?></h2>
                                    <div><ul><li><?= $value['name']; ?></li></ul></div>
                                    <?php if ($status == 'UPDATED'): ?>
                                        <div><ul><li><?= 'Old -' . $value['name']; ?></li></ul></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <!----------end company logs------->
        </div>
    </div>
</div>
