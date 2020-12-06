<?php
$title = 'Financial Year';
$this->title = $title;
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title]) ?>
<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $this->render('/layouts/partials/flash-message.php') ?>
                <section class="widget__wrapper">
                    <?= $this->render('/financial-year/partials/_form.php', ['model' => $model]) ?>
                </section>
            </div>
        </div>
    </div>
</div>