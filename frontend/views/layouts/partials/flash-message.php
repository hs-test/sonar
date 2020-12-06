<?php
/**
 * @link http://www.ideoris.com.au
 * @copyright Copyright (c) 2016 Ideoris Pty Ltd.
 * @license http://www.yiiframework.com/license/
 * @version flash-message.php $26-04-2016 12:35:53$
 * 
 * @author Pawan Kumar <info@ideoris.com.au>
 */
?>
<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <?php if(is_array($message)): ?>
        <?php foreach($message as $msg): ?>
            <div class="alert <?=($msg['type'] === 'success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible in" role="alert">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                <p><?= $msg['text'] ?></p>
            </div>
        <?php endforeach;?>
    <?php else: ?>
    <div class="alert <?=($key === 'success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible in theme_alert" role="alert">
        <button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
        <p><?= $message ?></p>
    </div>
    <?php endif;?>
<?php endforeach; ?>
                        




