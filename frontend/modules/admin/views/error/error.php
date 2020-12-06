<?php
$this->title = $name;

$exceptionMessage = $exception->getMessage();
$messageToDisplay = empty($exceptionMessage) ? $message : $exceptionMessage;
?>
<div class="error__theme">
    <figure>
        <img src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/error.svg" alt="icon" />
    </figure>
    <div class="error__theme-content">
        <h2><?= $exception->statusCode ?></h2>
        <p><?= nl2br($messageToDisplay) ?></p>
    </div>
</div>