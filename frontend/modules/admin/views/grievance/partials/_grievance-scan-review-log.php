<?php
//echo '<pre>';print_r($scanreviewLogs);die;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<section class="widget__wrapper">
    <div class="section_head withLink section_head__accordian">
        <h2><a href="javascript:;">SRN Scan/Review Logs<i><!--plus icon--></i></a></h2>
    </div>

    <?php Pjax::begin(['id' => 'DataList']) ?>
    <div class="table__structure has-margin-0">
        <div class="table-responsive grievancecomm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Reason</th>
                        <th>Comment</th>
                        <th>Created By</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($scanreviewLogs) && !empty($scanreviewLogs)): ?>
                        <?php foreach ($scanreviewLogs as $scanreviewLog): ?>
                            <tr>
                                <td><?= $scanreviewLog['date']; ?></td>
                                <td><?= $scanreviewLog['type']; ?></td>
                                <td><?php
                                    if (!empty($scanreviewLog['reason'])) {
                                        $comments = json_decode($scanreviewLog['reason'], TRUE);
                                        //echo implode('<br>', $comments['comments']) . '<br>';
                                        foreach ($comments['comments'] as $key => $comment):
                                            echo $key + 1 . '. ' . $comment;
                                            echo '<br>';

                                        endforeach;
                                    }
                                    ?>
                                </td>
                                <td><?= isset($scanreviewLog['comment']) && !empty($scanreviewLog['comment']) ? $scanreviewLog['comment'] : '-'; ?></td>
                                <td><?= (isset($scanreviewLog['name']) ? $scanreviewLog['name'] : 'N/A') . '/' ?>  <?= isset($scanreviewLog['roleName']) ? $scanreviewLog['roleName'] : 'N/A'; ?></td>
                                <td><?= date('Y-m-d', $scanreviewLog['created_on']); ?></td>
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
