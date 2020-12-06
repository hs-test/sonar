<?php

namespace common\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ListType;

/**
 * ListTypeSearch represents the model behind the search form of `common\models\ListType`.
 */
class ListTypeSearch extends ListType
{
    public $search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'display_order', 'is_active', 'is_delete', 'created_by', 'created_on', 'modified_by', 'modified_on'], 'integer'],
            [['guid', 'category', 'title'], 'safe'],
            [['search'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params)
    {
        $query = ListType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                 'pageSize' => Yii::$app->params['paginationLimit']
                ],
        ]);

        $this->load($params);
        $query->andWhere(['list_type.is_delete' => ListType::RECORD_DELETED_NO]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'display_order' => $this->display_order,
            'is_active' => $this->is_active,
            'is_delete' => $this->is_delete,
            'created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'modified_by' => $this->modified_by,
            'modified_on' => $this->modified_on,
        ]);

          $query->andFilterWhere(['or',
            ['like', 'category', $this->search],
            ['like', 'title', $this->search],
        ]);
        return $dataProvider;
    }
}
