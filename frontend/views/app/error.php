<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = components\Helper::htmlEncode($name);
$exceptionMessage = $exception->getMessage();
$messageToDisplay = empty($exceptionMessage) ? $message : $exceptionMessage;
?>
<div class="inner-body">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <figure>
                    <img src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/error.svg" alt="icon" />
                </figure>
                <div class="section-head">
                    <h3 class="title">Page Not Found</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>