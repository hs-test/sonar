<?php

use yii\helpers\Html;
?>
<div class="modal-dialog" role="document">
    <?= Html::beginForm(['grievance/reassign'], 'post', ['id' => 'reassignedForm']); ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><i class="fa fa-edit"> </i> Reassigned Grievances</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="application-status">Dealing Head</label>
                        <?= Html::dropDownList('dealing_head', '', $userList, ['class' => 'chzn-select dealingHead']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            
            <?= Html::submitButton('Reassigned', ['class' => 'button blue small reassignedSubmitBtn']); ?>
        </div>
    </div>
    <?= Html::endForm(); ?>
</div>