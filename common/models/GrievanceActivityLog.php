<?php

namespace common\models;

use common\models\base\GrievanceActivityLog as BaseGrievanceActivityLog;

/**
 * Description of GrievanceLog
 *
 * @author Ravi Sikarwar
 */
class GrievanceActivityLog extends BaseGrievanceActivityLog
{

    public $srnNo;
    public $prefix;
    public $autoallocation = true;

    const IS_MESSAGE_SENT_YES = 1;
    const IS_MESSAGE_SENT_NO = 0;

    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on'],
                ]
            ],
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['additional_comment']
            ],
        ];
    }
    
    public function rules()
    {
        $rules = parent::rules();
        $myRules = [

            ['date', 'validateDates'],
        ];

        return \yii\helpers\ArrayHelper::merge($rules, $myRules);
    }

    public function validateDates($attribute)
    {
        if (strtotime($this->date) > strtotime(date('Y-m-d'))) {
            $this->addError($attribute, "Date cannot be greater than current date");
        }
    }

    /**
     * Function to update model data before record is saved
     * 
     * @param bool $insert
     * @return type
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (in_array($this->grievance_status, [Grievance::VR_ASSIGNED, Grievance::DR_ASSIGNED])) {
                $this->description = self::GenerateTrackingNo($this->date);
                if (empty($this->description)) {
                    throw new \components\exceptions\AppException('Something went wrong while creating description.');
                }
            }
            if ($this->autoallocation) {
                //assigned to dealing head
                Grievance::allocateToDealingHead($this->grievance_id, $this->grievance_status);
            }
        }

        return parent::beforeSave($insert);
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGrievanceId($grievanceId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['grievanceId' => $grievanceId], $params));
    }

    public function generateToken()
    {
        $params = [
            'inOperator' => [
                'column' => 'grievance_activity_log.grievance_status',
                'data' => [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED]
            ],
            'countOnly' => TRUE
        ];
        $model = \common\models\GrievanceActivityLog::findByGrievanceId($this->grievance_id, $params);

        $autoincrement = (empty($model)) ? 1 : $model + 1;
        if ($autoincrement <= 9) {
            $autoincrement = '0' . $autoincrement;
        }

        $day = date('d', strtotime($this->date));
        $month = date('m', strtotime($this->date));
        $year = date('Y', strtotime($this->date));
        $date = $day . $month . $year;
        $this->prefix = \common\models\Grievance::getGrievanceStatusArr($this->grievance_status);
        $token = $this->srnNo . '/' . $this->prefix . $autoincrement . '/' . $date;
        return $token;
    }

    public static function GenerateTrackingNo($date)
    {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $params = [
            'month' => $month,
            'year' => $year,
            'inOperator' => [
                'column' => 'grievance_activity_log.grievance_status',
                'data' => [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED]
            ],
            'countOnly' => TRUE
        ];
        $model = \common\models\GrievanceActivityLog::findByParams($params);

        $autoincrement = (empty($model)) ? '00001' : str_pad($model + 1, 5, 0, STR_PAD_LEFT);

        $token = $month . $year . '/' . $autoincrement;
        return $token;
    }

    private static function findByParams($params = [])
    {
        $modelAQ = self::find();
        $tableName = self::tableName();

        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select($tableName . '.*');
        }

        if (isset($params['id'])) {
            $modelAQ->andWhere($tableName . '.id =:id', [':id' => $params['id']]);
        }

        if (isset($params['grievanceId'])) {
            $modelAQ->andWhere($tableName . '.grievance_id =:grievanceId', [':grievanceId' => $params['grievanceId']]);
        }

        if (isset($params['applicationStatus'])) {

            if (is_array($params['applicationStatus']) && count($params['applicationStatus']) > 0) {
                $modelAQ->andWhere(['IN', $tableName . '.grievance_status', $params['applicationStatus']]);
            }
            else {
                $modelAQ->andWhere($tableName . '.grievance_status =:applicationStatus', [':applicationStatus' => $params['applicationStatus']]);
            }
        }

        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }

        if (isset($params['month'])) {
            $modelAQ->andWhere('MONTH(date) = :month', [':month' => $params['month']]);
        }

        if (isset($params['year'])) {
            $modelAQ->andWhere('YEAR(date) = :year', [':year' => $params['year']]);
        }

        if (isset($params['gtDateAt'])) {
            $modelAQ->andWhere($tableName . '.date >=:gtDateAt', [':gtDateAt' => $params['gtDateAt']]);
        }

        if (isset($params['lessDateAt'])) {
            $modelAQ->andWhere($tableName . '.date <:lessDateAt', [':lessDateAt' => $params['lessDateAt']]);
        }
        
        if (isset($params['lessEqualDateAt'])) {
            $modelAQ->andWhere($tableName . '.date <=:lessEqualDateAt', [':lessEqualDateAt' => $params['lessEqualDateAt']]);
        }

        if (isset($params['inOperator']) && !empty($params['inOperator'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
        }

        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'grievance_activity_log.created_by = user.id');

            if (isset($params['joinWithRole']) && in_array($params['joinWithRole'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
                $modelAQ->{$params['joinWithRole']}('role', 'role.id = user.role_id');
            }
        }

        if (isset($params['joinWithGrievance']) && in_array($params['joinWithGrievance'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithGrievance']}('grievance', 'grievance.id = grievance_activity_log.grievance_id');
        }

        if (isset($params['joinWithCompany']) && in_array($params['joinWithCompany'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithCompany']}('company', 'company.id = grievance.company_id');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }
        //echo $modelAQ->createCommand()->rawSql;die;

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function getComments($activityComments, $html = FALSE)
    {
        $list = '';
        if (empty($activityComments)) {
            return $list;
        }

        $comments = json_decode($activityComments, TRUE);

        if (!empty($comments)) {
            $i = 1;
            foreach ($comments['comments'] as $comment) {

                if ($html) {
                    $list .= '<td valign="top" width="100%" style="width:100%; line-height:18px; font-size:13px; line-height:19px; padding-bottom:1mm;">';
                    $list .= '<strong>' . $i . '. </strong>' . str_replace("\r\n", "", $comment);
                    $list .= '</td>';
                    $list .= '</tr>';
                }
                else {
                    $list .=str_replace("\r\n", "", $comment);
                }
                $i++;
            }
        }
        return $list;
    }
    
    public function saveActivityLogs($data)
    {
        if (empty($data)) {
            return FALSE;
        }

        $this->isNewRecord = true;
        $this->setAttributes($data);

        if ($this->save()) {
            return TRUE;
        }
        return FALSE;
    }

}
