<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['admin/auth/reset-password', 'token' => $password_reset_token]);
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" style="color:#898989;font-family: Droid Serif, Source Sans Pro, Arial, sans-serif; font-size: 18px; line-height:22px; font-weight: normal;" class="contentsTable">
    <tr>
        <td colspan="2" style="padding-bottom: 40px; font-family: Droid Serif, Source Sans Pro, Arial, sans-serif; font-size: 24px; line-height: 29px; font-weight: normal; color:#383b40; text-align: left;" class="heading">Reset your password</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: left; font-family: Droid Serif, Source Sans Pro, Arial, sans-serif; color:#383b40; text-align: left;">
            Forgot your password? Don't worry. We've all been there.
            <br><br>
            Click on this link to reset it.
            <br><br>
            <a style="color:#13b99d;" href="<?php echo $resetLink; ?>" target="_blank">CHANGE PASSWORD</a>
            <br><br>
            Once you have logged back in you can change your password to something you can easily remember.
            <br><br>
            If you didn't ask to change your password, just ignore this email, and no changes will be made to your account.
        </td>
    </tr>
</table>