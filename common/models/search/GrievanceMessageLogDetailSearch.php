<?php

namespace common\models\search;

use Yii;
use common\models\Grievance;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * Description of GrievanceMessageLogDetailSearch
 *
 * @author Ravi Sikarwar
 */
class GrievanceMessageLogDetailSearch extends \common\models\GrievanceMessageLogDetail
{

    public $type;

    public function rules()
    {

        return [
            [['type'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params = [])
    {
        $query = GrievanceMessageLogDetailSearch::find();
        $this->load($params);
        if (!empty($this->type)) {
            $query->andWhere('grievance_message_log_detail.type = :type', [':type' => $this->type]);
        }
        $query->orderBy(['created_on' => SORT_DESC]);

        return new ActiveDataProvider(['query' => $query]);
    }

}
