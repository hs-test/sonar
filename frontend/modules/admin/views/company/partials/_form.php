<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;


$depository = ['NSDL' => 'NSDL', 'CDSL' => 'CDSL'];
if (isset($model->id) && $model->id > 0) {
    $userInfo = [];
    $params = [
        'selectCols' => ['company_detail.id', 'company_detail.contact_person', 'company_detail.email', 'company_detail.address'],
        'resultCount' => common\models\caching\ModelCache::RETURN_ALL
    ];
    $companyInfoModel = common\models\CompanyDetail::findByCompanyId($model->id, $params);
    $userInfo = new \yii\data\ArrayDataProvider([
        'allModels' => $companyInfoModel,
        'pagination' => [
            'pageSize' => 100,
            'params' => \Yii::$app->request->queryParams,
        ],
    ]);
}
?>
<?php
$form = ActiveForm::begin([
            'options' => [
                'class' => 'widget__wrapper-searchFilter',
                'autocomplete' => 'off'
            ],
        ]);
?>
<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <?=
        $form->field($model, 'name')->textInput([
            'autofocus' => false,
            'class' => 'form-control',
            'placeholder' => \yii::t('admin', 'Name')
        ])->label(\yii::t('admin', 'Name'))
        ?>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <?=
                $form->field($model, 'depository', [
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                ])
                ->dropDownList(
                        $depository, ['class' => 'chzn-select']
                )->label('Depository Type')
        ?>
    </div>
</div>
<?php if (isset($model->id) && $model->id > 0): ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="sectionHead__wrapper">
                <ul class="upper">
                    <li class="active"><a href="javascript:;">Company Users</a></li>
                    <li class="pull-right"><a href="javascript:;" data-url ="<?= Url::toRoute(['company/company-info', 'guid' => $model->guid]); ?>" class="button blue small pull-right addCompanyInfoBtn"><i class="fa fa-plus"></i> Add User</a></li>

                </ul>
            </div>
        </div>
        <!--------------user list---------->
        <?= $this->render('_company-user', ['users' => $userInfo]); ?>
        <!------------end user list-------->
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            <div class="grouping equal-button grouping__leftAligned">
                <?= Html::submitButton((isset($model->id) && $model->id > 0) ? \yii::t('admin', 'Update') : \yii::t('admin', 'create'), ['class' => 'button blue small', 'name' => 'button']) ?>
                <a href="<?= Url::toRoute(['company/index']) ?>" class="button grey small"><?= \yii::t('admin', 'Cancel') ?></a>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<div id="addCompanyInfoModal" class="modal modal__wrapper fade" tabindex="-1" role="dialog" aria-labelledby="addCompanyInfoModal">

</div>

