<!-- Begin Core Plugins -->
<?php if (isset(\Yii::$app->params['applicationEnv']) && \Yii::$app->params['applicationEnv'] === 'PROD'): ?>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/frontend/dist/deploy/app.min.js?rel=1550044642400"></script>
<?php else: ?>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/newsticker/js/jquery.vticker-min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/slick/js/slick.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/plugins/fancybox/js/jquery.fancybox.js"></script>
<!-- End Core Plugins -->

<!-- Begin Page Level Plugins -->
<!-- End Page Level Plugins -->
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/frontend/static/js/app.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/location-cascade.js"></script>
<script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath']?>/dev/js/grievance/grievance.js"></script>
<?php endif;?>
<script type="text/javascript">
 var baseHttpPath = '<?=\yii\helpers\Url::base(\Yii::$app->params['httpProtocol'])?>';
 var staticPath = '<?=\Yii::$app->params['staticHttpPath']?>';
</script>