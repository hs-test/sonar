<!-- End Page Navigation section -->
<div class="<?= (isset($allowSubmenu) && $allowSubmenu) ? 'page__navigation' : 'page__bar' ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12"> 
                <?php if (isset($allowSubmenu) && $allowSubmenu): ?>
                    <nav class="navbar">
                        <ul class="nav navbar-nav">
                            <?php foreach ($this->params['submenu'] as $menu): ?>
                                <?php if (isset($menu['visible']) && $menu['visible']): ?>
                                    <li class="<?= (isset($menu['active']) && $menu['active']) ? 'active' : '' ?>"><a href="<?= $menu['route'] ?>"><?= $menu['title'] ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php else: ?> 
                    <div class="section">
                        <h2 class="section__heading"><?= (isset($pageTitle)) ? $pageTitle : '' ?></h2>
                        <?php if (isset($showBackButton) && $showBackButton): ?>
                            <a href="javascript:history.go(-1)" class="section__sub-link">Back</a>
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>