<?php
$userRole = Yii::$app->user->identity->role_id;
?>
<aside class="page__sidebar hidden-print">
    <div class="page__sidebar-wrapper navbar-collapse">
        <div class="page__sidebar--logo">
            <figure>

            </figure>
        </div>
        <div class="page__sidebar-standaloneNav">
            <ul class="page__sidebar-standaloneNav-listing">
                <?php foreach (Yii::$app->params['adminSidebar'] as $key => $sidebar): ?>
                    <?php
                    if (isset($sidebar['isHidden']) && $sidebar['isHidden']) {
                        continue;
                    }

                    $isActive = FALSE;
                    if (Yii::$app->params['activeMenu'] == $key) {
                        $isActive = TRUE;
                    }


                    if (isset($sidebar['allowedRoles']) && !Yii::$app->user->hasAdminRole()) {

                        if (is_array($sidebar['allowedRoles'])) {
                            if (!in_array($userRole, $sidebar['allowedRoles'])) {
                                continue;
                            }
                        }
                        else {
                            if ($sidebar['allowedRoles'] === $userRole) {
                                continue;
                            }
                        }
                    }
                    ?>
                    <li class="<?= ($isActive) ? 'active' : '' ?>">
                        <a href="<?= $sidebar['routeUrl'] ?>">
                            <i class="<?= $sidebar['iconClass'] ?>"></i>
                            <span class="title"><?= $sidebar['text'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</aside>
<!-- Begin Responsive Profile -->
<div class="responsive-standalone">
    <a href="javascript:;" class="responsive-standalone-close"><span class="close-text">Close</span><span class="fa fa-close" aria-hidden="true"></span></a>
    <div class="standalone-menu"></div>
</div>
<div class="responsive-standalone-overlay"></div>
<!-- //End Responsive Profile -->