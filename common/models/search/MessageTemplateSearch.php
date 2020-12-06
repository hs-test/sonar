<?php

namespace common\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MessageTemplate;

/**
 * MessageTemplateSearch represents the model behind the search form of `common\models\MessageTemplate`.
 */
class MessageTemplateSearch extends MessageTemplate
{
    public $search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        $query = MessageTemplate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination' =>[
                 'pageSize' => Yii::$app->params['paginationLimit']
                ],
        ]);

        $this->load($params);
        $query->andWhere(['message_template.is_deleted' => MessageTemplate::RECORD_DELETED_NO]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

          $query->andFilterWhere(['or',
            ['like', 'type', $this->search],
            ['like', 'title', $this->search],
        ]);
        return $dataProvider;
    }
}
