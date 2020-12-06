<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$showName = TRUE;
if (\Yii::$app->user->hasCallCenterRole()) {
    $showName = FALSE;
}
?>
<section class="widget__wrapper">
    <div class="section_head withLink section_head__accordian">
        <h2><a href="javascript:;">SRN Status Logs<i><!--plus icon--></i></a></h2>
    </div>

    <?php Pjax::begin(['id' => 'DataList']) ?>
    <div class="table__structure has-margin-0">
        <div class="table-responsive grievancecomm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Taken By <br/>
                            <?= $showName ? 'Name/' : ''; ?> Role</th>
                        <th>Comment</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($grievanceLogs) && !empty($grievanceLogs)): ?>
                        <?php foreach ($grievanceLogs as $grievance): ?>
                            <tr>
                                <td><?= $grievance['date']; ?></td>
                                <td><?= $grievance['status']; ?></td>
                                <td><?= $showName ? (isset($grievance['username']) ? $grievance['username'] : 'N/A') . '/' : ''; ?>  <?= isset($grievance['role']) ? $grievance['role'] : 'N/A'; ?></td>
                                <td><?php
                                    if (!empty($grievance['comments'])) {
                                        $comments = json_decode($grievance['comments'], TRUE);
                                        //echo implode('<br>', $comments['comments']) . '<br>';
                                        foreach ($comments['comments'] as $key=>$comment):
                                            echo $key+1 .'. '.$comment;
                                            echo '<br>';  
                                            
                                        endforeach;
                                    }
                                    ?>
                                    <?php
                                    if (!empty($grievance['additional_comment'])):
                                        ?>
                                        <table class="commenttable">
                                            <tr>
                                                <td class="head">
                                                    <div class="headtext">Comment</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>1.
                                                        <?= $grievance['additional_comment']; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php if (isset($grievance['multipleComments']) && !empty($grievance['multipleComments'])): ?>
                                                <?php 
                                                $i=2;
                                                foreach ($grievance['multipleComments'] as $multipleComment): ?>
                                                    <tr>
                                                        <td>
                                                            <span><?=$i;?>.
                                                                <?= $multipleComment['comment']; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                $i++;
                                                endforeach; ?>
                                            <?php endif; ?>
                                        </table>
                                    <?php endif; ?>
                                </td>
                                <td><?= (!empty($grievance['description'])) ? ($grievance['description']) : '-'; ?></td>
                                <?php if (Yii::$app->user->hasDealingHeadRole()): ?>
                                    <td><a class="addMultipleComment" href="javascript:;" title="Add Comments" data-url="<?= Url::toRoute(['grievance/add-multiple-comment', 'id' => $grievance['id']]); ?>"><i class="fa fa-comments"></i></a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <td colspan="6"><div class="empty text-center">No results found.</div></td>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php Pjax::end() ?>

</section>

<div id="addMultipleCommentModel" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="addMultipleCommentModel">

</div>