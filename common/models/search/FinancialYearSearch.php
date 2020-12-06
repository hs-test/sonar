<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FinancialYear;

/**
 * FinancialYearSearch represents the model behind the search form of `common\models\FinancialYear`.
 */
class FinancialYearSearch extends FinancialYear
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'is_active', 'is_delete', 'created_on', 'created_by', 'modified_on', 'modified_by'], 'integer'],
            [['guid', 'name', 'from_date', 'to_date'], 'safe'],
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
        $query = FinancialYear::find()->joinWith('createdBy');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                 'pageSize' => Yii::$app->params['paginationLimit']
                ],
        ]);

        $this->load($params);
        $query->andWhere(['financial_year.is_delete' => FinancialYear::RECORD_DELETED_NO]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'code' => $this->code,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'financial_year.name', $this->name]);
           

        return $dataProvider;
    }
}
