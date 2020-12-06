<?php
$this->title = ($model->id > 0) ? 'Edit Type' : 'Add Type';
$this->registerJs('GrievanceController.createUpdate();');
?>
<div class="page-main-content">
    <section class="container" id="classContainer">
        <div class="content-wrap">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('/layouts/partials/flash-message.php') ?>
                    <?= $this->render('/type/partials/form', ['model' => $model]); ?>
                </div> 
            </div>
        </div>
    </section>
</div>
