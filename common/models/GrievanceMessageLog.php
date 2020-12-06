<?php

namespace common\models;

use common\models\base\GrievanceMessageLog as BaseGrievanceMessageLog;

/**
 * Description of GrievanceMessageLog
 *
 * @author Ravi Sikarwar
 */
class GrievanceMessageLog extends BaseGrievanceMessageLog
{
   const SENT_TYPE_COMPANY = 'company';
   const SENT_TYPE_APPLICANT = 'applicant';
   const SENT_TYPE_BOTH = 'both';
   
    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on'],
                ]
            ],
        ];
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGrievanceId($grievanceId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['grievanceId' => $grievanceId], $params));
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

        if (isset($params['messageId'])) {
            $modelAQ->andWhere($tableName . '.message_id =:messageId', [':messageId' => $params['messageId']]);
        }

        if (isset($params['applicationStatus'])) {
            $modelAQ->andWhere($tableName . '.grievance_status =:grievanceStatus', [':grievanceStatus' => $params['grievanceStatus']]);
        }

        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }

        if (isset($params['inOperator']) && !empty($params['inOperator'])) {
            $modelAQ->andWhere(['IN', $params['inOperator']['column'], $params['inOperator']['data']]);
        }

        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'grievance_assign_log.created_by = user.id');

            if (isset($params['joinWithRole']) && in_array($params['joinWithRole'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
                $modelAQ->{$params['joinWithRole']}('role', 'role.id = user.role_id');
            }
        }

        if (isset($params['joinWithMessageLogDetail']) && in_array($params['joinWithMessageLogDetail'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithMessageLogDetail']}('grievance_message_log_detail', 'grievance_message_log_detail.grievance_message_log_id = grievance_message_log.id');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }
    
    public static function getMessageLogDetails($grievanceId, $params = [])
    {
        $params = [

            'selectCols' => ['grievance_message_log.id as messageLogId', 'grievance_message_log_detail.id as messageLogDetailId',
                'grievance_message_log_detail.created_on', 'grievance_message_log_detail.receiver_name',
                'grievance_message_log.subject', 'grievance_message_log_detail.type'
            ],
            'resultCount' => caching\ModelCache::RETURN_ALL,
            'joinWithMessageLogDetail' => 'rightJoin'
        ];
        $messageLogModel = GrievanceMessageLog::findByGrievanceId($grievanceId, $params);

        $i = 0;
        $messageLogs = [];
        if (!empty($messageLogModel)) {
            foreach ($messageLogModel as $messageLog) {
                $messageLogs[$messageLog['type']][$i] = [
                    'logId' => $messageLog['messageLogId'],
                    'logDetailId' => $messageLog['messageLogDetailId'],
                    'date' => date('d-m-Y', $messageLog['created_on']),
                    'receiverName' => $messageLog['receiver_name'],
                    'subject' => $messageLog['subject'],
                ];
                $i++;
            }
        }

        return $messageLogs;
    }

}
