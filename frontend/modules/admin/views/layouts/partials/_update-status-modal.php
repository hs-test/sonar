<div id="updateStatusModal_OLD" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="updateStatusModal">
    <div class="modal-dialog" role="document">
        <form enctype="multipart/form-data" id="grievanceUpdateForm">
            <input type="hidden" name="grievanceId" id="grievanceId"/>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-edit"> </i> Update Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="application-status">Application Status</label>
                                <select name="application_status" class="chzn-select applicationStatus">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="date">Date</label>
                                <input name="date" class="form-control grievanceDate" data-guid="0" autocomplete ='off'>
                            </div>
                        </div>
                    </div>
                    <div class="row has-margin-top-20">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="description">Description</label>
                                <input name="description" class="form-control description" autocomplete ='off' readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="grievanceModel"></div>
                <div class="modal-footer">
                    <button class="button blue small statusSubmitBtn"><i class="fa fa-edit"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>