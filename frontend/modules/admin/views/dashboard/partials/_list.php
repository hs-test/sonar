<div class="state__wise-data">
    <div id="" class="grid-view">
        <div class="table-responsive scrolling" tabindex="1">
            <table class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th><?= isset($grievanceList['tdhead']) && !empty($grievanceList['tdhead']) ? $grievanceList['tdhead'] : ''; ?></th>
                        <th>Total Grievances</th>
                        <th>Resolved Grievances</th>
                        <th>Ongoing Grievances</th>
                        <th>Pending Grievances</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($grievanceList['grievanceList']) && !empty($grievanceList['grievanceList'])): ?>
                        <?php
                        $i = 1;
                        foreach ($grievanceList['grievanceList'] as $grievance):
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $grievance['name']; ?></td>
                                <td><?= $grievance['totalRecords']; ?></td>
                                <td><?= $grievance['resolved']; ?></td>
                                <td><?= $grievance['ongoing']; ?></td>
                                <td><?= $grievance['pending']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    <?php else:?>
                     <tr><td colspan="6"><div class="empty text-center">No results found.</div></td></tr>
                    <?php  endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>