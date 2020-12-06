<?php

namespace console\controllers;

use Yii;

/**
 * Description of CommonController
 *
 * @author Ravi
 */
class CommonController extends \yii\console\Controller
{

    public function actionIndex()
    {
        $grievanceModel = \common\models\Grievance::find()->select(['grievance_no', 'grievance.id'])->asArray()->all();
        if (!empty($grievanceModel)) {

            foreach ($grievanceModel as $grievance) {

                if (empty($grievance['grievance_no'])) {
                    continue;
                }
                $splitGrievanceNo = explode('/', $grievance['grievance_no']);
                $discomCode = $splitGrievanceNo[2];
                $discomModel = \common\models\Discom::findByDiscomCode($discomCode, ['selectCols' => 'id']);
                if (!empty($discomModel)) {

                    \common\models\Grievance::updateAll([
                        'discom_id' => $discomModel['id'],
                            ], 'id =:id', [':id' => $grievance['id']]);
                }
            }
        }
    }
    
    public function actionUpdateGrievance()
    {
        $grievanceModel = \common\models\Grievance::find()->select(['grievance_no', 'grievance.id','state_code','district_code'])->asArray()->all();
      
        if (!empty($grievanceModel)) {
            foreach ($grievanceModel as $grievance) {
                if (empty($grievance['grievance_no'])) {
                    continue;
                }
                if (empty($grievance['state_code']) && empty($grievance['district_code'])) {
                    continue; //throw new \components\exceptions\AppException("Invalid state code - {$this->state_code}.");
                }
                $user = \common\models\UserLocation::findByStateCode($grievance['state_code'], [
                            'selectCols' => ['user_location.*', 'user.discom_id'],
                            'districtCode' => $grievance['district_code'],
                            'joinUser' => 'innerJoin',
                            'roleId' => \common\models\User::ROLE_DISCOM_MD,
                            'resultFormat' => 'array'
                ]);

                if (empty($user) || empty($user['discom_id'])) {
                    continue;//throw new \components\exceptions\AppException("Oops! No Discom md user available to this district or state.");
                }

                $discom = \common\models\Discom::findById($user['discom_id']);
                if (empty($discom)) {
                    continue; //throw new \components\exceptions\AppException("Oops! No Discom exist or inactive our system.");
                }

                $splitGrievanceNo = explode('/', $grievance['grievance_no']);
                $newGrievanceNo = $splitGrievanceNo[0] . '/' . $splitGrievanceNo[1] . '/' . $discom['discom_code'] . '/' . $splitGrievanceNo[3] . '/' . $splitGrievanceNo[4];
               
                $grievanceObj  = \common\models\Grievance::findById($grievance['id'],['resultFormat'=>  \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
                $grievanceObj->sendMessage = FALSE;
                $grievanceObj->discom_id = $discom['id'];
                $grievanceObj->grievance_no = $newGrievanceNo;
                $grievanceObj->save(TRUE,['grievance_no','discom_id']);
            }
        }
    }


    public function actionResetPassword()
    {
        $cpmPassword = 'cpm@1234';
        $recNodal = 'nodal@1234';
        $discomMd = 'discommd@1234';
        $discomNodalOfficer = 'discomnodal@1234';

        echo 'cpm : ' . Yii::$app->security->generatePasswordHash($cpmPassword) . '<br>';
        echo 'recNodal : ' . Yii::$app->security->generatePasswordHash($recNodal) . '<br>';
        echo 'discomMd : ' . Yii::$app->security->generatePasswordHash($discomMd) . '<br>';
        echo 'discomNodalOfficer : ' . Yii::$app->security->generatePasswordHash($discomNodalOfficer) . '<br>';

        //$recNodal = $discomMd = $discomNodalOfficer = '';
    }
    
    public function actionUploadS3()
    {

        $mediaModel = \common\models\Media::find()->select(['media.filepath', 'media.id'])->where('media.image_processed=:isProcessed', [':isProcessed' => 0])->asArray()->all();

        $mediaList = [];
        if (!empty($mediaModel)) {
            $i = 0;
            foreach ($mediaModel as $media) {

                $imgSavePath = dirname(dirname(__DIR__)) . '/frontend/web/uploads/' . $media['filepath'];
                if (!file_exists($imgSavePath)) {
                    continue;
                }

                $s3FilePath = $media['filepath'];
                $s3Result = \Yii::$app->amazons3->uploadFile($s3FilePath, $imgSavePath);
                if ($s3Result === false) {
                    continue;
                }
                $mediaList[$i]['id'] = $media['id'];
                $mediaList[$i]['cdnPath'] = $s3Result['ObjectURL'];
                $i++;
            }
        }

        if (!empty($mediaList)) {
            $success = 1;
            foreach ($mediaList as $medias) {
                $mediaObj = \common\models\Media::findById($medias['id'], ['resultFormat' => \common\models\caching\ModelCache::RETURN_TYPE_OBJECT]);
                if (!$mediaObj !== NULL) {
                    $mediaObj->cdn_path = $medias['cdnPath'];
                    $mediaObj->image_processed = 1;
                    $mediaObj->save(TRUE, ['cdn_path','image_processed']);
                    $success++;
                }
            }
        }
        
        return 'Total Records Success' . $success;
    }
    
    

}
