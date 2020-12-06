<?php
$this->registerJs('GrievanceController.verifyOtp();');
?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <form id="form-verify-otp" action="/home/verify-otp" method="post">
        <div class="modal-content themeModal">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="modal-body">
                <div class="enterotpWrap">
                    <h3>Enter Oner Time Password (OTP)</h3>
                    <p>One Time Password(OTP) has been <br/> sent to your
                        mobile, Please enter the same here to login</p>

                    <div class="form-group">
                        <input type="text" id="otp" placeholder="OTP" class="form-control" name="otp" aria-required="true" required="required">
                        <input type="hidden" name="username" value="<?= $grievanceDetails['name']; ?>">
                        <input type="hidden" name="email" value="<?= isset($grievanceDetails['email']) && !empty($grievanceDetails['email']) ? $grievanceDetails['email'] : ''; ?>">
                        <input type="hidden" name="mobile" value="<?= $grievanceDetails['mobile']; ?>">
                        <p class="help-block help-block-error" id="error-message"></p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="filter__wrapper-form">
                    <button type="button" class="button reset theme__btn" data-dismiss="modal">Close</button>
                    <button   id="verify-otp" class="button theme__btn">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>