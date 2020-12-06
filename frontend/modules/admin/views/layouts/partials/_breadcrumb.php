<aside class="section section__left">
    <h2 class="section__heading upper"><?=  (isset($pageTitle)) ? $pageTitle : ''?></h2>
    <?=
    yii\widgets\Breadcrumbs::widget([
        'options' => [
            'class' => 'page__bar-breadcrumb',
        ],
        'itemTemplate' => "<li class=''>{link}</li>\n",
        'homeLink' => [
            'label' => '<i class="fa fa-home"></i>',
            'url' => Yii::$app->homeUrl,
            'encode' => false// Requested feature
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
</aside>
