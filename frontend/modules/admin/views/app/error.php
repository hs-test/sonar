<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = components\Helper::htmlEncode($name);
$exceptionMessage = $exception->getMessage();
$messageToDisplay = empty($exceptionMessage) ? $message : $exceptionMessage;
?>
<!-- 
<div class="page-content-inner">
    <section class="container">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1><?= components\Helper::htmlEncode($this->title) ?></h1>
                    <div role="alert" class="alert alert-danger alert-dismissible fade in">
                        <h4 id="oh-snap-you-got-an-error">Oh snap! You got an error!</h4>
                        <p><?= nl2br($messageToDisplay) ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a class="button blue" href="<?=\Yii::$app->request->getBaseUrl()?>/<?=$this->context->module->id?>"><i class="fa fa-home"></i> Home</a>
                </div>
            </div>
        </div>
    </section>
</div>
-->

<div class="error__theme">
    <figure>
        <img src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/images/icons/error.svg" alt="icon" />
    </figure>
    <div class="error__theme-content">
        <h2><?= $exception->statusCode ?></h2>
        <p><?= nl2br($messageToDisplay) ?></p>
    </div>
</div>