
<!-- Begin Core Plugins -->
<?php if (isset(\Yii::$app->params['applicationEnv']) && \Yii::$app->params['applicationEnv'] === 'PROD'): ?>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/deploy/app.min.js?rel=<?=\Yii::$app->params['cacheBustTimestamp'];?>"></script>
<?php else: ?>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/moment.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/scripts.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/prettify.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/jscolor.js"></script>

    <!-- End Page Level Plugins -->
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/app.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-modal.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-modalmanager.js"></script>
    <!-- End Core Plugins -->

    <!-- Begin Page Level Plugins -->
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/chosen-bootstrap/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/jquery.switchery/js/switchery.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/jquery.nicescroll/js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/multiselect-bootstrap/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/multi-select-combo-Box/jquery.selectlistactions.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/bootbox.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/jquery.noty-2.3.8/js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/jquery.tipped/js/tipped.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/dropzone/dropzone.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/owlcarousel/js/owl.carousel.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/handlebars-v4.0.5.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/toaster/toastr.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/vendors/map-responsive/js/jquery.rwdImageMaps.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/waypoints.min.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dist/js/jquery.counterup.min.js"></script>

    <!-- Page Level JS -->
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/common.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/app.js"></script>
    
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/location.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/user.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/flash-message.js"></script>

    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/common/upload-file.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/page/page.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/slider/slider.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/module/module.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/news/news.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/grievance/grievance.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/company/company.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/listtype/listtype.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/financialyear/financial_year.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/common/discom.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/message-template/message-template.js"></script>

    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/location-cascade.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/state.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/district.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/block.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/panchayat.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/location/village.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/type/type.js"></script>

    <script type="text/javascript" src="<?= Yii::$app->params['staticHttpPath'] ?>/dev/js/dashboard/dashboard.js"></script>
    <script type="text/javascript" src="<?= \Yii::$app->params['staticHttpPath'] ?>/dev/js/common/templates.js"></script>

<?php endif; ?>
<script type="text/javascript">
    var baseHttpPath = '<?= \yii\helpers\Url::base(\Yii::$app->params['httpProtocol']) ?>/admin';
    var staticPath = '<?= \Yii::$app->params['staticHttpPath'] ?>';
    var allowedImageExtension = '<?= \Yii::$app->params['image.extension'] ?>';
    var allowedFileExtension = '<?= \Yii::$app->params['file.extension'] ?>';
    window.CKEDITOR_BASEPATH = '<?= Yii::$app->params['staticHttpPath'] ?>/dist/vendors/ckeditor/';
    var userRole = '<?=(isset(Yii::$app->user->identity->role_id) ? Yii::$app->user->identity->role_id : '');?>';
</script>
