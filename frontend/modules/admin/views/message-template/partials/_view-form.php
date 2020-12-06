
<div class="modal-dialog content__preview" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= \Yii::t('admin', 'Template') ?></h4>
        </div>
        <div class="modal-body">
            <?= $model['template']; ?>
        </div>
    </div>
</div>

