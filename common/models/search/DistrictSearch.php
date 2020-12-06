<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\District;

/**
 * DistrictSearch represents the model behind the search form about `\common\models\District`.
 */
class DistrictSearch extends District
{

    public $search;
    public $state_code;
    public $is_discom_md;

    public function rules()
    {
        return [
            [['state_code', 'is_discom_md'], 'integer'],
            [['search'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = District::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('stateCode');

        $dataProvider->setSort([
            'attributes' => [
                'state_code' => [
                    'asc' => ['state.name' => SORT_ASC],
                    'desc' => ['state.name' => SORT_DESC],
                ]
            ]
        ]);

        $this->load($params);
        $query->andFilterWhere([
            'state_code' => $this->state_code
        ]);
        
        $query->andFilterWhere(['like', 'district.name', $this->search]);
        $query->andFilterWhere(['district.state_code' => $this->state_code]);
        
        if (!empty($this->is_discom_md)) {

            $userParams = [
                'selectCols' => 'user_location.district_code',
                'joinUserLocation' => 'innerJoin',
                'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
            ];
            
            $user = \common\models\User::findByRoleId(\common\models\User::ROLE_DISCOM_MD, $userParams);
            $districtCodeList = \yii\helpers\ArrayHelper::getColumn($user, 'district_code');
            if ($this->is_discom_md == '1') {
                $query->andWhere(['IN', 'district.code', $districtCodeList]);
            }
            else {
                $query->andWhere(['NOT IN', 'district.code', $districtCodeList]);
            }
        }

        if ($asArray) {
            return $query->all();
        }

        return $dataProvider;
    }

}
