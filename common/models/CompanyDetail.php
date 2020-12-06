<?php

namespace common\models;

use Yii;
use common\models\base\CompanyDetail as BaseCompanyDetail;

class CompanyDetail extends BaseCompanyDetail
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const RECORD_DELETED_YES = 1;
    const RECORD_DELETED_NO = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on'],
                ],
            ],
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['contact_person','contact_no','email','address']
            ],
        ];
    }

    public static function findByParams($params = [])
    {
        $modelAQ = static::find();
        $tableName = self::tableName();

        //Table columns to return in results, string or array
        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select($tableName . '.*');
        }

        // integer only
        if (isset($params['id'])) {
            $modelAQ->andWhere($tableName . '.id = :id', [':id' => (int) $params['id']]);
        }
        if (isset($params['companyId'])) {
            $modelAQ->andWhere($tableName . '.company_id = :companyId', [':companyId' => (int) $params['companyId']]);
        }
        if (isset($params['email'])) {
            $modelAQ->andWhere($tableName . '.email = :email', [':email' => $params['email']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByCompanyId($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['companyId' => $id], $params));
    }

    public function saveUsersInfo($companyId, $users)
    {
        try {

            foreach ($users as $user) {
                $model = new CompanyDetail();
                $model->isNewRecord = TRUE;
                $model->company_id = $companyId;
                $model->name = $user['name'];
                $model->email = $user['email'];
                $model->address = $user['address'];
                $model->save();
            }
            return TRUE;
        }
        catch (\Exception $ex) {
            throw $ex;
        }
        return FALSE;
    }

}
