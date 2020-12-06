<div class="modal-dialog content__preview" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= \Yii::t('admin', 'Message') ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-xs-12  ">
                    <div class="page__highlight">
                        <span class="upper">Message</span>
                        <?php if (!empty($model)): ?>
                            <h2><?= isset($model['message']) ? $model['message'] : '-'; ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>