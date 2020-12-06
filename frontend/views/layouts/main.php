<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="<?= Html::encode($this->title) ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <link rel="shortcut icon" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/favicon.svg" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <?php if (isset(\Yii::$app->params['applicationEnv']) && \Yii::$app->params['applicationEnv'] === 'PROD'): ?>
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/dist/deploy/output.min.css?rel=1550516101416" />
        <?php else: ?>
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/css/vendors.css" />
            <link type="text/css" rel="stylesheet" href="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/static/css/default.css" media="screen" />
        <?php endif; ?>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- Note: Some classes are adding in the body from JS so developer need to create a function in which page specific classes can be added on every page... -->
        <?= $this->render('partials/header.php') ?>
        <?= $content ?>

        <?= $this->render('partials/footer.php') ?>
        <?= $this->render('partials/scripts.php') ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
