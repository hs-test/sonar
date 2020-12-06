<?php

namespace app\modules\admin\models;

use Yii;
use common\models\User;
use common\models\Role;
use yii\base\Model;

/**
 * Description of CompanyForm
 *
 * @author Ravi
 */
class CompanyForm extends Model
{

    public $id;
    public $guid;
    public $name;
    public $depository;
    public $cin_no;
    public $users;
    public $created_by;
    public $modified_by;

    const SCENARIO_USER_DISPATCH_EXECUTIVE = 'dispatch-executive';

    public function init()
    {
        $this->created_by = \Yii::$app->user->id;
        $this->modified_by = \Yii::$app->user->id;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id','integer'],
            [['name'], 'required'],
            [['cin_no','guid','depository'], 'string'],
            ['users', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
        ];
    }

    public function save()
    {
        $guid = $this->guid;
        $transaction = \Yii::$app->db->beginTransaction();

        try {

            if (isset($guid) && !empty($guid)) {
                $companyModel = \common\models\Company::find()
                        ->where('guid=:guid', [':guid' => $guid])
                        ->one();
                if (empty($companyModel)) {
                    return false;
                }
            }
            else {
                $companyModel = new \common\models\Company();
                $companyModel->loadDefaultValues(TRUE);
            }
            $companyModel->attributes = $this->attributes;

            if (!$companyModel->save()) {
                $this->addErrors($companyModel->getErrors());
                $transaction->rollBack();
                return false;
            }
            // update company details
//            if (isset($this->users) && !empty($this->users) && count($this->users) > 0) {
//                $companyInfoModel = new \common\models\CompanyInfo;
//                $companyInfoModel->saveUsersInfo($companyModel->id, $this->users);
//            }

            $transaction->commit();
            return true;
        }
        catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }

        return false;
    }

    public static function getCompanyFormData($companyId = 0, $companyGuid = '')
    {

        $query = \common\models\Company::find();

        if ($companyId > 0) {
            $query->where('company.id = :id', [':id' => $companyId
            ]);
        }
        if (!empty($companyGuid)) {
            $query->andWhere('company.guid = :guid', [':guid' => $companyGuid
            ]);
        }

        $companyData = $query->asArray()->one();

        if ($companyData === null) {
            throw new \components\exceptions\AppException('Oops! We could not get data form company model. Here’s the message we got: <br/>requested parameter is not valid.');
        }

        return $companyData;
    }

}
