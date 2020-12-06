<?php
$showDate = TRUE;
$showStatus = TRUE;
$searchByLogs = TRUE;

$dealingHeadList = [];
$userParams = [
    'selectCols' => ['id', 'name'],
    'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
];
if (\Yii::$app->user->hasDealingHeadRole()) {
    $userParams['userNotIn'] = \Yii::$app->user->id;
}
$dealingHead = \common\models\User::findByRoleId(\common\models\User::ROLE_DEALING_HEAD, $userParams);

if (!empty($dealingHead)) {
    foreach ($dealingHead as $user) {
        $dealingHeadList[$user['id']] = $user['name'];
    }
}

if (Yii::$app->user->hasCallCenterRole() || Yii::$app->user->hasCallCenterSupervisor()) {
    $showDate = FALSE;
    $showStatus = FALSE;
    $searchByLogs = FALSE;
}
$applicationStatus = common\models\Grievance::getGrievanceStatusArr(NULL, TRUE);
if (\Yii::$app->user->hasDealingHeadRole()) {
    $applicationStatus = [

        \common\models\Grievance::VR_ASSIGNED => 'FRESH CLAIM PENDING',
        \common\models\Grievance::DR_ASSIGNED => 'RESUBMITTED PENDING',
        \common\models\Grievance::APPROVED => 'APPROVED',
        \common\models\Grievance::REJECTED => 'REJECTED',
        \common\models\Grievance::PAID => 'PAID',
        \common\models\Grievance::UNDER_PROCESS => 'UNDER PROCESS',
        \common\models\Grievance::DISCREPANCY => 'SENT FOR RESUBMISSION',
    ];
}
else if (\Yii::$app->user->hasAccountManagerRole()) {
    $applicationStatus = [
        \common\models\Grievance::APPROVED => 'APPROVED',
    ];
}
else if (\Yii::$app->user->hasDispatchExecuitveRole()) {
    $applicationStatus = [
        \common\models\Grievance::PENDING => 'VR NOT RECEIVED',
        \common\models\Grievance::VR_ASSIGNED => 'FRESH CLAIM PENDING',
        \common\models\Grievance::DR_ASSIGNED => 'RESUBMITTED PENDING',
        \common\models\Grievance::DISCREPANCY => 'SENT FOR RESUBMISSION',
    ];
}

$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'SearchForm',
            'method' => 'GET',
        ]);
?>
<div class="filters-wrapper">
    <ul>
        <?php if ($showDate): ?>
            <li>
                <?=
                $form->field($searchModel, 'fromDate')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control fromDatePicker',
                    'placeholder' => \Yii::t('admin', 'From date')
                ])->label(false)
                ?>
            </li>
            <li>
                <?=
                $form->field($searchModel, 'toDate')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control toDatePicker',
                    'placeholder' => \Yii::t('admin', 'To date')
                ])->label(false)
                ?>
            </li>
        <?php endif; ?>
        <?php if ($searchByLogs): ?>
            <li>
                <?=
                        $form->field($searchModel, 'searchByLogs', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList(['' => 'Select'] + [1 => 'Search by current status', 2 => 'Search by activity log status'], ['class' => 'chzn-select'
                                ]
                        )->label(false)
                ?>
            </li>
        <?php endif; ?>
        <?php if ($showStatus): ?>
            <li>
                <?=
                        $form->field($searchModel, 'grievanceStatus', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList(['' => 'Select Status'] + $applicationStatus, ['class' => 'chzn-select'
                                ]
                        )->label(false)
                ?>
            </li>
        <?php endif; ?>
    </ul>
    <ul>
        <li>
            <?=
            $form->field($searchModel, 'trakingId')->textInput([
                'autofocus' => false,
                'autocomplete' => 'off',
                'placeholder' => 'Tracking Id'
            ])->label(false)
            ?>
        </li>
        <?php if (!\Yii::$app->user->hasCallCenterRole()): ?>
            <li>
                <?=
                        $form->field($searchModel, 'dealingHead', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList(['' => 'Select Dealing Head'] + $dealingHeadList, ['class' => 'chzn-select'
                                ]
                        )->label(false)
                ?>
            </li>
        <?php endif; ?>
     
        <?php if (\Yii::$app->user->hasAdminRole()): ?>
             <li>
                <?=
                        $form->field($searchModel, 'searchByType', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList(['' => 'Filter date by review/scan status'] + [1 => 'Filter date by review status', 2 => 'Filter date by scan status'], ['class' => 'chzn-select'
                                ]
                        )->label(false)
                ?>
            </li>
            
            <li>
                <?=
                $form->field($searchModel, 'scanreviewfromDate')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control fromDatePicker',
                    'placeholder' => \Yii::t('admin', 'Scan/Reivew From date')
                ])->label(false)
                ?>
            </li>
            <li>
                <?=
                $form->field($searchModel, 'scanreviewtoDate')->textInput([
                    'autofocus' => false,
                    'autocomplete' => 'off',
                    'class' => 'form-control toDatePicker',
                    'placeholder' => \Yii::t('admin', 'Scan/Reivew To date')
                ])->label(false)
                ?>
            </li>
             <li>
                <?=
                        $form->field($searchModel, 'is_scan', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList([1 => 'Yes', 0 => 'No'], ['class' => 'chzn-select', 'prompt' => 'Is Scan'
                                ]
                        )->label(false)
                ?>
            </li>
            <li>
                <?=
                        $form->field($searchModel, 'is_review', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList([1 => 'Yes', 0 => 'No'], ['class' => 'chzn-select', 'prompt' => 'Is Review'
                                ]
                        )->label(false)
                ?>
            </li>
           
        <?php endif; ?>
        <li>
            <?=
            $form->field($searchModel, 'search')->textInput([
                'autofocus' => false,
                'autocomplete' => 'off',
                'placeholder' => 'Search by Company, CIN No , SRN No , Applicant Name'
            ])->label(false)
            ?>
        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::submitButton('Search', ['class' => 'button blue small', 'type' => 'submit']) ?>
        </li>
        <li class="action-button">
            <?= \yii\helpers\Html::button('Reset', ['class' => 'button blue small resetForm', 'type' => 'button']) ?>
        </li>
    </ul>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>