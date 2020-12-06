<?php
$userStates = [];
$userDistrict = [];
$executiveList = [];

$discomList = common\models\Discom::getDiscomList();
$executiveParams = [
    'selectCols' => ['id', 'name'],
    'resultCount' => 'all',
    'status' => common\models\User::STATUS_ACTIVE
];
$executiveModel = common\models\User::findByRoleId(common\models\User::ROLE_CALLCENTER_EXECUTIVE, $executiveParams);
if (isset($executiveModel) && !empty($executiveModel)) {
    foreach ($executiveModel as $executive) {
        $executiveList[$executive['id']] = $executive['name'];
    }
}

$userId = Yii::$app->user->id;
$userParams = [
    'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
];
$userLocation = \common\models\UserLocation::findByUserId($userId, $userParams);
if (!empty($userLocation)) {
    $userStates = \yii\helpers\ArrayHelper::getColumn($userLocation, 'state_code');
    $userDistrict = \yii\helpers\ArrayHelper::getColumn($userLocation, 'district_code');
}

$stateCode = null;
if (isset($searchModel->state_code) && !empty($searchModel->state_code)) {
    $stateCode = $searchModel->state_code;
}
$stateList = \common\models\State::getStateList($stateCode);

$districtList = [];
if (!empty($searchModel->state_code)) {
    $districtList = common\models\District::getDistrictList($searchModel->state_code);
}

$villageList = [];
if (!empty($searchModel->district_code)) {
    $villageList = common\models\Village::getVillageList($searchModel->district_code);
}

if (Yii::$app->user->hasCPMRole() || Yii::$app->user->hasRecNodalCenterRole() || Yii::$app->user->hasStateUserRole()) {
    $flipped = array_flip($userStates);
    $stateList = array_intersect_key($stateList, $flipped);
}

if (Yii::$app->user->hasDiscomMDRole() || Yii::$app->user->hasDiscomNodalOfficerRole() || Yii::$app->user->hasDiscomOfficerRole()) {
    $flipped = array_flip($userStates);
    $stateList = array_intersect_key($stateList, $flipped);

    $flipedDistrict = array_flip($userDistrict);
    $districtList = array_intersect_key($districtList, $flipedDistrict);
}

$form = \yii\bootstrap\ActiveForm::begin([
            'id' => 'SearchForm',
            'method' => 'GET',
        ]);
?>
<div class="filter__wrapper">
    <form>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <?=
                        $form->field($searchModel, 'state_code', [
                            'template' => "{label}\n{input}\n{hint}\n{error}",
                        ])
                        ->dropDownList($stateList, ['class' => 'chzn-select',
                            'prompt' => 'Select State',
                            'data-search' => '1',
                            'data-parent' => 'state',
                            'data-child-class' => 'districtCascadeMain'
                                ]
                        )->label(false)
                ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <select id="" class="chzn-select" name="" data-search="1" data-parent="state" data-child-class="" style="display: none;">
                        <option value="">Select Discom</option>
                        <option value="5">Andaman &amp; Nicobar Island</option>
                        <option value="6">Andhra Pradesh</option>
                        <option value="7">Arunachal Pradesh</option>
                        <option value="8">Assam</option>
                        <option value="9">Bihar</option>
                        <option value="10">Chandigarh</option>
                        <option value="11">Chhattisgarh</option>
                        <option value="12">Dadara &amp; Nagar Havelli</option>
                        <option value="13">Daman &amp; Diu</option>
                        <option value="14">Goa</option>
                        <option value="15">Gujarat</option>
                        <option value="16">Haryana</option>
                        <option value="17">Himachal Pradesh</option>
                        <option value="18">Jammu &amp; Kashmir</option>
                        <option value="19">Jharkhand</option>
                        <option value="20">Karnataka</option>
                        <option value="21">Kerala</option>
                        <option value="22">Lakshadweep</option>
                        <option value="23">Madhya Pradesh</option>
                        <option value="24">Maharashtra</option>
                        <option value="25">Manipur</option>
                        <option value="26">Meghalaya</option>
                        <option value="27">Mizoram</option>
                        <option value="28">Nagaland</option>
                        <option value="29">NCT Of Delhi</option>
                        <option value="30">Odisha</option>
                        <option value="31">Puducherry</option>
                        <option value="32">Punjab</option>
                        <option value="33">Rajasthan</option>
                        <option value="34">Sikkim</option>
                        <option value="35">Tamil Nadu</option>
                        <option value="36">Telangana</option>
                        <option value="37">Tripura</option>
                        <option value="38">Uttar Pradesh</option>
                        <option value="39">Uttarakhand</option>
                        <option value="40">West Bengal</option>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <select id="" class="chzn-select" name="" data-search="1" data-parent="state" data-child-class="" style="display: none;">
                        <option value="">Select Districts</option>
                        <option value="5">Andaman &amp; Nicobar Island</option>
                        <option value="6">Andhra Pradesh</option>
                        <option value="7">Arunachal Pradesh</option>
                        <option value="8">Assam</option>
                        <option value="9">Bihar</option>
                        <option value="10">Chandigarh</option>
                        <option value="11">Chhattisgarh</option>
                        <option value="12">Dadara &amp; Nagar Havelli</option>
                        <option value="13">Daman &amp; Diu</option>
                        <option value="14">Goa</option>
                        <option value="15">Gujarat</option>
                        <option value="16">Haryana</option>
                        <option value="17">Himachal Pradesh</option>
                        <option value="18">Jammu &amp; Kashmir</option>
                        <option value="19">Jharkhand</option>
                        <option value="20">Karnataka</option>
                        <option value="21">Kerala</option>
                        <option value="22">Lakshadweep</option>
                        <option value="23">Madhya Pradesh</option>
                        <option value="24">Maharashtra</option>
                        <option value="25">Manipur</option>
                        <option value="26">Meghalaya</option>
                        <option value="27">Mizoram</option>
                        <option value="28">Nagaland</option>
                        <option value="29">NCT Of Delhi</option>
                        <option value="30">Odisha</option>
                        <option value="31">Puducherry</option>
                        <option value="32">Punjab</option>
                        <option value="33">Rajasthan</option>
                        <option value="34">Sikkim</option>
                        <option value="35">Tamil Nadu</option>
                        <option value="36">Telangana</option>
                        <option value="37">Tripura</option>
                        <option value="38">Uttar Pradesh</option>
                        <option value="39">Uttarakhand</option>
                        <option value="40">West Bengal</option>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="action-button">
                    <button type="submit" class="button blue small">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>