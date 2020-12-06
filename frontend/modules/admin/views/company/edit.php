
<?php
$this->title = 'Edit Company';
$this->registerJs('CompanyController.createUpdate();');
?>
<?= $this->render('/layouts/partials/_sub-navigation.php', ['pageTitle' => $this->title, 'allowSubmenu' => FALSE]) ?>

<div class="page-main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $this->render('/layouts/partials/flash-message.php') ?>
                <section class="widget__wrapper">
                    <?= $this->render('partials/_form', ['model' => $model]); ?>
                </section>
            </div>
        </div>
    </div>
</div>