
<div class="modal-dialog content__preview" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> <?=\Yii::t('admin','preview')?></h4>
        </div>
        <div class="modal-body">
            <div class="page__highlight">
                <span class="upper">Title</span>
                <h2><?= $model->title?></h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="page__highlight">
                        <span class="upper">External Url</span>
                        <h2><?= $model->external_url ?></h2>
                    </div>
                </div>
                
            </div>
            <p class="text-justify"><?= $model->content ?></p>
        </div>
        <div class="modal-footer text-center accordian__view">
            <div class="footerSection">
                <ul>
                    <li class="user">
                        <i class="fa fa-user"></i>
                        <span><?= (isset($model->posted_by)) ? ucwords($model->postedBy->firstname.' '.$model->postedBy->lastname) : '' ?></span>
                    </li>
                    <li class="date">
                        <i class="fa fa-calendar"></i>
                        <span><?= date('d M Y', ($model->created_at)) ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>