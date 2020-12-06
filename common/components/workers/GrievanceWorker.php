<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components\workers;

/**
 * Description of GrievanceWorker
 *
 * @author Pawan
 */
class GrievanceWorker
{

    private $filePath;
    private $mediaId;

    public function __construct($mediaId, $filePath)
    {
        $this->mediaId = $mediaId;
        $this->filePath = $filePath;
    }

    public function import()
    {
        $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = $companyCreatedUpdated = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {

                $transaction = \Yii::$app->db->beginTransaction();

                $srn_no = $line[0];
                $posting_date = $line[3];
                $cin_no = $line[1];
                $company_name = $line[2];
                $applicant_name = $line[4];
                $applicant_std_code = $line[5];
                $applicant_phone_no = $line[6];
                $applicant_mobile_no = $line[7];
                $applicant_email = $line[8];
                $no_of_share = $line[9];
                $nominal_amount_of_share = $line[10];
                $total = $line[11];
                $bank_account_no = $line[12];
                $bank_name = $line[13];
                $bank_branch = $line[14];
                $micr_code = $line[15];
                $demat_account_number = $line[16];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($applicant_name)) {
                    throw new \Exception("Applicant name {$applicant_name} cannot be blank.");
                }

                if (empty($cin_no)) {
                    throw new \Exception("CIN {$cin_no} cannot be blank.");
                }
                if (empty($company_name)) {
                    throw new \Exception("Company name {$company_name} cannot be blank.");
                }

                $grievanceModel = \common\models\Grievance::findBySrnNo($srn_no, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
                if (!empty($grievanceModel)) {
                    throw new \Exception("Grievance with srn no {$srn_no} already exist.");
                }

                $companyId = NULL;
                $depository = NULL;
                $companyModel = \common\models\Company::findByCIN(trim($cin_no), ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);

                if (empty($companyModel)) {
                    $companyModel = new \common\models\Company();
                    $companyModel->isNewRecord = TRUE;
                    $companyModel->cin_no = trim($cin_no);
                    $companyModel->name = trim($company_name);

                    if (!$companyModel->save()) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($companyModel, ['header' => '']));
                    }

                    $companyId = $companyModel->id;
                    $companyCreatedUpdated['INSERTED'][] = [
                        'name' => $companyModel->name,
                        'row' => $row
                    ];
                }
                else {
                    if (strtoupper(trim($companyModel->name)) != strtoupper(trim($company_name))) {
                        $oldCompanyName = $companyModel->name;
                        $companyModel->name = $company_name;
                        if (!$companyModel->save(TRUE, ['name'])) {
                            throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($companyModel, ['header' => '']));
                        }
                        if (isset($companyModel->depository) && !empty($companyModel->depository)) {
                            $depository = $companyModel->depository;
                        }
                        $companyCreatedUpdated['UPDATED'][] = [
                            'row' => $row,
                            'old' => $oldCompanyName,
                            'name' => $companyModel->name,
                        ];
                    }
                    $companyId = $companyModel->id;
                }
                if (empty($companyId)) {
                    throw new \Exception("Error creating company {$company_name} not found.");
                }

                $grievanceModel = new \common\models\Grievance();
                $grievanceModel->isNewRecord = TRUE;
                $grievanceModel->srn_no = $srn_no;
                $grievanceModel->company_id = $companyId;
                $grievanceModel->applicant_name = $applicant_name;
                $grievanceModel->financial_year = 2016;
                $grievanceModel->posting_date = (isset($posting_date) && !empty($posting_date)) ? date('Y-m-d', strtotime($posting_date)) : NULL;
                //$grievanceModel->applicant_address = (isset($line[6]) && !empty($line[6])) ? $line[6] : NULL;
                $grievanceModel->applicant_std_code = (isset($applicant_std_code) && !empty($applicant_std_code)) ? $applicant_std_code : NULL;
                $grievanceModel->applicant_phone = (isset($applicant_phone_no) && !empty($applicant_phone_no)) ? $applicant_phone_no : NULL;
                $grievanceModel->applicant_mobile = (isset($applicant_mobile_no) && !empty($applicant_mobile_no)) ? $applicant_mobile_no : NULL;
                $grievanceModel->applicant_email = (isset($applicant_email) && !empty($applicant_email)) ? $applicant_email : NULL;
                $grievanceModel->requested_shares = (isset($no_of_share) && !empty($no_of_share)) ? $no_of_share : 0;
                $grievanceModel->requested_nominal_share_amount = (isset($nominal_amount_of_share) && !empty($nominal_amount_of_share)) ? $nominal_amount_of_share : 0;
                $grievanceModel->requested_total_amount = (isset($total) && !empty($total)) ? $total : 0;
                $grievanceModel->applicant_bank_account_no = (isset($bank_account_no) && !empty($bank_account_no)) ? $bank_account_no : NULL;
                $grievanceModel->applicant_bank_name = (isset($bank_name) && !empty($bank_name)) ? $bank_name : NULL;
                $grievanceModel->applicant_bank_branch = (isset($bank_branch) && !empty($bank_branch)) ? $bank_branch : NULL;
                $grievanceModel->applicant_micr_code = (isset($micr_code) && !empty($micr_code)) ? $micr_code : NULL;
                $grievanceModel->applicant_dmat_account_no = (isset($demat_account_number) && !empty($demat_account_number)) ? $demat_account_number : NULL;
                $grievanceModel->import_depository_type = $depository;
                if (!$grievanceModel->save()) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }
                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $grievanceStatModel = new \common\models\GrievanceStat();
        $grievanceStatModel->isNewRecord = TRUE;
        $grievanceStatModel->media_id = $this->mediaId;
        $grievanceStatModel->logs = !empty($errors) ? base64_encode(serialize(implode('#', $errors))) : NULL;
        $grievanceStatModel->type = \common\models\GrievanceStat::TYPE_GRIEVANCE;
        $grievanceStatModel->total = $success + $failed;
        $grievanceStatModel->success = $success;
        $grievanceStatModel->failed = $failed;
        $grievanceStatModel->company_logs = !empty($companyCreatedUpdated) ? base64_encode(serialize($companyCreatedUpdated)) : NULL;
        $grievanceStatModel->save();

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function cdslImport()
    {
        $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        $fileToImport = fopen($url, 'r');

        $i = 0;
        $row = 0;
        $errors = [];
        $success = 0;
        $failed = 0;

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {
                $srnNo = $line[0];
                $refundShares = $line[1];
                $refundDate = $line[2];
                $status = strtolower($line[3]);

                if (empty($srnNo)) {
                    throw new \Exception("Row-{$row}:Srn No {$srnNo} cannot be blank.");
                }

                if (empty($refundShares)) {
                    throw new \Exception("Row-{$row}:Refund Shares {$refundShares} cannot be blank.");
                }

                if (empty($refundDate)) {
                    throw new \Exception("Row-{$row}:Refund Date {$refundDate} cannot be blank.");
                }

                if (empty($status)) {
                    throw new \Exception("Row-{$row}:Status {$status} cannot be blank.");
                }

                if ($status !== 'success') {
                    throw new \Exception("Row-{$row}:Status is inappropriate.");
                }

                $model = \common\models\Grievance::findBySrnNo($srnNo, ['status' => [\common\models\Grievance::APPROVED, \common\models\Grievance::PAID], 'resultFormat' => 'object']);

                if (!empty($model) && !empty($model->pay_status)) {
                    if (empty($model->refund_shares) && empty($model->refund_share_date)) {
                        $model->refund_shares = $refundShares;
                        $model->refund_share_date = date('Y-m-d', strtotime($refundDate));
                        $model->import_depository_type = 'CDSL';
                        if ($model->pay_status == \common\models\Grievance::STATUS_SHARES_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_SHARE;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_BOTH) {
                            $model->pay_status = \common\models\Grievance::STATUS_PARTIAL_PAID_SHARES_ONLY;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_PARTIAL_PAID_AMOUNT_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_BOTH;
                        }

                        if (!$model->save()) {
                            throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($model, ['header' => '']));
                        }
                        $success = $success + 1;
                    }
                    else {
                        throw new \Exception("Row-{$row}:SRN No- {$srnNo} already have a refund share date and refund shares");
                    }
                }
                else {
                    throw new \Exception("Row-{$row}:SRN No- {$srnNo} with Approved or Paid Status not Found");
                }
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = $e->getMessage();
                continue;
            }
        }


        $grievanceStatModel = new \common\models\GrievanceStat();
        $grievanceStatModel->isNewRecord = TRUE;
        $grievanceStatModel->media_id = $this->mediaId;
        $grievanceStatModel->logs = !empty($errors) ? base64_encode(serialize(implode('#', $errors))) : NULL;
        $grievanceStatModel->type = \common\models\GrievanceStat::TYPE_CDSL;
        $grievanceStatModel->total = $success + $failed;
        $grievanceStatModel->success = $success;
        $grievanceStatModel->failed = $failed;
        $grievanceStatModel->save();

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function nsdlImport()
    {
        $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        $fileToImport = fopen($url, 'r');

        $i = 0;
        $row = 0;
        $errors = [];
        $success = 0;
        $failed = 0;

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $srnNo = $line[0];
                $dateOfShares = $line[1];
                $numberShare = $line[2];

                if (empty($srnNo)) {
                    throw new \Exception("Row-{$row}:SRN No {$srnNo} cannot be blank.");
                }

                if (empty($dateOfShares)) {
                    throw new \Exception("Row-{$row}:Date of Share {$dateOfShares} cannot be blank.");
                }

                if (empty($numberShare)) {
                    throw new \Exception("Row-{$row}:Number Of Share {$numberShare} cannot be blank.");
                }

                $model = \common\models\Grievance::findBySrnNo($srnNo, ['status' => [\common\models\Grievance::APPROVED, \common\models\Grievance::PAID], 'resultFormat' => 'object']);

                if (isset($model) && !empty($model) && !empty($model->pay_status)) {
                    if (empty($model->refund_shares) && empty($model->refund_share_date)) {
                        $model->refund_shares = $numberShare;
                        $model->refund_share_date = date('Y-m-d', strtotime($dateOfShares));
                        $model->import_depository_type = 'NSDL';
                        if ($model->pay_status == \common\models\Grievance::STATUS_SHARES_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_SHARE;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_BOTH) {
                            $model->pay_status = \common\models\Grievance::STATUS_PARTIAL_PAID_SHARES_ONLY;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_PARTIAL_PAID_AMOUNT_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_BOTH;
                        }

                        if (!$model->save()) {
                            throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($model, ['header' => '']));
                        }
                        $success = $success + 1;
                    }
                    else {
                        throw new \Exception("Row-{$row}:SRN NO- {$srnNo} already have a refund shares date and refund shares");
                    }
                }
                else {
                    throw new \Exception("Row-{$row}:SRN NO- {$srnNo} with Approved or Paid Status not Found");
                }
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = $e->getMessage();
                continue;
            }
        }

        $grievanceStatModel = new \common\models\GrievanceStat();
        $grievanceStatModel->isNewRecord = TRUE;
        $grievanceStatModel->media_id = $this->mediaId;
        $grievanceStatModel->logs = !empty($errors) ? base64_encode(serialize(implode('#', $errors))) : NULL;
        $grievanceStatModel->type = \common\models\GrievanceStat::TYPE_NSDL;
        $grievanceStatModel->total = $success + $failed;
        $grievanceStatModel->success = $success;
        $grievanceStatModel->failed = $failed;
        $grievanceStatModel->save();

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function amountImport()
    {
        $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        $fileToImport = fopen($url, 'r');

        $i = 0;
        $row = 0;
        $errors = [];
        $success = 0;
        $failed = 0;

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srnNo = $line[0];
                $amount = $line[1];
                $buildDate = $line[2];

                if (empty($srnNo)) {
                    throw new \Exception("Row-{$row}:SRN No {$srnNo} cannot be blank.");
                }

                if (empty($amount)) {
                    throw new \Exception("Row-{$row}:Amount {$amount} cannot be blank.");
                }

                if (empty($buildDate)) {
                    throw new \Exception("Row-{$row}:Build Date {$buildDate} cannot be blank.");
                }


                $model = \common\models\Grievance::findBySrnNo($srnNo, ['status' => [\common\models\Grievance::APPROVED, \common\models\Grievance::PAID], 'resultFormat' => 'object']);

                if (isset($model) && !empty($model) && !empty($model->pay_status)) {
                    if (empty($model->refund_amount) && empty($model->refund_amount_date)) {
                        $model->refund_amount = $amount;
                        $model->refund_amount_date = date('Y-m-d', strtotime($buildDate));
                        $model->is_amount_import = 1;
                        if ($model->pay_status == \common\models\Grievance::STATUS_AMOUNT_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_AMOUNT;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_BOTH) {
                            $model->pay_status = \common\models\Grievance::STATUS_PARTIAL_PAID_AMOUNT_ONLY;
                        }
                        else if ($model->pay_status == \common\models\Grievance::STATUS_PARTIAL_PAID_SHARES_ONLY) {
                            $model->pay_status = \common\models\Grievance::STATUS_PAID_BOTH;
                        }
                        $status = $model->status;
                        $model->status = ($model->status == \common\models\Grievance::APPROVED) ? \common\models\Grievance::PAID : $model->status;

                        if (!$model->save(TRUE, ['refund_amount', 'refund_amount_date', 'is_amount_import', 'pay_status', 'status'])) {
                            throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($model, ['header' => '']));
                        }

                        if ($status == \common\models\Grievance::APPROVED) {

                            //save approved date in activity logs
                            $activitydata = [
                                'grievance_id' => $model->id,
                                'autoallocation' => false,
                                'date' => date('Y-m-d', strtotime($buildDate)),
                                'grievance_status' => \common\models\Grievance::PAID,
                                'created_by' => 62
                            ];

                            $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                            if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                                throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                            }
                        }
                        $transaction->commit();
                        $success = $success + 1;
                    }
                    else {
                        throw new \Exception("Row-{$row}:SRN NO- {$srnNo} already have an refund amount and refund amount date");
                    }
                }
                else {
                    throw new \Exception("Row-{$row}:SRN NO- {$srnNo} with Approved or Paid status not Found");
                }
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        $grievanceStatModel = new \common\models\GrievanceStat();
        $grievanceStatModel->isNewRecord = TRUE;
        $grievanceStatModel->media_id = $this->mediaId;
        $grievanceStatModel->logs = !empty($errors) ? base64_encode(serialize(implode('#', $errors))) : NULL;
        $grievanceStatModel->type = \common\models\GrievanceStat::TYPE_AMOUNT;
        $grievanceStatModel->total = $success + $failed;
        $grievanceStatModel->success = $success;
        $grievanceStatModel->failed = $failed;
        $grievanceStatModel->save();

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function Vrimport()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }
        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {

                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $vrDate = date('Y-m-d', strtotime($line[1]));

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($vrDate)) {
                    throw new \Exception("VR date cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no); //\common\models\Grievance::findBySrnNo($srn_no, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);

                if ($grievanceModel->status === \common\models\Grievance::VR_ASSIGNED) {
                    throw new \Exception("Grievance with srn no {$srn_no} vr status already updated.");
                }
                else if ($grievanceModel->status !== \common\models\Grievance::PENDING) {
                    throw new \Exception("Grievance with srn no {$srn_no} invalid status.");
                }

                $postingDate = strtotime($grievanceModel->posting_date);
                $validPostingDate = strtotime(date('2019-09-20'));

                if ($postingDate < $validPostingDate) {

                    throw new \Exception("Posting date cannot be less than 20 Sep 2019.");
                }

                if (strtotime($vrDate) < $postingDate) {
                    throw new \Exception("VR date cannot be less than posting date.");
                }

                $grievanceModel->dh_id = 62;
                $grievanceModel->status = \common\models\Grievance::VR_ASSIGNED;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save vr data and dr data
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $vrDate,
                    'grievance_status' => \common\models\Grievance::VR_ASSIGNED,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }
                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_VR);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function Drimport()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }
        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = $companyCreatedUpdated = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {

                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $drDate = date('Y-m-d', strtotime($line[1]));

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($drDate)) {
                    throw new \Exception("DR date cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no); //\common\models\Grievance::findBySrnNo($srn_no, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);

                if (!in_array($grievanceModel->status, [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED, \common\models\Grievance::DISCREPANCY])) {
                    throw new \Exception("Grievance with srn no {$srn_no} invalid status.");
                }

                $postingDate = strtotime($grievanceModel->posting_date);
                $validPostingDate = strtotime(date('2019-09-20'));

                if ($postingDate < $validPostingDate) {

                    throw new \Exception("Posting date cannot be less than 20 Sep 2019.");
                }

                if (strtotime($drDate) < $postingDate) {
                    throw new \Exception("DR date cannot be less than posting date.");
                }

                //get vr date
                if ($grievanceModel->status == \common\models\Grievance::VR_ASSIGNED) {
                    $checkForVrDate = \common\models\GrievanceActivityLog::findByGrievanceId($grievanceModel->id, ['selectCols' => ['date'], 'applicationStatus' => \common\models\Grievance::VR_ASSIGNED]);

                    if (strtotime($drDate) < strtotime($checkForVrDate['date'])) {
                        throw new \Exception("Grievance with srn no {$srn_no} DR date cannot be less than VR date.");
                    }

                    $grievanceModel->status = \common\models\Grievance::DR_ASSIGNED;

                    if (!$grievanceModel->save(TRUE, ['status', 'modified_on'])) {
                        throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                    }
                }
                else if ($grievanceModel->status == \common\models\Grievance::DR_ASSIGNED || $grievanceModel->status == \common\models\Grievance::DISCREPANCY) {

                    $checkForDrDate = \common\models\GrievanceActivityLog::findByGrievanceId($grievanceModel->id, ['selectCols' => ['date'], 'applicationStatus' => \common\models\Grievance::DR_ASSIGNED, 'orderBy' => ['date' => SORT_DESC]]);
                    if (strtotime($drDate) == strtotime($checkForDrDate['date'])) {
                        throw new \Exception("Grievance with srn no {$srn_no} DR date alreay updated for same date.");
                    }
                }

                //save vr data and dr data
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $drDate,
                    'grievance_status' => \common\models\Grievance::DR_ASSIGNED,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table

        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_DR);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function ApprovedImport()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {

                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $approved_date = date('Y-m-d', strtotime($line[1]));
                $share_approved = $line[2];
                $amount_appoved = $line[3];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($approved_date)) {
                    throw new \Exception("Approval date date cannot be blank.");
                }

                if (empty($share_approved) && empty($amount_appoved)) {
                    throw new \Exception("Both cannot be blank.");
                }


                $grievanceModel = $this->__findGrievanceModel($srn_no); //\common\models\Grievance::findBySrnNo($srn_no, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);

                if ($grievanceModel->status === \common\models\Grievance::APPROVED) {
                    throw new \Exception("Grievance with srn no {$srn_no} approved status already updated.");
                }
                else if ($grievanceModel->status !== \common\models\Grievance::UNDER_PROCESS) {
                    throw new \Exception("Grievance with srn no {$srn_no} invalid status.");
                }

                $paystatus = 0;
                if (isset($share_approved) && !empty($share_approved)) {
                    $paystatus = 1;
                }
                if (isset($amount_appoved) && !empty($amount_appoved)) {
                    $paystatus = 2;
                }
                if (isset($share_approved) && !empty($share_approved) && isset($amount_appoved) && !empty($amount_appoved)) {
                    $paystatus = 3;
                }

                if (isset($paystatus) && !empty($paystatus)) {
                    $grievanceModel->pay_status = $paystatus;
                }

                $grievanceModel->dh_id = 62;
                $grievanceModel->approved_amount = $amount_appoved;
                $grievanceModel->approved_shares = $share_approved;
                $grievanceModel->status = \common\models\Grievance::APPROVED;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'approved_amount', 'approved_shares', 'pay_status', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $approved_date,
                    'grievance_status' => \common\models\Grievance::APPROVED,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_APPROVED);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function UnderProcessImport()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }
            try {

                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $date = date('Y-m-d', strtotime($line[1]));

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($date)) {
                    throw new \Exception("Approval date date cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->status === \common\models\Grievance::UNDER_PROCESS) {
                    throw new \Exception("Grievance with srn no {$srn_no} underprocess status already updated.");
                }
                else if (!in_array($grievanceModel->status, [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED])) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }

                $grievanceModel->dh_id = 62;
                $grievanceModel->status = \common\models\Grievance::UNDER_PROCESS;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $date,
                    'grievance_status' => \common\models\Grievance::UNDER_PROCESS,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_UNDERPROCESS);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function PaidImport()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $amount_refunded_date = date('Y-m-d', strtotime($line[1]));
                $share_refunded_date = date('Y-m-d', strtotime($line[2]));

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($amount_refunded_date) && !empty($share_refunded_date)) {
                    throw new \Exception("Row- {$row}: Amount and Share both cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->status === \common\models\Grievance::PAID) {
                    throw new \Exception("Grievance with srn no {$srn_no} paid status already updated.");
                }
                else if ($grievanceModel->status !== \common\models\Grievance::APPROVED) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }


                $grievanceModel->dh_id = 62;
                $grievanceModel->status = \common\models\Grievance::PAID;
                $grievanceModel->refund_share_date = !empty($share_refunded_date) ? $share_refunded_date : NULL;
                $grievanceModel->refund_amount_date = !empty($amount_refunded_date) ? $amount_refunded_date : NULL;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'refund_share_date', 'refund_amount_date', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => date('Y-m-d'),
                    'grievance_status' => \common\models\Grievance::PAID,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_PAID);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function VrRejected()
    {
        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $rejected_date = date('Y-m-d', strtotime($line[1]));
                $reason = $line[2];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($rejected_date)) {
                    throw new \Exception("Row- {$row}: Rejected date cannot be blank.");
                }

                if (empty($reason)) {
                    throw new \Exception("Row- {$row}: Reason cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->status === \common\models\Grievance::REJECTED) {
                    throw new \Exception("Grievance with srn no {$srn_no} rejected status already updated.");
                }
                else if ($grievanceModel->status !== \common\models\Grievance::PENDING) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }

                $grievanceModel->dh_id = 62;
                $grievanceModel->status = \common\models\Grievance::REJECTED;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $rejected_date,
                    'comments' => json_encode(['comments' => [$reason]]),
                    'grievance_status' => \common\models\Grievance::REJECTED,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_VR_REJECTED);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function DiscrepancyRejected()
    {

        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $rejected_date = date('Y-m-d', strtotime($line[1]));
                $reason = $line[2];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($rejected_date)) {
                    throw new \Exception("Row- {$row}: Rejected date cannot be blank.");
                }

                if (empty($reason)) {
                    throw new \Exception("Row- {$row}: Reason cannot be blank.");
                }

                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->status === \common\models\Grievance::REJECTED) {
                    throw new \Exception("Grievance with srn no {$srn_no} rejected status already updated.");
                }
                else if ($grievanceModel->status !== \common\models\Grievance::DISCREPANCY) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }

                $grievanceModel->dh_id = 62;
                $grievanceModel->status = \common\models\Grievance::REJECTED;

                if (!$grievanceModel->save(TRUE, ['dh_id', 'status', 'modified_on'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $activitydata = [
                    'grievance_id' => $grievanceModel->id,
                    'autoallocation' => false,
                    'date' => $rejected_date,
                    'comments' => json_encode(['comments' => [$reason]]),
                    'grievance_status' => \common\models\Grievance::REJECTED,
                    'created_by' => 62
                ];

                $grievanceActivityModel = new \common\models\GrievanceActivityLog();
                if (!$grievanceActivityModel->saveActivityLogs($activitydata)) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceActivityModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_DISCRIPENCY_REJECTED);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }
    
    public function ScanImport()
    {

        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $date = date('Y-m-d', strtotime($line[1]));
                $reason = $line[2];
                $comment = $line[3];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($date)) {
                    throw new \Exception("Row- {$row}: Date cannot be blank.");
                }

                if (empty($reason)) {
                    throw new \Exception("Row- {$row}: Reason cannot be blank.");
                }
               
                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->is_scan) {
                    throw new \Exception("Grievance with srn no {$srn_no} scan status already updated.");
                }
                
                else if (!in_array($grievanceModel->status, [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED])) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }

                $grievanceModel->is_scan = 1;

                if (!$grievanceModel->save(TRUE, ['is_scan'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $grievanceScanReviewModel = new \common\models\GrievanceScanReview();
                $grievanceScanReviewModel->isNewRecord = true;
                $grievanceScanReviewModel->grievance_id = $grievanceModel->id;
                $grievanceScanReviewModel->type = \common\models\GrievanceScanReview::TYPE_SCAN;
                $grievanceScanReviewModel->date = $date;
                $grievanceScanReviewModel->reason = json_encode(['comments' => [$reason]]);
                $grievanceScanReviewModel->comment = isset($comment) && !empty($comment) ? $comment : null;
                $grievanceScanReviewModel->created_by = \Yii::$app->user->id;
               
                if (!$grievanceScanReviewModel->save()) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceScanReviewModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_SCAN_IMPORT);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }
    
     public function ReviewImport()
    {

        if (\Yii::$app->params['upload.uploadToS3']) {
            $url = \Yii::$app->amazons3->getPrivateMediaUrl($this->filePath);
        }
        else {
            $url = $this->filePath;
        }

        $fileToImport = fopen($url, 'r');
        $i = $success = $failed = $row = 0;
        $errors = [];

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $srn_no = $line[0];
                $date = date('Y-m-d', strtotime($line[1]));
                $reason = $line[2];
                $comment = $line[3];

                if (strlen($srn_no) > 9 || strlen($srn_no) < 9 || empty($srn_no)) {
                    throw new \Exception("SRN {$srn_no} should be 9 digit and cannot be blank.");
                }

                if (empty($date)) {
                    throw new \Exception("Row- {$row}: Date cannot be blank.");
                }

                if (empty($reason)) {
                    throw new \Exception("Row- {$row}: Reason cannot be blank.");
                }
               
                $grievanceModel = $this->__findGrievanceModel($srn_no);

                if ($grievanceModel->is_review) {
                    throw new \Exception("Grievance with srn no {$srn_no} review status already updated.");
                }
                
                else if (!in_array($grievanceModel->status, [\common\models\Grievance::VR_ASSIGNED, \common\models\Grievance::DR_ASSIGNED])) {
                    throw new \Exception("Grievance with srn no {$srn_no} has invalid status.");
                }

                $grievanceModel->is_review = 1;

                if (!$grievanceModel->save(TRUE, ['is_review'])) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceModel, ['header' => '']));
                }

                //save approved date in activity logs
                $grievanceScanReviewModel = new \common\models\GrievanceScanReview();
                $grievanceScanReviewModel->isNewRecord = true;
                $grievanceScanReviewModel->grievance_id = $grievanceModel->id;
                $grievanceScanReviewModel->type = \common\models\GrievanceScanReview::TYPE_REVIEW;
                $grievanceScanReviewModel->date = $date;
                $grievanceScanReviewModel->reason = json_encode(['comments' => [$reason]]);
                $grievanceScanReviewModel->comment = isset($comment) && !empty($comment) ? $comment : null;
                $grievanceScanReviewModel->created_by = \Yii::$app->user->id;
               
                if (!$grievanceScanReviewModel->save()) {
                    throw new \components\exceptions\AppException(\yii\helpers\Html::errorSummary($grievanceScanReviewModel, [ 'header' => '']));
                }

                $transaction->commit();
                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = "Row-{$row}:" . $e->getMessage();
                $transaction->rollback();
                continue;
            }
        }

        // insert into grievance stat table
        $this->__saveGrivanceStat($errors, $success, $failed, \common\models\GrievanceStat::TYPE_REVIEW_IMPORT);

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    protected function __saveGrivanceStat($errors, $success, $failed, $type)
    {
        $grievanceStatModel = new \common\models\GrievanceStat();
        $grievanceStatModel->isNewRecord = TRUE;
        $grievanceStatModel->media_id = $this->mediaId;
        $grievanceStatModel->logs = !empty($errors) ? base64_encode(serialize(implode('#', $errors))) : NULL;
        $grievanceStatModel->type = $type;
        $grievanceStatModel->total = $success + $failed;
        $grievanceStatModel->success = $success;
        $grievanceStatModel->failed = $failed;
        $grievanceStatModel->save();
    }

    protected function __findGrievanceModel($srn)
    {
        if (($model = \common\models\Grievance::findBySrnNo($srn, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT])) !== null) {
            return $model;
        }
        else {
            throw new \Exception("Oops! You are trying to srn {$srn_no} doesn't exists.");
        }
    }

}
