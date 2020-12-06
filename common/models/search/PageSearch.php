<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Page;

/**
 * AwardAchievementSearch represents the model behind the search form about `\common\models\AwardAchievement`.
 */
class PageSearch extends Page
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
        $baseRules = parent::rules();
        $myRules = [
            [['search'], 'string'],
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
        $query = Page::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
				]
        ]);

        $this->load($params);
        
        $query->andFilterWhere(['or',
            ['like', 'title', $this->search],
            ['like', 'slug', $this->search],
            ['like', 'meta_title', $this->search],
            ['like', 'meta_keyword', $this->search],
            ['like', 'external_url', $this->search],
        ]);
        
        $query->orderBy(['created_at' => SORT_DESC]);
        
        return $dataProvider;
    }
}
