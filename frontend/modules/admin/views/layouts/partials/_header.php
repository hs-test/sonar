<div class="pageHeader hidden-print">
    <div class="pageHeader__inner">
        <div class="open-menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="item-1"></span>
            <span class="item-2"></span>
            <span class="item-3"></span>
        </div>
        <div class="skew-menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="item-1"></span>
            <span class="item-2"></span>
            <span class="item-3"></span>
        </div>
        <div class="pageHeader__inner-logo">
            <a href="/admin">IEPF</a>
        </div>
        <?php if (!\Yii::$app->user->isGuest): ?>
            <div class="pageHeader__inner-top-menu">
                <ul>
                    <li class="settings">
                        <a href="<?= \yii\helpers\Url::toRoute(['user/profile', 'guid' => \Yii::$app->user->identity->guid]) ?>"><span class="settings--text"><?=\Yii::$app->user->identity->name;?></span></a>
                    </li><li>
                        <a href="<?= yii\helpers\Url::toRoute(['auth/logout']) ?>" class=""><i class="fa fa-power-off"></i></a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>