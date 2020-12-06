<?php

namespace common\models\reports;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of ReportSearch
 *
 * @author Ravi
 */
class ReportSearch extends \yii\base\Model
{

    public $search;
    public $dealingHeadId;
    public $from_date;
    public $to_date;
    public $state_code;
    public $district_code;
    public $discom;
    public $status;
    public $user_id;
    public $userId;
    public $getRecords;
    public $stateIds;
    public $districtIds;
    public $date;
    public $first_date_range;
    public $second_date_range;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['getRecords', 'boolean'],
            [['from_date', 'to_date'], 'required', 'on' => 'status'],
            [['search', 'from_date', 'to_date', 'gender', 'date', 'second_date_range', 'first_date_range'], 'string'],
            [['state_code', 'district_code', 'user_id', 'discom', 'status', 'stateIds', 'districtIds', 'userId', 'dealingHeadId'], 'safe'],
            [['state_code', 'district_code', 'discom', 'daterange'], 'required', 'on' => 'discom'],
            [['state_code', 'district_code', 'discom'], 'required', 'on' => 'discom-md'],
//            [['state_code'], 'required', 'on' => 'aging'],
        ];
    }

    /**
     * @inheritdoc
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
        if (!$this->getRecords) {
            return [];
        }
        $this->load($params);

        $sql = 'SELECT
            a.`srn_no`, user.`name`, a.`applicant_name`, a.`posting_date`, 
            company.`cin_no`, company.`name` AS `companyName`,a.`requested_shares`, 
            a.`requested_total_amount`, a.`status` AS `applicationStatus`,
            a.`security_depository_type`, a.`refund_share_date`, a.`refund_amount_date`, a.`refund_amount`,
            a.`refund_shares`, a.`approved_shares`, a.`approved_amount`, a.`import_depository_type`,
            b.date AS vr_received_date,
            c.date AS approved_date,
            d.date AS rejected_date,
            d.comments AS rejection_reason,
            e.date AS discripancy_date,
            f.date AS paid_date
             FROM
            (SELECT DISTINCT 
            id,srn_no,applicant_name,posting_date,requested_shares,requested_total_amount,
            refund_share_date,refund_amount_date,refund_amount,refund_shares,
            approved_shares,approved_amount,`status`,security_depository_type,dh_id,company_id,
            import_depository_type
         FROM 
             grievance
         ) a
            LEFT JOIN grievance_activity_log b 
            ON a.id = b.grievance_id AND  b.grievance_status = 1
            LEFT JOIN grievance_activity_log c 
            ON a.id = c.grievance_id AND  c.grievance_status = 3
            LEFT JOIN grievance_activity_log d 
            ON a.id = d.grievance_id AND  d.grievance_status = 4
            LEFT JOIN grievance_activity_log e 
            ON a.id = e.grievance_id AND  e.grievance_status = 5
            LEFT JOIN grievance_activity_log f 
            ON a.id = f.grievance_id AND  f.grievance_status = 6
            LEFT JOIN `user` 
                ON user.id = a.dh_id
                LEFT JOIN `company` 
                ON company.id = a.company_id WHERE company.is_active=1';

        if (!empty($this->status) || $this->status == '0') {

            $sql .=" AND a.status = $this->status";
        }
        // Fetch Record based on from date and todate
        if (isset($this->from_date) && !empty($this->from_date)) {

            $fromDate = date('Y-m-d', strtotime($this->from_date));
            $sql .=" AND a.posting_date >= '$fromDate'";
        }
        if (isset($this->to_date) && !empty($this->to_date)) {

            $toDate = date('Y-m-d', strtotime($this->to_date));
            $sql .=" AND a.posting_date <='$toDate'";
        }

        if (isset($this->dealingHeadId) && $this->dealingHeadId > 0) {

            $sql .=" AND a.dh_id = $this->dealingHeadId";
        }

        //$sql .=" AND a.srn_no = 'G43856525'";


        $sql .=" GROUP BY a.srn_no";
        $sql .=" ORDER BY a.posting_date";


        $grievanceModel = Yii::$app->db->createCommand($sql)->queryAll();

        return $grievanceModel;
    }

    public function status($params)
    {
        $finalArr = [
            'pending' => '',
            'vrRecieved' => '',
            'paid' => '',
            'approved' => '',
            'rejected' => '',
            'underProcess' => '',
            'underProcessVrRecieved' => '',
            'discrepancy' => '',
            'totalShares' => '',
            'nsdlShares' => '',
            'cdslShares' => '',
            'refundAmount' => '',
            'onlyShareRefundCount' => '',
            'onlyAmountRefundCount' => '',
            'bothRefundCount' => '',
            'mailSentCount' => ''
        ];
        if (!$this->getRecords) {
            return $finalArr;
        }
        $this->load($params);

        $selectCols = ['grievance_activity_log.id', 'grievance_activity_log.grievance_id', 'grievance_activity_log.grievance_status'];
        $queryParams = [
            'selectCols' => $selectCols,
            'joinWithGrievanceActivityLog' => 'innerJoin',
            'orderBy' => ['grievance_activity_log.`id`' => SORT_ASC],
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL,
        ];
        if (isset($this->from_date) && !empty($this->from_date)) {

            $queryParams['activityFromDateStatus'] = date('Y-m-d', strtotime($this->from_date));
        }
        if (isset($this->to_date) && !empty($this->to_date)) {

            $queryParams['activityToDate'] = date('Y-m-d', strtotime($this->to_date));
        }

        $grievanceModels = \common\models\Grievance::findGrievance($queryParams);
        //if (isset($grievanceModels) && !empty($grievanceModels)) {
        //$grievance_id = array_unique(array_column($grievanceModels, 'grievance_id'));

        $refundShares = 0;
        $refundAmount = 0;
        $pending = 0;
        $mailSentCount = 0;
        $totalShares = $nsdlShares = $cdslShares = $onlyShare = $bothShareAmount = $onlyAmount = 0;
        $grievanceId = [];

        $queryParams = [
            'selectCols' => ['id','refund_shares', 'import_depository_type', 'refund_share_date','refund_amount_date'],
            'fromShareDate' => date('Y-m-d', strtotime($this->from_date)),
            'toShareDate' => date('Y-m-d', strtotime($this->to_date)),
            'status' => ['3','6'],
            'returnAll' => 'all'
        ];
        
        $refundShares = \common\models\Grievance::findGrievance($queryParams);
        if (isset($refundShares) && !empty($refundShares)) {
            foreach ($refundShares as $key => $share) {
                $totalShares = $totalShares + $share['refund_shares'];
                if($share['import_depository_type'] == 'CDSL'){
                    $cdslShares = $cdslShares + $share['refund_shares'];
                }else if($share['import_depository_type'] == 'NSDL'){
                    $nsdlShares = $nsdlShares + $share['refund_shares'];
                }
                if(!empty($share['refund_share_date']) && empty($share['refund_amount_date'])){
                    $onlyShare = $onlyShare + 1;
                }
                if(!empty($share['refund_share_date']) && !empty($share['refund_amount_date']) && $share['refund_amount_date'] < date('Y-m-d', strtotime($this->to_date))){
                    $bothShareAmount = $bothShareAmount + 1;
                    $grievanceId[] = $share['id'];
                }
            }
        }
        $queryParams = [
            'selectCols' => ['refund_amount','id','refund_share_date','refund_amount_date'],
            'fromAmountDate' => date('Y-m-d', strtotime($this->from_date)),
            'toAmountDate' => date('Y-m-d', strtotime($this->to_date)),
            'status' => ['3','6'],
            'returnAll' => 'all',
        ];

        $refundAmounts = \common\models\Grievance::findGrievance($queryParams);
        
        if (isset($refundAmounts) && !empty($refundAmounts)) {
            foreach ($refundAmounts as $key => $amount) {
                $refundAmount = $refundAmount + $amount['refund_amount'];
                if(!empty($amount['refund_amount_date']) && empty($amount['refund_share_date'])){
                    $onlyAmount = $onlyAmount + 1;
                }
                if(!empty($amount['refund_share_date']) && !empty($amount['refund_amount_date']) && $amount['refund_share_date'] < date('Y-m-d', strtotime($this->to_date))){
                    if(!in_array($amount['id'], $grievanceId)){
                        $bothShareAmount = $bothShareAmount + 1;
                    }
                }
            }
        }
        $queryParams = [
            'selectCols' => ['id'],
            'gtCreatedAt' => date('Y-m-d', strtotime($this->from_date)),
            'lessCreatedAt' => date('Y-m-d', strtotime($this->to_date)),
//            'status' => 0,
            'count' => TRUE
        ];

        $pending = \common\models\Grievance::findGrievance($queryParams);

        $queryParams = [
            'selectCols' => ['grievance_message_log.id'],
            'joinWithGrievanceMessageLog' => 'innerJoin',
            'fromCreatedOn' => date('Y-m-d', strtotime($this->from_date)),
            'toCreatedOn' => date('Y-m-d', strtotime($this->to_date)),
            'count' => TRUE
        ];

        $mailSentCount = \common\models\Grievance::findGrievance($queryParams);

        $vrRecieved = $paid = $approved = $rejected = $underProcess = $discrepancy = 0;

        if (isset($grievanceModels) && !empty($grievanceModels)) {
            foreach ($grievanceModels as $grievanceStatus) {

                if ($grievanceStatus['grievance_status'] == \common\models\Grievance::VR_ASSIGNED) {
                    $vrRecieved = $vrRecieved + 1;
                }
                else if ($grievanceStatus['grievance_status'] == \common\models\Grievance::PAID) {
                    $paid = $paid + 1;
                }
                else if ($grievanceStatus['grievance_status'] == \common\models\Grievance::APPROVED) {
                    $approved = $approved + 1;
                }
                else if ($grievanceStatus['grievance_status'] == \common\models\Grievance::REJECTED) {
                    $rejected = $rejected + 1;
                }
                else if ($grievanceStatus['grievance_status'] == \common\models\Grievance::DISCREPANCY) {
                    $discrepancy = $discrepancy + 1;
                }

                if ($grievanceStatus['grievance_status'] == \common\models\Grievance::DR_ASSIGNED) {
                    $underProcess = $underProcess + 1;
                }
            }
        }

        $finalArr = [
            'pending' => $pending,
            'vrRecieved' => $vrRecieved,
            'paid' => $paid,
            'approved' => $approved,
            'rejected' => $rejected,
            'underProcess' => $underProcess,
            'underProcessVrRecieved' => $underProcess + $vrRecieved,
            'discrepancy' => $discrepancy,
            'totalShares' => $totalShares,
            'nsdlShares' => $nsdlShares,
            'cdslShares' => $cdslShares,
            'onlyShareRefundCount' => $onlyShare,
            'onlyAmountRefundCount' => $onlyAmount,
            'bothRefundCount' => $bothShareAmount,
            'refundAmount' => $refundAmount,
            'mailSentCount' => $mailSentCount
        ];
        //}
        return $finalArr;
    }

    public function aging($params)
    {

        $this->load($params);
        if (empty($this->date)) {
            $this->date = date('d-m-Y');
        }
        $selectCols = ['distinct(grievance.id),MAX(grievance_activity_log.date) as date,grievance_activity_log.grievance_status'];
        $queryParams = [
            'selectCols' => $selectCols,
            'joinWithGrievanceActivityLog' => 'innerJoin',
            'status' => [1, 2],
            'grievanceAndActivityLogStatus' => TRUE,
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL,
            'groupBy' => 'grievance.id',
        ];
        if (isset($this->date) && !empty($this->date)) {
            $queryParams['activityToDate'] = date('Y-m-d', strtotime($this->date));
        }

        $finalArr = [];

        $grievanceModel = \common\models\Grievance::findGrievance($queryParams);

        $queryParams = [
            'selectCols' => ['status as grievance_status', 'posting_date as date'],
            'status' => 0,
            'lessCreatedAt' => date('Y-m-d', strtotime($this->date)),
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL
        ];

        $pendingData = \common\models\Grievance::findGrievance($queryParams);

        $grievanceModel = \yii\helpers\ArrayHelper::merge($grievanceModel, $pendingData);

        $vrlessthanfifteen = $vrlessthanthirty = $vrlessthansixty = $vrlessthanninety = $vrlessthanonetwenty = $vrgreaterthanonetwenty = 0;
        $drlessthanfifteen = $drlessthanthirty = $drlessthansixty = $drlessthanninety = $drlessthanonetwenty = $drgreaterthanonetwenty = 0;
        $pendinglessthanfifteen = $pendinglessthanthirty = $pendinglessthansixty = $pendinglessthanninety = $pendinglessthanonetwenty = $pendinggreaterthanonetwenty = 0;
        if (isset($grievanceModel) && !empty($grievanceModel)) {
            foreach ($grievanceModel as $grievance) {

                if ($grievance['grievance_status'] == \common\models\Grievance::VR_ASSIGNED) {
                    $diff = $this->dateDifference($grievance['date'], $this->date);

                    if ($diff <= 15) {
                        $vrlessthanfifteen = $vrlessthanfifteen + 1;
                    }
                    else if ($diff > 15 && $diff < 30) {
                        $vrlessthanthirty = $vrlessthanthirty + 1;
                    }
                    else if ($diff > 30 && $diff < 60) {
                        $vrlessthansixty = $vrlessthansixty + 1;
                    }
                    else if ($diff > 60 && $diff < 90) {
                        $vrlessthanninety = $vrlessthanninety + 1;
                    }
                    else if ($diff > 90 && $diff < 120) {
                        $vrlessthanonetwenty = $vrlessthanonetwenty + 1;
                    }
                    else {
                        $vrgreaterthanonetwenty = $vrgreaterthanonetwenty + 1;
                    }
                }
                else if ($grievance['grievance_status'] == \common\models\Grievance::DR_ASSIGNED) {
                    $diff = $this->dateDifference($grievance['date'], $this->date);

                    if ($diff <= 15) {
                        $drlessthanfifteen = $drlessthanfifteen + 1;
                    }
                    else if ($diff > 15 && $diff < 30) {
                        $drlessthanthirty = $drlessthanthirty + 1;
                    }
                    else if ($diff > 30 && $diff < 60) {
                        $drlessthansixty = $drlessthansixty + 1;
                    }
                    else if ($diff > 60 && $diff < 90) {
                        $drlessthanninety = $drlessthanninety + 1;
                    }
                    else if ($diff > 90 && $diff < 120) {
                        $drlessthanonetwenty = $drlessthanonetwenty + 1;
                    }
                    else {
                        $drgreaterthanonetwenty = $drgreaterthanonetwenty + 1;
                    }
                }
                else if ($grievance['grievance_status'] == \common\models\Grievance::PENDING) {
                    $diff = $this->dateDifference($grievance['date'], $this->date);

                    if ($diff <= 15) {
                        $pendinglessthanfifteen = $pendinglessthanfifteen + 1;
                    }
                    else if ($diff > 15 && $diff < 30) {
                        $pendinglessthanthirty = $pendinglessthanthirty + 1;
                    }
                    else if ($diff > 30 && $diff < 60) {
                        $pendinglessthansixty = $pendinglessthansixty + 1;
                    }
                    else if ($diff > 60 && $diff < 90) {
                        $pendinglessthanninety = $pendinglessthanninety + 1;
                    }
                    else if ($diff > 90 && $diff < 120) {
                        $pendinglessthanonetwenty = $pendinglessthanonetwenty + 1;
                    }
                    else {
                        $pendinggreaterthanonetwenty = $pendinggreaterthanonetwenty + 1;
                    }
                }
            }
            $freshClaimPending = $vrlessthanfifteen + $vrlessthanthirty + $vrlessthansixty + $vrlessthanninety + $vrlessthanonetwenty + $vrgreaterthanonetwenty;
            $resubmitted = $drlessthanfifteen + $drlessthanthirty + $drlessthansixty + $drlessthanninety + $drlessthanonetwenty + $drgreaterthanonetwenty;
            $verificationReportPending = $pendinglessthanfifteen + $pendinglessthanthirty + $pendinglessthansixty + $pendinglessthanninety + $pendinglessthanonetwenty + $pendinggreaterthanonetwenty;
        }

        $finalArr = compact('freshClaimPending', 'vrlessthanfifteen', 'vrlessthanthirty', 'vrlessthansixty', 'vrlessthanninety', 'vrlessthanonetwenty', 'vrgreaterthanonetwenty'
                , 'resubmitted', 'drlessthanfifteen', 'drlessthanthirty', 'drlessthansixty', 'drlessthanninety', 'drlessthanonetwenty', 'drgreaterthanonetwenty'
                , 'verificationReportPending', 'pendinglessthanfifteen', 'pendinglessthanthirty', 'pendinglessthansixty', 'pendinglessthanninety', 'pendinglessthanonetwenty', 'pendinggreaterthanonetwenty');
        return $finalArr;
    }

    private function dateDifference($date1, $date2)
    {

        $date1 = date_create(date('Y-m-d', strtotime($date1)));
        $date2 = date_create(date('Y-m-d', strtotime($date2)));
        $diff = date_diff($date1, $date2);
        return $diff->format("%R%a days");
    }
    
    
    public function performance($params) {
        if (!$this->getRecords) {
            return [];
        }

        $this->load($params);
        
        $selectCols = ['grievance_activity_log.grievance_id', 'grievance.status as current_status', 'grievance_activity_log.grievance_status', 'grievance.dh_id', 'grievance_activity_log.date', 'user.name', 'user.allowed_grievance'];
        $queryParams = [
            'selectCols' => $selectCols,
            'joinWithGrievanceActivityLog' => 'innerJoin',
            'joinWithUser' => 'innerJoin',
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL,
            'orderBy' => ['grievance_activity_log.date' => SORT_ASC]
        ];

        if (isset($this->from_date) && !empty($this->from_date)) {

            $queryParams['activityFromDate'] = date('Y-m-d', strtotime($this->from_date));
            $start = (new \DateTime($this->from_date))->modify('first day of this month');
        }
        if (isset($this->to_date) && !empty($this->to_date)) {

            $queryParams['activityToDate'] = date('Y-m-d', strtotime($this->to_date));
            $end = (new \DateTime($this->to_date))->modify('first day of next month');
        }

        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        $monthList = [];
        foreach ($period as $dt) {
            $monthList[] = $dt->format("m");
        }

        $grievanceModel = \common\models\Grievance::findGrievance($queryParams);
        
        $grievanceList = [];
        $dhGrievanceList = [];

        if (!empty($grievanceModel)) {
            $i = 0;
            foreach ($grievanceModel as $grievance) {
                $dhGrievanceList[$grievance['dh_id']]['name'] = $grievance['name']; //[$grievance['grievance_id']][$i]['date'] = $grievance['date'];
                $dhGrievanceList[$grievance['dh_id']]['grievance'][$grievance['grievance_id']][$i]['grievance_status'] = $grievance['grievance_status'];
                $dhGrievanceList[$grievance['dh_id']]['grievance'][$grievance['grievance_id']][$i]['current_status'] = $grievance['current_status'];
                $i++;
            }
        }
        if (isset($dhGrievanceList) && !empty($dhGrievanceList)) {

            $k = 0;
            $total_fresh_claim_alloted_week = 0;
            $total_resubmitted_claim_alloted_week = 0;
            $total_claim_processed = 0;
            $total_bifucation_processed = 0;
            $total_fresh_claim_alloted_end_week = 0;
            
            foreach ($dhGrievanceList as $dhId => $grievanceArr) {

                $target = \common\models\User::findUserTargetNew($dhId, $monthList);
                
                $dealingHead = $grievanceArr['name'];
                $fresh_claim_start_week = 0;
                $fresh_claim_alloted_week = 0;
                $resubmitted_claim_start_week = 0;
                $resubmitted_claim_alloted_week = 0;
                $claim_processes_new = 0;
                $claim_processed_resubmitted = 0;
                $fresh_claim_end_week = 0;
                $resubmitted_claim_end_week = 0;
                $bifucation_processed_claim_approved = 0;
                $bifucation_processed_claim_rejected = 0;
                $bifucation_processed_claim_discrepancy = 0;
                $bifucation_processed_claim_underprocessed = 0;
                $bifucation_processed_claim_resubmitted_discrepancy = 0;
                
                foreach ($grievanceArr['grievance'] as $grievanceId => $grievanceStatus) {
                    
                    $grievanceActivityModel = \common\models\GrievanceActivityLog::findByGrievanceId($grievanceId, ['selectCols' => ['grievance_status', 'date'], 'lessDateAt' => date('Y-m-d', strtotime($this->from_date)), 'resultCount' => \common\models\caching\ModelCache::RETURN_ALL, 'orderBy' => ['date' => SORT_ASC]]);
                    $activityStatus = \yii\helpers\ArrayHelper::getColumn($grievanceActivityModel, 'grievance_status');
                    $countStatus = array_count_values($activityStatus);
                    // No of claim pending for processing with start of week
                    if (array_key_exists(1, $countStatus)) {
                        $lastStatus = end($activityStatus);

                        if ($lastStatus == 1) {
                            $fresh_claim_start_week = $fresh_claim_start_week + 1;
                        }
                        
                    }
                    
                    $gStatus = \yii\helpers\ArrayHelper::getColumn($grievanceStatus, 'grievance_status');
                    $checkFreshStatus = array_count_values($gStatus); 
                    
                    // Fresh claim alloted during the week
                    if (array_key_exists(1, $checkFreshStatus)) {
                        $fresh_claim_alloted_week = $fresh_claim_alloted_week + 1;
                    }
                    
                    // Letter pending for processing during the week
                    if (array_key_exists(2, $countStatus) || array_key_exists(7, $countStatus)) {

                        $lastStatus = end($activityStatus);

                        if ($lastStatus == 2 || $lastStatus == 7) {
                            $resubmitted_claim_start_week = $resubmitted_claim_start_week + 1;
                        }
                    }
                    
                    // letters received during the week
                    if (array_key_exists(2, $checkFreshStatus) || array_key_exists(7, $checkFreshStatus)) {
                        if(array_key_exists(2, $checkFreshStatus) && !array_key_exists(7, $checkFreshStatus)){
                            $resubmitted_claim_alloted_week = $resubmitted_claim_alloted_week + $checkFreshStatus[2];
                        }elseif (array_key_exists(7, $checkFreshStatus) && !array_key_exists(2, $checkFreshStatus)) {
                            $resubmitted_claim_alloted_week = $resubmitted_claim_alloted_week + 1;
                        }elseif (array_key_exists(2, $checkFreshStatus) && array_key_exists(7, $checkFreshStatus) && !array_key_exists(3, $checkFreshStatus) && !array_key_exists(4, $checkFreshStatus) && !array_key_exists(6, $checkFreshStatus)) {
                            $resubmitted_claim_alloted_week = $resubmitted_claim_alloted_week + $checkFreshStatus[2];
                        }
                    }
                    
                    $grievanceActivityPendencyModel = \common\models\GrievanceActivityLog::findByGrievanceId($grievanceId, ['selectCols' => ['grievance_status', 'date'], 'lessEqualDateAt' => date('Y-m-d', strtotime($this->to_date)), 'resultCount' => \common\models\caching\ModelCache::RETURN_ALL, 'orderBy' => ['date' => SORT_ASC]]);
                    $activityPendencyStatus = \yii\helpers\ArrayHelper::getColumn($grievanceActivityPendencyModel, 'grievance_status');
                    $countPendencyStatus = array_count_values($activityPendencyStatus);
                    //No. of Fresh Claims pending at the end of the week
                    if (array_key_exists(1, $countPendencyStatus)) {
                        $lastStatus = end($activityPendencyStatus);
                        if ($lastStatus == 1) {
                            $fresh_claim_end_week = $fresh_claim_end_week + 1;
                        }
                    }
                    
                    //pending of resubmitted claims for processing
                    if (array_key_exists(2, $countPendencyStatus) || array_key_exists(7, $countPendencyStatus)) {
                        $lastStatus = end($activityPendencyStatus);
                        if ($lastStatus == 2 || $lastStatus == 7) {
                            $resubmitted_claim_end_week = $resubmitted_claim_end_week + 1;
                        }
                    }
                    // Processed claim bifucation
                    $currentStatus = \yii\helpers\ArrayHelper::getColumn($grievanceStatus, 'grievance_status');
                    $checkCurrentStatus = array_count_values($currentStatus);
                    
                    //Approval
                    if (array_key_exists(3, $checkCurrentStatus)) {
                        $lastStatus = end($currentStatus);
                        if ($lastStatus == 3) {
                            $bifucation_processed_claim_approved = $bifucation_processed_claim_approved + 1;
                        }
                    }
                    
                    //Rejection
                    if (array_key_exists(4, $checkCurrentStatus)) {
                        $lastStatus = end($currentStatus);
                        if ($lastStatus == 4) {
                            $bifucation_processed_claim_rejected = $bifucation_processed_claim_rejected + 1;
                        }
                    }
                }
                
                $total_fresh_claim_alloted_week = $fresh_claim_start_week + $fresh_claim_alloted_week;
                $total_resubmitted_claim_alloted_week = $resubmitted_claim_start_week + $resubmitted_claim_alloted_week;
                //New
                $claim_processes_new = $total_fresh_claim_alloted_week - $fresh_claim_end_week;
                // Resubmitted
                $claim_processed_resubmitted = $total_resubmitted_claim_alloted_week - $resubmitted_claim_end_week;
                $total_claim_processed = $claim_processes_new + $claim_processed_resubmitted;
                // Total Bifurcation
                $bifucation_processed_claim_resubmitted_discrepancy = $total_claim_processed - ($bifucation_processed_claim_approved + $bifucation_processed_claim_rejected);
                $total_bifucation_processed = $bifucation_processed_claim_resubmitted_discrepancy + $bifucation_processed_claim_approved + $bifucation_processed_claim_rejected;
                $total_fresh_claim_alloted_end_week = $fresh_claim_end_week + $resubmitted_claim_end_week;
                $monthly_target_assigned = $target;
                $percentage_target = !empty($monthly_target_assigned) && $monthly_target_assigned != 0 ? (($total_claim_processed/$monthly_target_assigned) * 100) : 0;
                $grievanceList[$k]['dealingHead'] = $dealingHead;
                $grievanceList[$k]['fresh_claim_start_week'] = $fresh_claim_start_week;
                $grievanceList[$k]['fresh_claim_alloted_week'] = $fresh_claim_alloted_week;
                $grievanceList[$k]['total_fresh_claim_alloted_week'] = $total_fresh_claim_alloted_week;
                $grievanceList[$k]['resubmitted_claim_start_week'] = $resubmitted_claim_start_week;
                $grievanceList[$k]['resubmitted_claim_alloted_week'] = $resubmitted_claim_alloted_week;
                $grievanceList[$k]['total_resubmitted_claim_alloted_week'] = $total_resubmitted_claim_alloted_week;
                $grievanceList[$k]['claim_processes_new'] = $claim_processes_new;
                $grievanceList[$k]['claim_processed_resubmitted'] = $claim_processed_resubmitted;
                $grievanceList[$k]['total_claim_processed'] = $total_claim_processed;
                $grievanceList[$k]['bifucation_processed_claim_resubmitted_discrepancy'] = $bifucation_processed_claim_resubmitted_discrepancy;
                $grievanceList[$k]['bifucation_processed_claim_approved'] = $bifucation_processed_claim_approved;
                $grievanceList[$k]['bifucation_processed_claim_rejected'] = $bifucation_processed_claim_rejected;
                $grievanceList[$k]['total_bifucation_processed'] = $total_bifucation_processed;
                $grievanceList[$k]['fresh_claim_end_week'] = $fresh_claim_end_week;
                $grievanceList[$k]['resubmitted_claim_end_week'] = $resubmitted_claim_end_week;
                $grievanceList[$k]['total_fresh_claim_alloted_end_week'] = $total_fresh_claim_alloted_end_week;
                $grievanceList[$k]['monthly_target_assigned'] = $monthly_target_assigned;
                $grievanceList[$k]['percentage_target'] = number_format((float) $percentage_target, 2, '.', '');
                $k++;
            
            }
            
        }
        return $grievanceList;
    }

    public function performanceold($params)
    {

        if (!$this->getRecords) {
            return [];
        }

        $this->load($params);


        $selectCols = ['grievance_activity_log.grievance_id', 'grievance.status as current_status', 'grievance_activity_log.grievance_status', 'grievance.dh_id', 'grievance_activity_log.date', 'user.name', 'user.allowed_grievance'];
        $queryParams = [
            'selectCols' => $selectCols,
            'joinWithGrievanceActivityLog' => 'innerJoin',
            'joinWithUser' => 'innerJoin',
            'resultCount' => \common\models\caching\ModelCache::RETURN_ALL,
            'orderBy' => ['grievance_activity_log.`id`' => SORT_ASC, 'grievance_activity_log.`date`' => SORT_ASC],
            //'dealingHeadId' => 44,
            //'id' => 13110
        ];

        if (isset($this->from_date) && !empty($this->from_date)) {

            $queryParams['activityFromDate'] = date('Y-m-d', strtotime($this->from_date));
            $start = (new \DateTime($this->from_date))->modify('first day of this month');
        }
        if (isset($this->to_date) && !empty($this->to_date)) {

            $queryParams['activityToDate'] = date('Y-m-d', strtotime($this->to_date));
            $end = (new \DateTime($this->to_date))->modify('first day of next month');
        }

        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        $monthList = [];
        foreach ($period as $dt) {
            $monthList[] = $dt->format("j");
        }


        $grievanceModel = \common\models\Grievance::findGrievance($queryParams);
        
       

        $grievanceList = [];
        $dhGrievanceList = [];

        if (!empty($grievanceModel)) {

            foreach ($grievanceModel as $grievance) {
                $dhGrievanceList[$grievance['dh_id']]['name'] = $grievance['name']; //[$grievance['grievance_id']][$i]['date'] = $grievance['date'];
                $dhGrievanceList[$grievance['dh_id']]['grievance'][$grievance['grievance_id']][]['grievance_status'] = $grievance['grievance_status'];
            }
        }
        
        $diff = strtotime($this->to_date) - strtotime($this->from_date);
        $no_of_days = abs(round($diff / 86400));

        if (isset($dhGrievanceList) && !empty($dhGrievanceList)) {

            $k = 0;
            $total_fresh_claim_alloted_week = 0;
            $total_resubmitted_claim_alloted_week = 0;
            $total_claim_processed = 0;
            $total_bifucation_processed = 0;
            $total_fresh_claim_alloted_end_week = 0;

            $freshClaimFlag = TRUE;

            foreach ($dhGrievanceList as $dhId => $grievanceArr) {

                $target = \common\models\User::findUserTarget($dhId, ['month' => $monthList]);
                
                $dealingHead = $grievanceArr['name'];
                $fresh_claim_start_week = 0;
                $fresh_claim_alloted_week = 0;
                $resubmitted_claim_start_week = 0;
                $resubmitted_claim_alloted_week = 0;
                $claim_processes_new = 0;
                $claim_processed_resubmitted = 0;
                $fresh_claim_end_week = 0;
                $resubmitted_claim_end_week = 0;
                $bifucation_processed_claim_approved = 0;
                $bifucation_processed_claim_rejected = 0;
                $bifucation_processed_claim_discrepancy = 0;
                $bifucation_processed_claim_underprocessed = 0;
                $bifucation_processed_claim_resubmitted_discrepancy = 0;
                foreach ($grievanceArr['grievance'] as $grievanceId => $grievanceStatus) {

                    $drcurrentStatusStartedWeek = TRUE;

                    $grievanceActivityModel = \common\models\GrievanceActivityLog::findByGrievanceId($grievanceId, ['selectCols' => ['grievance_status', 'date'], 'lessDateAt' => date('Y-m-d', strtotime($this->from_date)), 'resultCount' => \common\models\caching\ModelCache::RETURN_ALL, 'orderBy' => ['date' => SORT_ASC]]);
                    $activityStatus = \yii\helpers\ArrayHelper::getColumn($grievanceActivityModel, 'grievance_status');
                    $countStatus = array_count_values($activityStatus);

                    // new claim alloted before date
                    if (array_key_exists(1, $countStatus) && count($activityStatus) == 1) {
                        $fresh_claim_start_week = $fresh_claim_start_week + 1;
                    }

                    // resubmitted claim alloted before date
                    if (array_key_exists(2, $countStatus)) {

                        $lastStatus = end($activityStatus);
                        $previousStatus = prev($activityStatus);

                        if ($lastStatus == 2 && $previousStatus != 2) {
                            $resubmitted_claim_start_week = $resubmitted_claim_start_week + 1;
                        }
                    }

                    $gStatus = \yii\helpers\ArrayHelper::getColumn($grievanceStatus, 'grievance_status');
                    $checkFreshStatus = array_count_values($gStatus);

                    // fresh claim alloted week
                    if (array_key_exists(1, $checkFreshStatus) && count($gStatus) == 1) {
                        $fresh_claim_alloted_week = $fresh_claim_alloted_week + 1;
                    }

                    // resubmitted alloted week
                  
                    if (array_key_exists(2, $checkFreshStatus)) {

                        $lastStartStatus = end($gStatus);
                        $previousStartStatus = prev($gStatus);
                        if ($lastStartStatus == 2 && $previousStartStatus != 2) {
                            $resubmitted_claim_alloted_week = $resubmitted_claim_alloted_week + 1;
                        }
                    }

                    // claim processed new
                    if (array_key_exists(1, $checkFreshStatus) && count($gStatus) > 1) {
                        $claim_processes_new = $claim_processes_new + 1;
                    }

                    // claim processed resubmitted
                    $lastProcessedStatus = end($gStatus);
                    if ($lastProcessedStatus != 2 && array_key_exists(2, $checkFreshStatus) && (array_key_exists(3, $checkFreshStatus) || array_key_exists(4, $checkFreshStatus) || array_key_exists(5, $checkFreshStatus) || array_key_exists(6, $checkFreshStatus) || array_key_exists(7, $checkFreshStatus))) {
                        $claim_processed_resubmitted = $claim_processed_resubmitted + $checkFreshStatus[2];
                    }

                    $notProcessedResubmitted = TRUE;
                    $notProcessedRejected = TRUE;

                    $vr = 1;
                    $dr = 2;
                    $underprocess = 7;

                    // for vr
                    $afterVr = 0;
                    $afterDr = 0;
                    $afterUnderProcess = 0;

                    $currentKeyVr = array_search($vr, $gStatus);


                    if (!empty($currentKeyVr) || $currentKeyVr === 0 && count($gStatus) > 1) {

                        $afterVr = (isset($gStatus[$currentKeyVr + 1])) ? $gStatus[$currentKeyVr + 1] : 0;
                    }

                    if ($afterVr == 2 || $afterVr == 7 || $afterVr == 5) {

                        $bifucation_processed_claim_resubmitted_discrepancy = $bifucation_processed_claim_resubmitted_discrepancy + 1;
                    }

                    if ($afterVr == 4) {

                        $bifucation_processed_claim_rejected = $bifucation_processed_claim_rejected + 1;
                    }

                    // for dr
                    $currentKeyDr = array_search($dr, $gStatus);

                    if (!empty($currentKeyDr) || $currentKeyDr === 0 && count($gStatus) > 1) {
                        $afterDr = (isset($gStatus[$currentKeyDr + 1])) ? $gStatus[$currentKeyDr + 1] : $gStatus[0];
                    }

                    if ($afterDr == 2 || $afterDr == 7 || $afterDr == 5) {

                        $bifucation_processed_claim_resubmitted_discrepancy = $bifucation_processed_claim_resubmitted_discrepancy + 1;
                    }

                    if ($afterDr == 4) {
                        $bifucation_processed_claim_rejected = $bifucation_processed_claim_rejected + 1;
                    }
                    
                    //for Under process
                    $currentKeyUnderProcess = array_search($underprocess, $gStatus);
                    if (!empty($currentKeyUnderProcess) || $currentKeyUnderProcess === 0 && count($gStatus) > 1) {
                        $afterUnderProcess = (isset($gStatus[$currentKeyUnderProcess + 1])) ? $gStatus[$currentKeyUnderProcess + 1] : 0;
                    }
                    if ($afterUnderProcess == 4) {
                        $bifucation_processed_claim_rejected = $bifucation_processed_claim_rejected + 1;
                    }

                    //approved
                    if (array_key_exists(3, $checkFreshStatus)) {
                        //$bifucation_processed_claim_approved = $bifucation_processed_claim_approved + 1;
                    }
                }


                $total_fresh_claim_alloted_week = $fresh_claim_start_week + $fresh_claim_alloted_week;
                $total_resubmitted_claim_alloted_week = $resubmitted_claim_start_week + $resubmitted_claim_alloted_week;
                $total_claim_processed = $claim_processes_new + $claim_processed_resubmitted;
                $total_bifucation_processed = $bifucation_processed_claim_resubmitted_discrepancy + $bifucation_processed_claim_approved + $bifucation_processed_claim_rejected;
                $fresh_claim_end_week = $total_fresh_claim_alloted_week - $claim_processes_new;
                $resubmitted_claim_end_week = $total_resubmitted_claim_alloted_week - $claim_processed_resubmitted;
                $total_fresh_claim_alloted_end_week = $fresh_claim_end_week + $resubmitted_claim_end_week;

                $monthly_target_assigned = (int) ($target / 30) * $no_of_days;
                $percentage_target = !empty($monthly_target_assigned) ? ($total_claim_processed / $monthly_target_assigned) * 100 : 0;

                $grievanceList[$k]['dealingHead'] = $dealingHead;
                $grievanceList[$k]['fresh_claim_start_week'] = $fresh_claim_start_week;
                $grievanceList[$k]['fresh_claim_alloted_week'] = $fresh_claim_alloted_week;
                $grievanceList[$k]['total_fresh_claim_alloted_week'] = $total_fresh_claim_alloted_week;
                $grievanceList[$k]['resubmitted_claim_start_week'] = $resubmitted_claim_start_week;
                $grievanceList[$k]['resubmitted_claim_alloted_week'] = $resubmitted_claim_alloted_week;
                $grievanceList[$k]['total_resubmitted_claim_alloted_week'] = $total_resubmitted_claim_alloted_week;
                $grievanceList[$k]['claim_processes_new'] = $claim_processes_new;
                $grievanceList[$k]['claim_processed_resubmitted'] = $claim_processed_resubmitted;
                $grievanceList[$k]['total_claim_processed'] = $total_claim_processed;
                $grievanceList[$k]['bifucation_processed_claim_resubmitted_discrepancy'] = $bifucation_processed_claim_resubmitted_discrepancy;
                $grievanceList[$k]['bifucation_processed_claim_approved'] = $bifucation_processed_claim_approved;
                $grievanceList[$k]['bifucation_processed_claim_rejected'] = $bifucation_processed_claim_rejected;
                $grievanceList[$k]['total_bifucation_processed'] = $total_bifucation_processed;
                $grievanceList[$k]['fresh_claim_end_week'] = $fresh_claim_end_week;
                $grievanceList[$k]['resubmitted_claim_end_week'] = $resubmitted_claim_end_week;
                $grievanceList[$k]['total_fresh_claim_alloted_end_week'] = $total_fresh_claim_alloted_end_week;
                $grievanceList[$k]['monthly_target_assigned'] = $monthly_target_assigned;
                $grievanceList[$k]['percentage_target'] = number_format((float) $percentage_target, 2, '.', '');
                $k++;
            }
        }

        return $grievanceList;
    }

    private function multiple_array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

}
