<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Village;


class VillageSearch extends Village
{

    public $search;
    public $state_code;
    public $district_code;

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
            [['district_code', 'state_code'], 'integer'],
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
    public function search($params)
    {
        $query = Village::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['village.is_deleted' => Village::RECORD_DELETED_NO]);

        
        // grid filtering conditions
        $query->andFilterWhere([
            'district_code' => $this->district_code,
            'state_code' => $this->state_code,
        ]);

        $query->andWhere('village.name LIKE "%' . $this->search . '%" ');

       // echo $query->createCommand()->rawSql; die;
        return $dataProvider;
    }

}
