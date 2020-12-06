<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\GrievanceForm;
use app\modules\admin\controllers\AppController;
use components\exceptions\AppException;
use common\models\User;

/**
 * Description of ReportController
 *
 * @author Ravi
 */
class ReportController extends AppController
{

    public $_showMis = FALSE;
    public $_showAging = FALSE;
    public $_showStatus = FALSE;
    public $_showPerformance = FALSE;
    public $_showStatusCompare = FALSE;
    public $_url = '';

    public function beforeAction($action)
    {
        if (Yii::$app->user->hasAdminRole() || Yii::$app->user->hasDispatchExecuitveRole() || Yii::$app->user->hasDealingHeadRole() || Yii::$app->user->hasSupervisorRole()) {
            $this->_showMis = TRUE;
            $this->_showAging = TRUE;
            $this->_showStatus = TRUE;
            $this->_showPerformance = TRUE;
            $this->_showStatusCompare = TRUE;
            $this->_url = \yii\helpers\Url::toRoute(['report/mis']);
        }

        Yii::$app->params['activeMenu'] = \frontend\components\Sidebar::REPORT;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->redirect($this->_url);
    }

    public function actionMis()
    {
        if (!$this->_showMis) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }
        $queryParams = \Yii::$app->request->queryParams;
        $searchModel = new \common\models\reports\ReportSearch();

        if (isset($queryParams) && !empty($queryParams)) {
            $searchModel->getRecords = TRUE;
        }

        if (Yii::$app->user->hasDealingHeadRole()) {
            $searchModel->dealingHeadId = Yii::$app->user->id;
        }
        $grievanceModel = $searchModel->search($queryParams);
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $grievanceModel,
            'pagination' => [
                'pageSize' => 20,
                'params' => \Yii::$app->request->queryParams,
            ],
        ]);

        $grievanceList = $provider->getModels();

        if (isset($queryParams['download']) && $queryParams['download']) {
            $this->exportmis($queryParams, $grievanceModel);
        }

        return $this->render('mis', compact('searchModel', 'grievanceList', 'provider'));
    }

    protected function exportmis($queryParams, $grievanceModel)
    {
        if (!isset($queryParams['ReportSearch']) || empty($queryParams['ReportSearch'])) {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/mis']));
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("IEPF Administrator")
                ->setTitle("SRN Details Data Export")
                ->setSubject("SRN Details Data Export")
                ->setDescription("SRN Details Data Export Sheet");

        $last = 'X';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("IEPF"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "SRN Details REPORT");
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getFont()->setBold(true)->setName('Times New Roman')->setSize(12)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Total Records : " . count($grievanceModel));

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'S.NO')
                ->setCellValue('B4', 'POSTING MONTH')
                ->setCellValue('C4', 'SRN NO')
                ->setCellValue('D4', 'DEALING HEAD')
                ->setCellValue('E4', 'NAME OF APPLICANT')
                ->setCellValue('F4', 'DATE OF FILLING IEPF-5')
                ->setCellValue('G4', 'CIN/LLPIN/FCRN')
                ->setCellValue('H4', 'COMPANY NAME')
                ->setCellValue('I4', 'CLAIM AMOUNT')
                ->setCellValue('J4', 'NO OF SHARES CLAIMED')
                ->setCellValue('K4', 'FINANCIAL YEAR')
                ->setCellValue('L4', 'VR RECEIVED OR NOT')
                ->setCellValue('M4', 'DATE OF VERIFICATION RECEIVED')
                ->setCellValue('N4', 'NDSL/CDSL')
                ->setCellValue('O4', 'AMOUNT IMPORT')
                ->setCellValue('P4', 'VR NOT RECEIVED/FRESH CLAIM PENDING/RESUBMITTED PENDING/APPROVED/REJECTED/SENT FOR RESUBMISSION/PAID/UNDER PROCESS')
                ->setCellValue('Q4', 'AMOUNT REFUND')
                ->setCellValue('R4', 'DATE OF AMOUNT REFUND')
                ->setCellValue('S4', 'SHARES REFUND')
                ->setCellValue('T4', 'DATE OF SHARE REFUND')
                ->setCellValue('U4', 'REASON OF REJECTION')
                ->setCellValue('V4', 'LEVEL OF PENDENCY')
                ->setCellValue('X4', 'REMARKS');

        $lastCols = 'X';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

        if (isset($grievanceModel) && !empty($grievanceModel)) {
            $i = 1;
            $counter = 5;
            foreach ($grievanceModel as $grievance) {

                $applicationStatus = \common\models\Grievance::getGrievanceStatusArr(FALSE, TRUE);

                $financial_year = date('Y-m-d', strtotime($grievance['posting_date']));

                $month = date('m', strtotime($grievance['posting_date']));
                $year = date('Y', strtotime($grievance['posting_date']));

                $startDate = ($year - 1) . '-04-01';
                $endDate = $year . '-03-31'; //'31-03-' . $year;
                // echo $startDate.'<br>'.$endDate.'<br>'.$financial_year;die;

                if ($financial_year >= $startDate && $financial_year <= $endDate) {

                    $startYear = date("Y", strtotime(date("Y-m-d", strtotime($financial_year)) . " - 1 year"));
                    $nextYear = date("Y", strtotime(date("Y-m-d", strtotime($financial_year))));
                }
                else {
                    $startYear = date("Y", strtotime(date("Y-m-d", strtotime($financial_year))));
                    $nextYear = date("Y", strtotime(date("Y-m-d", strtotime($financial_year)) . " + 1 year"));
                }

                $rejectionReason = !empty($grievance['rejection_reason']) ? json_decode($grievance['rejection_reason'], TRUE) : '';

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, !empty($grievance['posting_date']) ? date('M', strtotime($grievance['posting_date'])) : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance['srn_no']) ? $grievance['srn_no'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, (isset($grievance['name']) ? $grievance['name'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, (isset($grievance['applicant_name']) ? $grievance['applicant_name'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, (isset($grievance['posting_date']) ? date('d-m-Y', strtotime($grievance['posting_date'])) : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, (isset($grievance['cin_no']) ? $grievance['cin_no'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, (isset($grievance['companyName']) ? $grievance['companyName'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, (isset($grievance['requested_total_amount']) ? $grievance['requested_total_amount'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, (isset($grievance['requested_shares']) ? $grievance['requested_shares'] : ''));
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $startYear . '-' . $nextYear);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, isset($grievance['applicationStatus']) && $grievance['applicationStatus'] == \common\models\Grievance::PENDING ? 'NO' : 'YES');
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, !empty($grievance['vr_received_date']) ? date('d-m-Y', strtotime($grievance['vr_received_date'])) : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, !empty($grievance['import_depository_type']) ? $grievance['import_depository_type'] : '-' );
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, !empty($grievance['is_amount_import']) && ($grievance['is_amount_import'] == '1') ? 'YES' : '-' );
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $applicationStatus[$grievance['applicationStatus']]);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, !empty($grievance['refund_amount']) ? $grievance['refund_amount'] : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, !empty($grievance['refund_amount_date']) ? date('d-m-Y', strtotime($grievance['refund_amount_date'])) : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, !empty($grievance['refund_shares']) ? $grievance['refund_shares'] : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, !empty($grievance['refund_share_date']) ? date('d-m-Y', strtotime($grievance['refund_share_date'])) : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, !empty($rejectionReason) ? implode(',', $rejectionReason['comments']) : '-');
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, '-');
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, '-');

                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/mis', 'ReportSearch' => isset($queryParams['ReportSearch']) ? $queryParams['ReportSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="MIS-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function actionPerformance()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);
        
        if (!$this->_showPerformance) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }

        $queryParams = \Yii::$app->request->queryParams;
        $searchModel = new \common\models\reports\ReportSearch();
        $searchModel->scenario = 'status';
        if (isset($queryParams) && !empty($queryParams)) {
            $searchModel->getRecords = TRUE;
        }
        $grievanceList = $searchModel->performance($queryParams);

        if (isset($queryParams['download']) && $queryParams['download']) {
            $this->exportperformance($queryParams, $grievanceList);
        }

        return $this->render('performance', compact('searchModel', 'grievanceList'));
    }

    public function exportperformance($queryParams, $grievanceList)
    {
        if (!isset($queryParams['ReportSearch']) || empty($queryParams['ReportSearch'])) {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/mis']));
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("IEPF Administrator")
                ->setTitle("PERFORMANCE Data Export")
                ->setSubject("PERFORMANCE Data Export")
                ->setDescription("PERFORMANCE Data Export Sheet");

        $last = 'T';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("IEPF"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "PERFORMANCE REPORT");
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getFont()->setBold(true)->setName('Times New Roman')->setSize(12)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Total Records : " . count($grievanceList));

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A3:' . $last . '3')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);

        // merge cells 
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:E4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:H4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:K4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L4:O4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P4:R4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S4:T4');

        // align center
        $objPHPExcel->getActiveSheet()->getStyle("A4:E4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F4:H4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I4:K4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L4:O4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("P4:R4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("S4:T4")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // set width
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(47.14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(31.43);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(17.43);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(40.57);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(29.29);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(18.43);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(5.14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(13.14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(6.29);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(24.71);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(6.71);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(25);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(40.14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setWidth(34.14);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setWidth(21.29);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setWidth(67.14);



        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'FRESH CLAIMS')
                ->setCellValue('F4', 'RESUBMITTED CLAIM')
                ->setCellValue('I4', 'No. of claim processed')
                ->setCellValue('L4', 'Processed claim bifucation')
                ->setCellValue('P4', 'Pendency')
                ->setCellValue('S4', 'Performance of DH')
                ->setCellValue('A5', 'S.No.')
                ->setCellValue('B5', 'Name of DH')
                ->setCellValue('C5', 'No of claim pending for processing with start of week')
                ->setCellValue('D5', 'Fresh claim alloted during the week')
                ->setCellValue('E5', 'Total Claim (Fresh)')
                ->setCellValue('F5', 'Letter pending for processing during the week')
                ->setCellValue('G5', 'Letters received during the week')
                ->setCellValue('H5', 'Total Letter Pending')
                ->setCellValue('I5', 'New')
                ->setCellValue('J5', 'Resubmitted')
                ->setCellValue('K5', 'Total')
                ->setCellValue('L5', 'Resubmission/ Discrepancy')
                ->setCellValue('M5', 'Approval')
                ->setCellValue('N5', 'rejection')
                ->setCellValue('O5', 'Total')
                ->setCellValue('P5', 'No. of Fresh Claims pending at the end of the week')
                ->setCellValue('Q5', 'Pending of resubmitted claims for processing')
                ->setCellValue('R5', 'Total (claims + letters Pending at end )')
                ->setCellValue('S5', 'Monthly Target Asigned')
                ->setCellValue('T5', '% of Target achieved (of total file processing up to the Month end)=T/S*100');

        $lastCols = 'T';
        $letter = 'A';

        if (isset($grievanceList) && !empty($grievanceList)) {
            $i = 1;
            $counter = 6;
            $sum_fresh_claim_start_week = array_sum(array_column($grievanceList, 'fresh_claim_start_week'));
            $sum_fresh_claim_alloted_week = array_sum(array_column($grievanceList, 'fresh_claim_alloted_week'));
            $sum_total_fresh_claim_alloted_week = array_sum(array_column($grievanceList, 'total_fresh_claim_alloted_week'));
            $sum_resubmitted_claim_start_week = array_sum(array_column($grievanceList, 'resubmitted_claim_start_week'));
            $sum_resubmitted_claim_alloted_week = array_sum(array_column($grievanceList, 'resubmitted_claim_alloted_week'));
            $sum_total_resubmitted_claim_alloted_week = array_sum(array_column($grievanceList, 'total_resubmitted_claim_alloted_week'));
            $sum_claim_processes_new = array_sum(array_column($grievanceList, 'claim_processes_new'));
            $sum_claim_processed_resubmitted = array_sum(array_column($grievanceList, 'claim_processed_resubmitted'));
            $sum_total_claim_processed = array_sum(array_column($grievanceList, 'total_claim_processed'));
            $sum_bifucation_processed_claim_resubmitted_discrepancy = array_sum(array_column($grievanceList, 'bifucation_processed_claim_resubmitted_discrepancy'));
            $sum_bifucation_processed_claim_approved = array_sum(array_column($grievanceList, 'bifucation_processed_claim_approved'));
            $sum_bifucation_processed_claim_rejected = array_sum(array_column($grievanceList, 'bifucation_processed_claim_rejected'));
            $sum_total_bifucation_processed = array_sum(array_column($grievanceList, 'total_bifucation_processed'));
            $sum_resubmitted_claim_start_week = array_sum(array_column($grievanceList, 'resubmitted_claim_start_week'));
            $sum_fresh_claim_end_week = array_sum(array_column($grievanceList, 'fresh_claim_end_week'));
            $sum_resubmitted_claim_end_week = array_sum(array_column($grievanceList, 'resubmitted_claim_end_week'));
            $sum_total_fresh_claim_alloted_end_week = array_sum(array_column($grievanceList, 'total_fresh_claim_alloted_end_week'));
            $sum_monthly_target_assigned = array_sum(array_column($grievanceList, 'monthly_target_assigned'));
            $percentage_target = !empty($sum_total_claim_processed) ? ($sum_total_claim_processed / $sum_monthly_target_assigned) * 100 : 0.00;

            // for align center data
            $ranges = range('A', 'T');
            foreach ($ranges as $range) {
                $objPHPExcel->getActiveSheet()->getStyle($range)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            // loop start
            foreach ($grievanceList as $grievance) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, (isset($grievance['dealingHead']) ? $grievance['dealingHead'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance['fresh_claim_start_week']) ? $grievance['fresh_claim_start_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, (isset($grievance['fresh_claim_alloted_week']) ? $grievance['fresh_claim_alloted_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, (isset($grievance['total_fresh_claim_alloted_week']) ? $grievance['total_fresh_claim_alloted_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, (isset($grievance['resubmitted_claim_start_week']) ? $grievance['resubmitted_claim_start_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, (isset($grievance['resubmitted_claim_alloted_week']) ? $grievance['resubmitted_claim_alloted_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, (isset($grievance['total_resubmitted_claim_alloted_week']) ? $grievance['total_resubmitted_claim_alloted_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, (isset($grievance['claim_processes_new']) ? $grievance['claim_processes_new'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, (isset($grievance['claim_processed_resubmitted']) ? $grievance['claim_processed_resubmitted'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, (isset($grievance['total_claim_processed']) ? $grievance['total_claim_processed'] : ''));
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, (isset($grievance['bifucation_processed_claim_resubmitted_discrepancy']) ? $grievance['bifucation_processed_claim_resubmitted_discrepancy'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, (isset($grievance['bifucation_processed_claim_approved']) ? $grievance['bifucation_processed_claim_approved'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, (isset($grievance['bifucation_processed_claim_rejected']) ? $grievance['bifucation_processed_claim_rejected'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, (isset($grievance['total_bifucation_processed']) ? $grievance['total_bifucation_processed'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, (isset($grievance['fresh_claim_end_week']) ? $grievance['fresh_claim_end_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, (isset($grievance['resubmitted_claim_end_week']) ? $grievance['resubmitted_claim_end_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, (isset($grievance['total_fresh_claim_alloted_end_week']) ? $grievance['total_fresh_claim_alloted_end_week'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, (isset($grievance['monthly_target_assigned']) ? $grievance['monthly_target_assigned'] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, (isset($grievance['percentage_target']) ? $grievance['percentage_target'] : '-'));

                $i++;
                $counter++;
            }
            // loop end
            // for Total
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $counter, 'Total');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $counter, $sum_fresh_claim_start_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $counter, $sum_fresh_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $counter, $sum_total_fresh_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $counter, $sum_resubmitted_claim_start_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $counter, $sum_resubmitted_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $counter, $sum_total_resubmitted_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $counter, $sum_claim_processes_new);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $counter, $sum_claim_processed_resubmitted);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $counter, $sum_total_claim_processed);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $counter, $sum_bifucation_processed_claim_resubmitted_discrepancy);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $counter, $sum_bifucation_processed_claim_approved);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $counter, $sum_bifucation_processed_claim_rejected);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $counter, $sum_total_bifucation_processed);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $counter, $sum_fresh_claim_end_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $counter, $sum_resubmitted_claim_end_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $counter, $sum_total_fresh_claim_alloted_end_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $counter, $sum_monthly_target_assigned);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $counter, number_format((float) $percentage_target, 2, '.', ''));

            // for last row
            $counterLast = $counter + 2;
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $counterLast, $sum_total_fresh_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $counterLast, $sum_total_resubmitted_claim_alloted_week);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $counterLast, $sum_total_claim_processed);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $counterLast, $sum_total_bifucation_processed);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $counterLast, $sum_total_fresh_claim_alloted_end_week);
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/performance', 'ReportSearch' => isset($queryParams['ReportSearch']) ? $queryParams['ReportSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PERFORMANCE-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function actionStatus()
    {
        if (!$this->_showStatus) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }
        $queryParams = \Yii::$app->request->queryParams;

        $searchModel = new \common\models\reports\ReportSearch();
        $searchModel->scenario = 'status';
        if (isset($queryParams) && !empty($queryParams)) {
            $searchModel->getRecords = TRUE;
        }
        $grievanceList = $searchModel->status($queryParams);

        if (isset($queryParams['download']) && $queryParams['download']) {
            $this->exportstatus($grievanceList);
        }

        return $this->render('status', compact('searchModel', 'grievanceList'));
    }

    private function exportstatus($grievanceList)
    {

        if (!isset($grievanceList) || empty($grievanceList)) {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/status']));
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("IEPF Administrator")
                ->setTitle("Status Data Export")
                ->setSubject("Status Data Export")
                ->setDescription("Status Data Export Sheet");

        $last = 'C';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("IEPF"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "STATUS REPORT");
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'S.NO')
                ->setCellValue('B3', 'Particulars')
                ->setCellValue('C3', 'Count');

        $lastCols = 'C';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(61);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if (isset($grievanceList) && !empty($grievanceList)) {
            $i = 1;
            $counter = 4;

            $rows = [
                1 => ['No. of claims filed', $grievanceList['pending']],
                2 => ['No. of Verification Report Received', $grievanceList['vrRecieved']],
                3 => ['No. of Resubmitted Claims Received', $grievanceList['underProcess']],
                4 => ['Claims Paid', $grievanceList['paid']],
                5 => ['Claims Approved (Either share transfer/Amount transfer taken place)', $grievanceList['approved']],
                6 => ['Claims Rejected', $grievanceList['rejected']],
                7 => ['Claims pending (Fresh Claim Pending + Resubmitted claim pending)', $grievanceList['underProcessVrRecieved']],
                8 => ['Claims sent for Resubmission', $grievanceList['discrepancy']],
                9 => ['No. of Discrepancy Mail Sent', $grievanceList['mailSentCount']],
                10 => ['No. of shares Refunded (NSDL)', $grievanceList['nsdlShares']],
                11 => ['No. of shares Refunded (CDSL)', $grievanceList['cdslShares']],
                12 => ['No. of shares Refunded (CDSL+NSDL)', $grievanceList['totalShares']],
                13 => ['Amount Refunded', $grievanceList['refundAmount']],
                14 => ['No. of only amount refunded cases', $grievanceList['onlyAmountRefundCount']],
                15 => ['No. of only shares refunded cases', $grievanceList['onlyShareRefundCount']],
                16 => ['No of cases in which both shared & amount transferred', $grievanceList['bothRefundCount']],
            ];
            foreach ($rows as $grievance) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, (isset($grievance[0]) ? $grievance[0] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance[1]) ? $grievance[1] : '-'));
                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/status', 'ReportSearch' => isset($queryParams['ReportSearch']) ? $queryParams['ReportSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="STATUS-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function actionStatusComparison()
    {
        if (!$this->_showStatusCompare) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }
        $queryParams = \Yii::$app->request->queryParams;

        $grievanceList = [];

        $searchModel = new \common\models\reports\ReportSearch();

        if (isset($queryParams['ReportSearch']) && !empty($queryParams['ReportSearch'])) {
            $searchModel->getRecords = TRUE;
            $firstRange = $this->getGrievanceListrangeWise($searchModel, $queryParams['ReportSearch']['first_date_range']);
            $secondRange = $this->getGrievanceListrangeWise($searchModel, $queryParams['ReportSearch']['second_date_range']);
            $searchModel->first_date_range = $queryParams['ReportSearch']['first_date_range'];
            $searchModel->second_date_range = $queryParams['ReportSearch']['second_date_range'];
        }

        if (isset($firstRange) && isset($secondRange)) {
            $grievanceList['rangeOne'] = $firstRange;
            $grievanceList['rangeTwo'] = $secondRange;
        }

        if (isset($queryParams['download']) && $queryParams['download']) {
            $this->exportstatuscomparison($grievanceList);
        }

        return $this->render('status-comparison', compact('searchModel', 'grievanceList'));
    }

    private function getGrievanceListrangeWise($searchModel, $param)
    {
        $first = substr($param, 0, 10);
        $second = substr($param, 13, 10);
        $queryParams['ReportSearch']['from_date'] = $first;
        $queryParams['ReportSearch']['to_date'] = $second;
        $grievanceList = $searchModel->status($queryParams);
        return $grievanceList;
    }

    private function exportstatuscomparison($grievanceList)
    {

        if (!isset($grievanceList) || empty($grievanceList)) {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/status-comparison']));
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("IEPF Administrator")
                ->setTitle("Status Comparison Data Export")
                ->setSubject("Status Comparison Data Export")
                ->setDescription("Status Comparison Data Export Sheet");

        $last = 'D';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("IEPF"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "STATUS COMPARISON REPORT");
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'S.NO')
                ->setCellValue('B3', 'Particulars')
                ->setCellValue('C3', 'Range One Count')
                ->setCellValue('D3', 'Range Two Count');

        $lastCols = 'D';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);

        // set width
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(6.86);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(64.86);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(18.43);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(18.45);


        // for align center data
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        if (isset($grievanceList) && !empty($grievanceList)) {
            $i = 1;
            $counter = 4;

            $rows = [
                1 => ['No of claims filed', $grievanceList['rangeOne']['pending'], $grievanceList['rangeTwo']['pending']],
                2 => ['No.of Verification Report received', $grievanceList['rangeOne']['vrRecieved'], $grievanceList['rangeTwo']['vrRecieved']],
                3 => ['Claims Paid', $grievanceList['rangeOne']['paid'], $grievanceList['rangeTwo']['paid']],
                4 => ['Claims Approved (Either share transfer/Amount transfer taken place)', $grievanceList['rangeOne']['vrRecieved'], $grievanceList['rangeTwo']['vrRecieved']],
                5 => ['Claims Rejected', $grievanceList['rangeOne']['rejected'], $grievanceList['rangeTwo']['rejected']],
                6 => ['Claims pending (Fresh Claim Pending +Resubmitted claim pending)', $grievanceList['rangeOne']['underProcess'], $grievanceList['rangeTwo']['underProcess']],
                7 => ['Claims sent for Resubmission', $grievanceList['rangeOne']['discrepancy'], $grievanceList['rangeTwo']['discrepancy']],
                8 => ['Number of Discrepancy Mail Sent', $grievanceList['rangeOne']['mailSentCount'], $grievanceList['rangeTwo']['mailSentCount']],
                9 => ['No.of shares Refunded (NSDL)', $grievanceList['rangeOne']['nsdlShares'], $grievanceList['rangeTwo']['nsdlShares']],
                10 => ['No.of shares Refunded (CDSL)', $grievanceList['rangeOne']['cdslShares'], $grievanceList['rangeTwo']['cdslShares']],
                11 => ['No.of shares Refunded (CDSL+NSDL)', $grievanceList['rangeOne']['totalShares'], $grievanceList['rangeTwo']['totalShares']],
                12 => ['Amount Refunded', $grievanceList['rangeOne']['refundAmount'], $grievanceList['rangeTwo']['refundAmount']],
            ];
            foreach ($rows as $grievance) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, (isset($grievance[0]) ? $grievance[0] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance[1]) ? $grievance[1] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, (isset($grievance[2]) ? $grievance[2] : '-'));
                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/status', 'ReportSearch' => isset($queryParams['ReportSearch']) ? $queryParams['ReportSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="STATUS COMPARISON-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function actionAging()
    {
        if (!$this->_showAging) {
            throw new \components\exceptions\AppException("You're not authorized to view this page.");
        }
        $queryParams = \Yii::$app->request->queryParams;

        $searchModel = new \common\models\reports\ReportSearch();

        $grievanceList = $searchModel->aging($queryParams);

        if (isset($queryParams['download']) && $queryParams['download']) {
            $this->exportaging($grievanceList);
        }

        return $this->render('aging', compact('searchModel', 'grievanceList'));
    }

    private function exportaging($grievanceList)
    {

        if (!isset($grievanceList) || empty($grievanceList)) {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/aging']));
        }
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', -1);
        set_time_limit(0);

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator(Yii::$app->params['applicationName'])
                ->setLastModifiedBy("IEPF Administrator")
                ->setTitle("Aging Data Export")
                ->setSubject("Aging Data Export")
                ->setDescription("Aging Data Export Sheet");

        $last = 'C';

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:' . $last . '1');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, ucwords("IEPF"));
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);



        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:' . $last . '2');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "AGING REPORT");
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(15)->getColor()->setRGB('FFFFFF');
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
            ]
        ]);

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $last . '1')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);
        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $last . '2')->getFill()->applyFromArray([
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => '151B54'
        ]]);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'S.NO')
                ->setCellValue('B3', 'Particulars')
                ->setCellValue('C3', 'Count');

        $lastCols = 'C';
        $letter = 'A';
        while ($letter !== $lastCols)
        {
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter++)->setWidth(17);
        }


        $objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCols . '2')->getFont()->setBold(true)->setName('Times New Roman')->setSize(10);

        if (isset($grievanceList) && !empty($grievanceList)) {
            $i = 1;
            $counter = 4;

            $rows = [
                1 => ['Fresh Claims Pending (To be calculated from the Date of Receipt of the Fresh claim)', $grievanceList['freshClaimPending']],
                2 => ['More than 120 Days', $grievanceList['vrgreaterthanonetwenty']],
                3 => ['More than 90 Days', $grievanceList['vrlessthanonetwenty']],
                4 => ['More than 60 Days', $grievanceList['vrlessthanninety']],
                5 => ['More than 30 Days', $grievanceList['vrlessthansixty']],
                6 => ['More than 15 Days', $grievanceList['vrlessthanthirty']],
                7 => ['Equal to or Less than 15 Days', $grievanceList['vrlessthanfifteen']],
                8 => ['Re submitted claims Pending (To be calculated from the Date of Receipt of the Re submitted claims )', $grievanceList['resubmitted']],
                9 => ['More than 120 Days', $grievanceList['drgreaterthanonetwenty']],
                10 => ['More than 90 Days', $grievanceList['drlessthanonetwenty']],
                11 => ['More than 60 Days', $grievanceList['drlessthanninety']],
                12 => ['More than 30 Days', $grievanceList['drlessthansixty']],
                13 => ['More than 15 Days', $grievanceList['drlessthanthirty']],
                14 => ['Equal to or Less than 15 Days', $grievanceList['drlessthanfifteen']],
                15 => ['Verification Report not received (To be calculated from the Date of Posting)', $grievanceList['verificationReportPending']],
                16 => ['More than 120 Days', $grievanceList['pendinggreaterthanonetwenty']],
                17 => ['More than 90 Days', $grievanceList['pendinglessthanonetwenty']],
                18 => ['More than 60 Days', $grievanceList['pendinglessthanninety']],
                19 => ['More than 30 Days', $grievanceList['pendinglessthansixty']],
                20 => ['More than 15 Days', $grievanceList['pendinglessthanthirty']],
                21 => ['Equal to or Less than 15 Days', $grievanceList['pendinglessthanfifteen']],
            ];
            foreach ($rows as $grievance) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, (isset($grievance[0]) ? $grievance[0] : '-'));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, (isset($grievance[1]) ? $grievance[1] : '-'));
                $i++;
                $counter++;
            }
        }
        else {
            \Yii::$app->session->setFlash('error', 'Oops no record found.');
            return $this->redirect(\yii\helpers\Url::toRoute(['report/aging', 'ReportSearch' => isset($queryParams['ReportSearch']) ? $queryParams['ReportSearch'] : '']));
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="AGING-Report.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: no-cache');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    protected function findByModel($guid)
    {
        $model = \common\models\Grievance::findByGuid($guid, ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
        if ($model == null) {
            throw new AppException("Sorry, You trying to access type doesn't exist or deleted.");
        }

        return $model;
    }

}
