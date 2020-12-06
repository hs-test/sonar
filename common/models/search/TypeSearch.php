<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class TypeSearch extends Model
{
    public $search;

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
        $query = \common\models\Type::find();
             
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
         
         
        
        if(!empty($this->search)) {
            $query->andWhere('user.name LIKE "%' . $this->search . '%"'
                    . ' OR user.email LIKE "%' . $this->search . '%" ' );
        }
        
        return $dataProvider;
    }
}