<?php
$userLocation = \common\models\UserLocation::findByUserId($model->id, [
            'selectCols' => [
                'user_location.*', 'state.name As stateName', 'district.name As districtName'
            ],
            'joinState' => 'leftJoin',
            'joinDistrict' => 'leftJoin',
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
        ]);

$showDistrict = true;
if (yii\helpers\ArrayHelper::isIn($model->role_id, [\common\models\User::ROLE_CPM, \common\models\User::ROLE_STATE_USER, \common\models\User::ROLE_RAC_NODAL_OFFICER])) {
    $showDistrict = false;
}

$userStates = [];
if (yii\helpers\ArrayHelper::isIn($model->role_id, [\common\models\User::ROLE_DISCOM_MANAGER, \common\models\User::ROLE_DISCOM_NODAL_OFFICER])) {

    $user = common\models\User::findById($model->id);

    $selectedState = \common\models\UserLocation::findByUserId($user['parent_id'], ['resultCount' => common\models\caching\ModelCache::RETURN_ALL]);
    $userStates['inStateCode'] = \yii\helpers\ArrayHelper::getColumn($selectedState, 'state_code');
}

$states = common\models\State::getStateList(NULL, FALSE, $userStates);

$districts = common\models\District::getDistrictList();
?>
<div class="row has-margin-bottom-30 locationBlock">

    <div class="col-md-4 col-xs-6 ">
        <label>Select State</label>
        <select class="chzn-select state" name="state">
            <option value="">Select State</option>
            <?php foreach ($states as $code => $state): ?> 
                <option value="<?= $code ?>"><?= $state ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php if ($showDistrict): ?>
        <div class="col-md-4 col-xs-6">
            <label>Select District</label>
            <select class="chzn-select district" name="district">
                <option value="">Select District</option>
            </select>
        </div>
    <?php endif; ?>
    <div class="col-md-4 col-xs-6">
        <a href="javascript:;" class="button blue has-margin-top-30 small addLocation" data-cls="locationBlock">Add</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <table class="table table-bordered <?= empty($userLocation) ? 'hide' : '' ?>" id="locationTable">
            <thead>
            <th class="text-center">#</th>
            <th class="text-center">State</th>
            <th class="text-center <?= (!$showDistrict) ? 'hide' : '' ?>">District</th>
            <th class="text-center">Action</th>
            </thead>
            <tbody class="text-center stateUserPermission">
                <?php if (!empty($userLocation)): ?>
                    <?php
                    $i = 0;
                    foreach ($userLocation as $loc):
                        ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= ucfirst($loc['stateName']) ?></td>
                            <td class="<?= (!$showDistrict) ? 'hide' : '' ?>"><?= ucfirst($loc['districtName']) ?></td>
                            <td><a href="javascript:void(0)" class="revokePermission icons icons__delete" data-id="<?= $loc['id'] ?>"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?> 
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>