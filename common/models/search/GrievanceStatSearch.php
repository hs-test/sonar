<?php

namespace common\models\search;

use Yii;
use common\models\GrievanceStat;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * Description of GrievanceSearch
 *
 * @author Ravi Sikarwar
 */
class GrievanceStatSearch extends GrievanceStat
{

    public $search;
    public $type;

    public function rules()
    {
        return [
            [['search'], 'string'],
            [['type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params = [])
    {
        $query = \common\models\GrievanceStat::find();

        $query->where('grievance_stat.type=:type', [':type' => $this->type]);
        $this->load($params);
        $query->orderBy(['created_on' => SORT_DESC]);

        return new ActiveDataProvider(['query' => $query]);
    }

}
