<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\search;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Description of DiscomSearch
 *
 * @author Pawan
 */
class DiscomSearch extends \yii\base\Model
{

    public $search;

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
    public function search($params)
    {
        $query = \common\models\Discom::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]
        ]);

        $this->load($params);

        $query->orderBy(['discom_code' => SORT_ASC]);

        return $dataProvider;
    }

}
