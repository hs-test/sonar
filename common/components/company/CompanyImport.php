<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace common\components\company;
use Yii;
/**
 * Description of CompanyImport
 *
 * @author Pawan
 */
class CompanyImport
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

        $fileToImport = fopen($this->filePath, 'r');

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

                if (empty($line[0])) {
                    throw new \Exception("Row-{$row}:CIN {$line[0]} cannot be blank.");
                }

                if (empty($line[1])) {
                    throw new \Exception("Row-{$row}:Company name {$line[1]} cannot be blank.");
                }

                if (empty($line[2])) {
                    throw new \Exception("Row-{$row}:Company Depository {$line[2]} cannot be blank.");
                }

                $companyModel = \common\models\Company::findByCIN(trim($line[0]), ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);

                if (empty($companyModel)) {
                    $companyModel = new \common\models\Company;
                    $companyModel->isNewRecord = TRUE;
                    $companyModel->cin_no = $line[0];
                }

                $companyModel->name = $line[1];
                $companyModel->depository = $line[2];
                $companyModel->created_by = Yii::$app->user->getId();

                if (!$companyModel->save()) {
                    throw new \Exception("Row-{$row}:Error creating company {$line[0]} not found.");
                }

                $success = $success + 1;
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = $e->getMessage();
            }
        }

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

    public function detailsimport()
    {

        $fileToImport = fopen($this->filePath, 'r');

        $i = 0;
        $row = 0;
        $errors = [];
        $success = 0;
        $failed = 0;
        if (count(fgetcsv($fileToImport)) != 5) {
            return [
                'errors' => ['Some coloums are missing or mismatching of Coloumns'],
                'failedRecords' => 0,
                'successRecords' => 0
            ];
        }

        while (($line = fgetcsv($fileToImport)) !== FALSE)
        {
            $row++;
            if ($i == 0) {
                $i++;
                continue;
            }

            try {

                $cinNo = $line[0];
                $contactPerson = $line[1];
                $contactNo = $line[2];
                $email = $line[3];
                $address = $line[4];

                if (empty($cinNo)) {
                    throw new \Exception("Row-{$row}:CIN {$cinNo} cannot be blank.");
                }

                if (empty($contactPerson)) {
                    throw new \Exception("Row-{$row}:Contact Person {$contactPerson} cannot be blank.");
                }

                if (empty($contactNo)) {
                    throw new \Exception("Row-{$row}:Contact Number {$contactNo} cannot be blank.");
                }

                if (empty($email)) {
                    throw new \Exception("Row-{$row}:Email {$email} cannot be blank.");
                }

                if (empty($address)) {
                    throw new \Exception("Row-{$row}:Address {$address} cannot be blank.");
                }

                $companyModel = \common\models\Company::findByCIN(trim($cinNo), ['selectCols' => ['id']]);

                if (empty($companyModel)) {
                    throw new \Exception("Row-{$row}:Company with this CIN NO- {$cinNo} not Found");
                }
                $companyDetailModel = \common\models\CompanyDetails::findByCompanyId($companyModel['id'], ['email' => trim($email)]);

                if (empty($companyDetailModel)) {
                    $companyDetailModel = new \common\models\CompanyDetails;
                    $companyDetailModel->isNewRecord = TRUE;
                    $companyDetailModel->company_id = $companyModel['id'];
                    $companyDetailModel->contact_person = $contactPerson;
                    $companyDetailModel->contact_no = $contactNo;
                    $companyDetailModel->email = $email;
                    $companyDetailModel->address = $address;

                    if (!$companyDetailModel->save()) {
                        throw new \Exception("Row-{$row}:Error creating Company Details with CIN NO- {$cinNo} not found.");
                    }

                    $success = $success + 1;
                }
            }
            catch (\Exception $e) {
                $failed = $failed + 1;
                $errors[] = $e->getMessage();
            }
        }

        return [
            'errors' => $errors,
            'failedRecords' => $failed,
            'successRecords' => $success
        ];
    }

}
