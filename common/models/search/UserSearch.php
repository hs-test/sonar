<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{

    public $search;
    public $role_id;
   

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function rules()
    {
        return [
            [['search'], 'string'],
            [['role_id'], 'integer'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $query = \common\models\User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->where('role_id !=:roleId', [':roleId' => \common\models\User::ROLE_SUPERADMIN]);

        if (Yii::$app->user->hasAdminRole() && !Yii::$app->user->hasSuperAdminRole()) {
            $query->andWhere('role_id !=:role', [':role' => \common\models\User::ROLE_ADMIN]);
        }

        $query->andFilterWhere([
            'role_id' => $this->role_id
        ]);

        if (!empty($this->search)) {
            $query->andWhere('user.name LIKE "%' . $this->search . '%"'
                    . ' OR user.email LIKE "%' . $this->search . '%" '
                    . ' OR user.mobile LIKE "%' . $this->search . '%" '
                    . ' OR user.username LIKE "%' . $this->search . '%" ');
        }

        if (isset($params['returnResult']) && $params['returnResult']) {

            return $query->asArray()->all();
        }

        return $dataProvider;
    }

    public function export($params = [])
    {

        $this->load($params);
        $selectCols = [
            'user.id', 'user.name', 'user.mobile', 'user.email', 'user.role_id', 'user.discom_id', 'user_location.state_code', 'user_location.district_code'
        ];

        $query = \common\models\UserLocation::find()->select($selectCols)->innerJoin('user', 'user.id=user_location.user_id');
        $query->andFilterWhere(['and',
            ['IN', 'user.role_id', [\common\models\User::ROLE_CPM, \common\models\User::ROLE_DISCOM_MD, \common\models\User::ROLE_DISCOM_NODAL_OFFICER, \common\models\User::ROLE_RAC_CPM, \common\models\User::ROLE_RAC_NODAL_OFFICER, \common\models\User::ROLE_STATE_USER]],
        ]);


        $query->andFilterWhere([
            'role_id' => $this->role_id
        ]);

        if (!empty($this->search)) {
            $query->andWhere('user.name LIKE "%' . $this->search . '%"'
                    . ' OR user.email LIKE "%' . $this->search . '%" '
                    . ' OR user.mobile LIKE "%' . $this->search . '%" '
                    . ' OR user.username LIKE "%' . $this->search . '%" ');
        }

        //$query->andWhere(['user.id'=>1657]);
        if (!empty($this->state_code) || !empty($this->district_code)) {

            if (!empty($this->state_code)) {
                $query->andWhere('user_location.state_code = :stateCode', [':stateCode' => $this->state_code]);
            }

            if (!empty($this->district_code)) {
                $query->andWhere('user_location.district_code = :districtCode', [':districtCode' => $this->district_code]);
            }
        }


        // echo $query->createCommand()->rawSql;die;
        $query->orderBy('user_location.state_code');
        $userModel = $query->asArray()->all();

        $i = 0;
        $users = [];
        if (!empty($userModel)) {
            foreach ($userModel as $user) {
                $users[$user['id']][$i] = $user;
                $i++;
            }
        }

        $j = 0;
        $userList = [];
        if (isset($users) && !empty($users)) {
            foreach ($users as $userId => $userData) {

                $stateCode = [];
                $discomCode = [];
                foreach ($userData as $user) {

                    if (!empty($user['state_code'])) {
                        $stateModel = \common\models\State::findByCode($user['state_code']);
                        if (!empty($stateModel)) {

                            $stateCode[] = $stateModel['name'];
                        }
                    }

                    if ($user['role_id'] == \common\models\User::ROLE_DISCOM_MD || $user['role_id'] == \common\models\User::ROLE_DISCOM_NODAL_OFFICER) {
                        if (!empty($user['discom_id'])) {
                            $discomModel = \common\models\Discom::findById($user['discom_id'], ['selectCols' => ['discom.discom_code']]);
                            $discomCode[] = $discomModel['discom_code'];
                        }
                    }
                    if ($user['role_id'] == \common\models\User::ROLE_CPM || $user['role_id'] == \common\models\User::ROLE_RAC_NODAL_OFFICER || $user['role_id'] == \common\models\User::ROLE_STATE_USER) {
                        if (!empty($user['state_code'])) {
                            $discomUsers = \common\models\User::find()->select('discom.discom_code')->leftJoin('user_location', 'user_location.user_id=user.id')->leftJoin('discom', 'discom.id=user.discom_id')->where('user_location.state_code=:stateCode', [':stateCode' => $user['state_code']])->andWhere(['IN', 'user.role_id', [\common\models\User::ROLE_DISCOM_MD]])->groupBy('discom.id')->asArray()->all();
                            if (!empty($discomUsers)) {
                                foreach ($discomUsers as $discomUser) {
                                    $discomCode[] = $discomUser['discom_code'];
                                }
                            }
                        }
                    }

                    $name = $user['name'];
                    $mobile = $user['mobile'];
                    $email = $user['email'];
                    $role = \common\models\User::roleArray($user['role_id']);
                }

                $userList[$j]['name'] = $name;
                $userList[$j]['mobile'] = $mobile;
                $userList[$j]['email'] = $email;
                $userList[$j]['role'] = $role;
                $userList[$j]['stateName'] = implode(',', array_unique($stateCode));
                $userList[$j]['discom'] = implode(',', array_unique($discomCode));

                $j++;
            }
        }

        //echo '<pre>';print_r($userList);die;
        return $userList;
    }

}
