<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\State;

/**
 * StateSearch represents the model behind the search form about `\common\models\State`.
 */
class StateSearch extends State
{

    public $search;
    public $is_cpm_head;
    public $is_nodal_officer;
    public $is_state_user;

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
        $myRules = [
            [['search'], 'string'],
            [['is_nodal_officer', 'is_cpm_head', 'is_state_user'], 'integer']
        ];

        return $myRules;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $asArray = false)
    {
        $query = State::find();

        $query->orderBy('state.name');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $userParams = [
            'selectCols' => 'user_location.state_code',
            'joinUserLocation' => 'innerJoin',
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
        ];

        if (!empty($this->is_nodal_officer)) {
            $user = \common\models\User::findByRoleId(\common\models\User::ROLE_DISCOM_NODAL_OFFICER, $userParams);
            $stateCodeList = \yii\helpers\ArrayHelper::getColumn($user, 'state_code');
            if ($this->is_nodal_officer == '1') {
                $query->andWhere(['IN', 'state.code', $stateCodeList]);
            }
            else {
                $query->andWhere(['NOT IN', 'state.code', $stateCodeList]);
            }
        }

        if (!empty($this->is_cpm_head)) {
            $user = \common\models\User::findByRoleId(\common\models\User::ROLE_CPM, $userParams);
            $stateCodeList = \yii\helpers\ArrayHelper::getColumn($user, 'state_code');
            if ($this->is_cpm_head == '1') {
                $query->andWhere(['IN', 'state.code', $stateCodeList]);
            }
            else {
                $query->andWhere(['NOT IN', 'state.code', $stateCodeList]);
            }
        }
        
        if (!empty($this->is_state_user)) {
            $user = \common\models\User::findByRoleId(\common\models\User::ROLE_STATE_USER, $userParams);
            $stateCodeList = \yii\helpers\ArrayHelper::getColumn($user, 'state_code');
            if ($this->is_state_user == '1') {
                $query->andWhere(['IN', 'state.code', $stateCodeList]);
            }
            else {
                $query->andWhere(['NOT IN', 'state.code', $stateCodeList]);
            }
        }

        $query->andFilterWhere(['or',
            ['like', 'state.name', $this->search],
            ['like', 'state.search_name', $this->search],
        ]);

        if ($asArray) {
            return $query->all();
        }
        return $dataProvider;
    }

}
