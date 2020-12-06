
<?=
    yii\widgets\Breadcrumbs::widget([
        'options' => [
            'class' => 'breadcrumb',
        ],
        'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
        'homeLink' => [
            'label' => '<i class="fa fa-home"></i>',
            'url' => Yii::$app->homeUrl,
            'encode' => false// Requested feature
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
?>
