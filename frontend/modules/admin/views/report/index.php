<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = (isset($title)) ? $title : 'Report';
?>
<?= $this->render('partials/_sub-menu.php', ['mis' => TRUE]) ?>
<?= $this->render('partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => TRUE]) ?>