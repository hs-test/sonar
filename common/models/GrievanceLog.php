<?php

namespace common\models;

use common\models\base\GrievanceLog as BaseGrievanceLog;

/**
 * Description of GrievanceLog
 *
 * @author Ravi Sikarwar
 */
class GrievanceLog extends BaseGrievanceLog
{

    public $file;


    public function behaviors()
    {

        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
        ];
    }

    
    public function rules()
    {
        $rules = parent::rules();

        $myRules = [

            [['file'], 'file', 'extensions' => 'jpg,png,jpeg,pdf', 'maxSize' => 5242880], //5MB max File Size
        ];

        return array_merge($rules, $myRules);
    }

    /**
     * Function to update model data before record is saved
     * 
     * @param bool $insert
     * @return type
     */
    public function beforeSave($insert)
    {


        //lets check if the file was uploaded, then creating Media record and uploading it to the server.
        if ($this->file instanceof \yii\web\UploadedFile) {


            try {

                $file = $this->file;

                $uploadDir = \Yii::$app->params['upload.dir'] . "/" . \Yii::$app->params['upload.dir.tempFolderName'];
                $fileName = time() . '_' . $file->name;
                $filePath = $uploadDir . '/' . $fileName;
                $extension = $file->extension;

                //saving the file to temporary folder                
                if ($file->saveAs($filePath)) {


                    $options = [
                        'ProcessLocalFile' => true,
                        'RenameFile' => true,
                    ];
                    $filePath = \Yii::getAlias('@webroot') . \Yii::$app->params['upload.baseHttpPath.relative'] . '/' . \Yii::$app->params['upload.dir.tempFolderName'] . '/' . $fileName;

                    $mediaModel = new \common\models\Media;
                    $awsResponse = $mediaModel->processLocalFileAndCreateNewMedia($filePath, $options);
                    $this->media_id = $awsResponse['orig'];
                }
            }
            catch (\Exception $ex) {
                $this->addError('media_file', $ex->getMessage());
                return false;
            }
        }

        return parent::beforeSave($insert);
    }

    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
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

        if (isset($params['guid'])) {
            $modelAQ->andWhere($tableName . '.guid =:guid', [':guid' => $params['guid']]);
        }

        if (isset($params['grievanceId'])) {
            $modelAQ->andWhere($tableName . '.grievance_id =:grievanceId', [':grievanceId' => $params['grievanceId']]);
        }

        if (isset($params['applicationStatus'])) {
            $modelAQ->andWhere($tableName . '.application_status =:applicationStatus', [':applicationStatus' => $params['applicationStatus']]);
        }

        if (isset($params['eligibilityStatus'])) {
            $modelAQ->andWhere($tableName . '.eligibility_status =:eligibilityStatus', [':eligibilityStatus' => $params['eligibilityStatus']]);
        }
        
        if (isset($params['createdBy'])) {
            $modelAQ->andWhere($tableName . '.created_by =:createdBy', [':createdBy' => $params['createdBy']]);
        }

        if (isset($params['stateCode'])) {
            $modelAQ->andWhere($tableName . '.state_code =:state_code', [':state_code' => $params['stateCode']]);
        }

        if (isset($params['joinWithUser']) && in_array($params['joinWithUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUser']}('user', 'grievance_log.created_by = user.id');
        }
        
        if (isset($params['joinWithGrievanceLogUser']) && in_array($params['joinWithGrievanceLogUser'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithGrievanceLogUser']}('user grievanceLogUser', 'grievance_log.created_by = grievanceLogUser.id');
        }

        if (isset($params['joinWithMedia']) && in_array($params['joinWithMedia'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithMedia']}('media', 'media.id = grievance_log.media_id');
        }

        if (isset($params['joinWithComment']) && in_array($params['joinWithComment'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithComment']}('comment', 'comment.grievance_log_id = grievance_log.id');
        }
        if (isset($params['joinWithUserComment']) && in_array($params['joinWithUserComment'], ['innerJoin', 'leftJoin', 'rightJoin'])) {
            $modelAQ->{$params['joinWithUserComment']}('user', 'comment.created_by = user.id');
        }

        if (isset($params['gtCreatedAt'])) {
            $modelAQ->andWhere($tableName . '.created_at >=:gtCreatedAt', [':gtCreatedAt' => $params['gtCreatedAt']]);
        }

        //echo $modelAQ->createCommand()->rawSql;die;
        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

}
