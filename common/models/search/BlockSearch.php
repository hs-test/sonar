<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Block;


class BlockSearch extends Block
{
    public $search;
    public $state;
    public $district;
    
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
            [['district','state'], 'integer'],
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
    public function search($params, $report = false, $asArray = false)
    {
        $query = Block::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['block.is_deleted' => \common\models\State::RECORD_DELETED_NO]);
        
        $query->andWhere('block.name LIKE "%' . $this->search . '%" ');
        
        $query->andFilterWhere([
            'district_code' => $this->district,
            'state_code' => $this->state,
        ]);

        if ($asArray) {
            return $query->all();
        }
        return $dataProvider;
    }
}