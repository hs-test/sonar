<?php

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?> | IEPF</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="apple-touch-icon" sizes="57x57" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/favicon/favicon-16x16.png">
        <?php if (isset(\Yii::$app->params['applicationEnv']) && \Yii::$app->params['applicationEnv'] === 'PROD'): ?>
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/dist/deploy/output.min.css?rel=<?=\Yii::$app->params['cacheBustTimestamp'];?>" />
        <?php else: ?>
            <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/css/vendor.css" />
            <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/css/prettify.css" />
            <link rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/dropzone/css/dropzone.css" />
            <link rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/toaster/toastr.css" />
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/multiselect-bootstrap/dist/css/bootstrap-select.min.css" />  
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/fancybox/dist/jquery.fancybox.min.css" />
            <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-daterangepicker/daterangepicker.css" />
            <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/css/default.css" media="screen" />
        <?php endif; ?>
        <?php $this->head() ?>
    </head>
    <body class="<?= isset($this->params['bodyClass']) ? $this->params['bodyClass'] : '' ?>">
        <?php $this->beginBody() ?>
        <section id="viewport">
            <div class="page-container">
                <?= (!\Yii::$app->user->isGuest) ? $this->render("partials/_sidebar.php") : "" ?>
                <div class="page__content-wrapper">
                    <div class="page__content-inner">
                        <!-- Begin Page Header Area -->
                        <?= $this->render('partials/_header.php') ?>
                        <!-- //End Page Header Area -->
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </section>
        <?= $this->render("partials/_scripts.php") ?> 
        <div id="globalLoader" style="display:none">
            <div class="loading__spinner"> 
                <div class="loader"> 
                    <span><img width="24" height="24" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/images/loading.svg"></span> 
                    <span class="text">Please wait ...</span> 
                </div> 
            </div>
            <div class="loading__spinner-overlay"></div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
