
<div class="modal-dialog content__preview" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?= \Yii::t('admin', 'preview') ?></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page__highlight">
                        <span class="upper">Company Name</span>
                        <h2><?= $model['name']; ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="page__highlight">
                        <span class="upper">CIN No.</span>
                        <h2><?= $model['cin_no']; ?></h2>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>