<?php

namespace common\models\search;

use Yii;
use common\models\Grievance;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * Description of GrievanceSearch
 *
 * @author Ravi Sikarwar
 */
class GrievanceSearch extends Grievance
{

    public $search;
    public $srnNo;
    public $status;
    public $except_grievance_id;
    public $dealingHeadId;
    public $grievanceStatus;
    public $fromDate;
    public $toDate;
    public $notNullDhId = FALSE;
    public $trakingId;
    public $dealingHead;
    public $searchByLogs;
    public $is_scan;
    public $is_review;
    public $scanreviewfromDate;
    public $scanreviewtoDate;
    public $searchByType;

    public function rules()
    {

        return [
            [['search'], 'string'],
            [['customer_id', 'except_grievance_id', 'dealingHeadId', 'searchByLogs', 'is_scan', 'is_review','searchByType'], 'integer'],
            ['srnNo', 'required', 'on' => 'search'],
            [['srnNo', 'fromDate', 'toDate', 'grievanceStatus', 'trakingId', 'dealingHead','scanreviewfromDate','scanreviewtoDate'], 'safe'],
            [['fromDate','grievanceStatus'], 'required', 'when' => function ($model) {
            return !empty($this->searchByLogs) && in_array($this->searchByLogs, ['1', '2']) ? TRUE : FALSE;
        },
                'whenClient' => "function (attribute, value) {
                    return ($('#grievancesearch-searchbylogs').val() == '" . 1 . "' || $('#grievancesearch-searchbylogs').val() == '" . 2 . "') ? true : false;
                   
            }"],
            ['toDate', 'required', 'when' => function ($model) {
                    return !empty($model->searchByLogs) && in_array($model->searchByLogs, ['1', '2']) && !in_array($model->grievanceStatus, ['2', '7']);
                },
                'whenClient' => "function (attribute, value) {
                    return ($('#grievancesearch-searchbylogs').val() == '" . 1 . "' || $('#grievancesearch-searchbylogs').val() == '" . 2 . "') && ($('#grievancesearch-grievancestatus').val() != '" . 2 . "' && $('#grievancesearch-grievancestatus').val() != '" . 7 . "') ? true : false;
                   
            }"],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params = [])
    {
        $query = Grievance::find()->joinWith('company');

        $this->load($params);

        if (isset($this->search) && $this->search !== '') {
            $query->andFilterWhere(['OR',
                ['LIKE', 'grievance.applicant_name', $this->search],
                ['LIKE', 'company.name', $this->search],
                ['LIKE', 'company.cin_no', $this->search],
                ['LIKE', 'grievance.srn_no', $this->search],
                ['LIKE', 'grievance.applicant_name', $this->search],
            ]);
        }
        else {
            if (\Yii::$app->user->hasDealingHeadRole()) {

                $query->andWhere('grievance.dh_id= :dealingHeadId', [':dealingHeadId' => Yii::$app->user->id]);
            }
        }

        if (isset($this->dealingHead) && !empty($this->dealingHead)) {
            $query->leftJoin('user', 'user.id=grievance.dh_id');
            $query->andWhere('user.id= :userId', [':userId' => $this->dealingHead]);
        }

        if (!empty($this->except_grievance_id)) {
            $query->andWhere('grievance.id != :exceptId', [':exceptId' => $this->except_grievance_id]);
        }

        if (!empty($this->trakingId)) {

            $query->leftJoin('grievance_activity_log', 'grievance_activity_log.grievance_id=grievance.id')
                    ->andFilterWhere(['LIKE', 'grievance_activity_log.description', $this->trakingId]);
            $query->groupBy('grievance.id');
        }

        if (isset($this->srnNo) && !empty($this->srnNo)) {
            $query->andWhere('grievance.srn_no= :srnNo', [':srnNo' => $this->srnNo]);
        }

        if (isset($this->dealingHeadId) && !empty($this->dealingHeadId)) {
            //$query->andWhere('grievance.dh_id= :dealingHeadId', [':dealingHeadId' => $this->dealingHeadId]);
        }

        if (isset($this->notNullDhId) && $this->notNullDhId) {
            $query->andWhere('grievance.dh_id IS NOT NULL');
        }

        if (\Yii::$app->user->hasDealingHeadRole()) {
            $query->andWhere(['IN', 'grievance.status', [
                    \common\models\Grievance::DR_ASSIGNED,
                    \common\models\Grievance::VR_ASSIGNED,
                    \common\models\Grievance::DISCREPANCY,
                    \common\models\Grievance::UNDER_PROCESS,
                    \common\models\Grievance::APPROVED,
                    \common\models\Grievance::REJECTED,
                    \common\models\Grievance::PAID,
            ]]);
        }

        if (\Yii::$app->user->hasAccountManagerRole()) {
            $query->andWhere(['IN', 'grievance.status', [
                    \common\models\Grievance::APPROVED
            ]]);
        }

        if (\Yii::$app->user->hasDispatchExecuitveRole()) {
            $query->andWhere(['IN', 'grievance.status', [
                    \common\models\Grievance::DR_ASSIGNED,
                    \common\models\Grievance::VR_ASSIGNED,
                    \common\models\Grievance::PENDING,
                    \common\models\Grievance::DISCREPANCY,
            ]]);
        }

        //added by shashwat
        if(isset($this->fromDate) && !empty($this->fromDate) && empty($this->toDate) && $this->searchByLogs == 1 && in_array($this->grievanceStatus, ['2', '7'])){
               
                $query->leftJoin('grievance_activity_log', 'grievance_activity_log.grievance_id=grievance.id AND grievance_activity_log.date BETWEEN "'.date('Y-m-d', strtotime($this->fromDate)).'" AND "'.date('Y-m-d').'"');
                $query->andWhere('grievance.status = :grievanceStatus', [':grievanceStatus' => $this->grievanceStatus]);
                $query->andWhere('grievance_activity_log.grievance_id IS NULL');
                
        }
        else if (!empty($this->grievanceStatus) || $this->grievanceStatus == '0') {

            $grievanceStatus = TRUE;
            if (is_array($this->grievanceStatus)) {
                $query->andWhere(['IN', 'grievance.status', $this->grievanceStatus]);
            }
            else {

                if (isset($this->fromDate) && !empty($this->fromDate) && isset($this->toDate) && !empty($this->toDate)) {

                    if (empty($this->trakingId)) {
                        $query->leftJoin('grievance_activity_log', 'grievance_activity_log.grievance_id=grievance.id');
                    }
                    $query->andWhere('grievance_activity_log.date >=:gtCreatedAt', [':gtCreatedAt' => date('Y-m-d', strtotime($this->fromDate))]);
                    $query->andWhere('grievance_activity_log.date <=:ltCreatedAt', [':ltCreatedAt' => date('Y-m-d', strtotime($this->toDate))]);
                    if (isset($this->searchByLogs) && !empty($this->searchByLogs)) {
                        if ($this->searchByLogs == 2) {
                            $query->andWhere('grievance_activity_log.grievance_status =:grievanceStatus', [':grievanceStatus' => $this->grievanceStatus]);
                        }
                        else {
                            $query->andWhere('grievance.status= :grievanceStatus', [':grievanceStatus' => $this->grievanceStatus]);
                        }
                    }
                    $query->groupBy('grievance_activity_log.grievance_id');
                }
                else {
                    $query->andWhere('grievance.status= :grievanceStatus', [':grievanceStatus' => $this->grievanceStatus]);
                }
            }
        }
        else {

            // Fetch Record based on from date and todate
            if (isset($this->fromDate) && !empty($this->fromDate)) {

                $fromDate = date('Y-m-d', strtotime($this->fromDate));
                $query->andWhere('grievance.posting_date >=:gtCreatedAt', [':gtCreatedAt' => $fromDate]);
            }
            if (isset($this->toDate) && !empty($this->toDate)) {

                $toDate = date('Y-m-d', strtotime($this->toDate));
                $query->andWhere('grievance.posting_date <=:ltCreatedAt', [':ltCreatedAt' => $toDate]);
            }
        }

        //echo '<pre>';print_r($params);die;
        if(isset($this->is_scan) && !empty($this->is_scan) || isset($this->is_review) && !empty($this->is_review)){
            
            $query->andFilterWhere(['AND',
                ['grievance.is_scan'=> $this->is_scan],
                ['grievance.is_review'=> $this->is_review],
                
            ]);
 
        }else{
            if($this->is_scan =='0'){
             $query->andWhere('grievance.is_scan= :isScan', [':isScan' => $this->is_scan]);   
            }
            if($this->is_review =='0'){
               $query->andWhere('grievance.is_review= :isReview', [':isReview' => $this->is_review]); 
            }
        }
        
        if (isset($this->searchByType) && !empty($this->searchByType)) {
            
                
           
               if ($this->searchByType == 2) {
                           $query->innerJoin('grievance_scan_review','grievance_scan_review.grievance_id=grievance.id');
                           $query->andWhere('grievance_scan_review.type=:type',[':type'=>  \common\models\GrievanceScanReview::TYPE_SCAN]);
                        }else{
                           $query->innerJoin('grievance_scan_review','grievance_scan_review.grievance_id=grievance.id');
                           $query->andWhere('grievance_scan_review.type=:type',[':type'=>  \common\models\GrievanceScanReview::TYPE_REVIEW]);
                        }
                        
            if (isset($this->scanreviewfromDate) && !empty($this->scanreviewfromDate)) {

                $filterFromdate = date('Y-m-d', strtotime($this->scanreviewfromDate));
                $query->andWhere('grievance_scan_review.date >=:scanreviewFromDate', [':scanreviewFromDate' => $filterFromdate]);
            }
            if (isset($this->scanreviewtoDate) && !empty($this->scanreviewtoDate)) {

                $filterTodate = date('Y-m-d', strtotime($this->scanreviewtoDate));
                $query->andWhere('grievance_scan_review.date <=:scanreviewtoDate', [':scanreviewtoDate' => $filterTodate]);
            }
                
                         
             }
             
                 //echo $query->createCommand()->rawSql;
        //  die;
        $query->orderBy(['posting_date' => SORT_ASC]);
        return new ActiveDataProvider(['query' => $query]);
    }

}
