<?php
use yii\helpers\Html;

?>
<!-- Right Side Bar Begin -->
<div class="rightSidebar__wrapper">
    <h3><a href="javascript:;">Important Links <span class="fa fa-angle-down"></span></a></h3> 
    <div class="rightSidebar__wrapper-content">  
        <ul>
            <li>
                <?= Html::a('About','/about') ?>
            </li>
            <li>
                <?= Html::a('Services','/services/solar-power') ?>
            </li>
            <li>
                <?= Html::a('Digital Village List','/digital-village-list') ?>
            </li>
            <li>
                <?= Html::a('Media','/media/gallery') ?>
            </li>
            <li>
                <?= Html::a('Contact Us','/connect/contact') ?>
            </li>
        </ul>  
    </div>                        
</div>
<!-- Right Side Bar End -->