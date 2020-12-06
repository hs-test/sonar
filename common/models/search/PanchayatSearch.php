<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Panchayat;


class PanchayatSearch extends Panchayat
{
    public $search;
    public $state;
    public $district;
    public $block;

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
        $baseRules = parent::rules();
        $myRules = [
            [['search'], 'string'],
            [['block','district','state'], 'integer'],
        ];

        return \yii\helpers\ArrayHelper::merge($baseRules, $myRules);
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
        $query = Panchayat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['panchayat.is_deleted' => \common\models\State::RECORD_DELETED_NO]);
        
        $query->andWhere('panchayat.name LIKE "%' . $this->search . '%" ');
        
        $query->andFilterWhere([
            'block_code' => $this->block,
            'district_code' => $this->district,
            'state_code' => $this->state,
        ]);


        return $dataProvider;
    }
}