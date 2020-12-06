<div class="page__bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section">
                    <h2 class="section__heading"><?= (isset($pageTitle)) ? $pageTitle : '' ?></h2>
                    <?php if (isset($createUrl) && !empty($createUrl)): ?>
                        <a href = "<?= $createUrl ?>" class="button blue small">Create</a>
                    <?php endif ?>
                    <?php if (isset($allowSubmenu) && $allowSubmenu): ?>
                        <a href="javascript:;" class="section__sub-link">More Menu<span class="icon fa fa-angle-down"></span></a>
                    <?php endif; ?>
                    <?php if (isset($showBackButton) && $showBackButton): ?>
                        <a href="javascript:history.go(-1)" class="section__sub-link"><span class="fa fa-angle-left"></span> Back</a>
                    <?php endif; ?>
                </div>
                <?php if (isset($allowSubmenu) && $allowSubmenu): ?>
                    <div class="sub-linking navigation-toggled">
                        <?php if (isset($this->params['submenu']) && count($this->params['submenu']) > 0): ?>
                            <ul class="sub-linking__navs">
                                <?php foreach ($this->params['submenu'] as $menu): ?>
                                    <?php if (isset($menu['visible']) && !empty($menu['visible']) && $menu['visible']): ?>
                                        <li class="sub-linking__navs--items">
                                            <a href = "<?= (isset($menu['route'])) ? yii\helpers\Url::toRoute([$menu['route']]) : 'javascript:;' ?>">
                                                <?php if (isset($menu['icon']) && !empty($menu['icon'])): ?>
                                                    <span class="sub-linking__navs--items--image">
                                                        <img src="<?= Yii::$app->params['staticHttpPath']?>/dist/images/icons/portal/analytics.svg" alt="image" class="img-responsive" />
                                                    </span>
                                                <?php endif; ?>
                                                <span class="sub-linking__navs--items--label"><?= ucfirst($menu['title']) ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>