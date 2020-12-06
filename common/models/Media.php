<?php

namespace common\models;

use common\models\base\Media as BaseMedia;
use components\behaviors\FileuploadBehavior;
use Yii;

class Media extends BaseMedia
{
    const RETURN_TYPE_OBJECT = 'object';
    
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_ATTACHMENT = 'attachment';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on'],
                ],
            ],
            \components\behaviors\GuidBehavior::className(),
            FileuploadBehavior::className(),
        ];
    }
    
    public static function findByParams($params = [])
    {
        $modelAQ = static::find();
        
        //Table columns to return in results, string or array
        if(isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select('media.*');
        }
        
        // integer only
        if(isset($params['id'])) {
            $modelAQ->andWhere('media.id = :id', [':id' => (int)$params['id']]);
        }
        
        // string only
        if(isset($params['guid'])) {
            $modelAQ->andWhere('media.guid = :guid', [':guid' => $params['guid']]);
        }
        
        if(isset($params['type']) && !empty($params['type'] )) {
            $modelAQ->andWhere('media.type =:type', [':type' => $params['type']]);
        }
        
        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }

    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }   
    
    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }
    
    public static function getByType($type, $params =[])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['type' => $type], $params));
    }
    
    public function processLocalFileAndCreateNewMedia($localFilePath, $options = [])
    {
        $options["ProcessLocalFile"] = TRUE;
        $options["LocalFilePath"] = $localFilePath;
        return $this->uploadAndCreateNewMedia(new \yii\web\UploadedFile(), $options);
    }

    public function uploadAndCreateNewMedia(\yii\web\UploadedFile $file, $options = array())
    {
        try {

            $mediaIds = [];
            if (\Yii::$app->params['upload.uploadToS3']) {
                (isset($options["ProcessLocalFile"]) && $options["ProcessLocalFile"]) ? $this->processLocalFileAndSaveToS3($options["LocalFilePath"], $options) : $this->uploadAndSaveToS3($file, $options);
            }
            else {
                (isset($options["ProcessLocalFile"]) && $options["ProcessLocalFile"]) ? $this->uploadFile(new \yii\web\UploadedFile(), $options) : $this->uploadFile($file, $options);
            }

            foreach ($this->uploadResponse as $imagePrefix => $image) {

                if (isset($options['mediaModel']) && $options['mediaModel'] instanceof Media) {
                    $mediaClass = get_class($options['mediaModel']);
                    $mediaModel = new $mediaClass();
                }
                else {
                    $mediaModel = new Media();
                }

                $mediaModel->isNewRecord = TRUE;

                if (Yii::$app->params['upload.uploadToS3']) {
                    $mediaModel->cdn_path = $image['s3Result']['ObjectURL'];
                }
                else {
                    $mediaModel->cdn_path = \Yii::$app->params['upload.baseHttpPath'] . '/' . $image['localRelativePath'];
                }
             
                $mediaModel->media_type = self::TYPE_ATTACHMENT;
                $mediaModel->filepath = $image['localRelativePath'];
                if ($image['isImage']) {
                    $mediaModel->media_type = self::TYPE_IMAGE;
                }
                if (!$mediaModel->save()) {
                    throw new \Exception('Error creating Media record.');
                }

                $mediaIds[$imagePrefix] = $mediaModel->id;
                $mediaIds['uniqueName'] = $image['uniqueFileName'];
                $mediaIds['cdnPath'] = $mediaModel->cdn_path;
                $mediaIds['guid'] = $mediaModel->guid;
            }

            // lets delete the source files if we are uploading it to CDN
            if (\Yii::$app->params['upload.deletelocalfile.afterUploadToS3'] && Yii::$app->params['upload.uploadToS3']) {
                foreach ($this->uploadResponse as $imagePrefix => $image) {
                    if (isset($image['s3Result']['ObjectURL']) && !empty($image['s3Result']['ObjectURL']) && is_file($image['localAbsFilePath'])) {
                        $this->deleteLocalFile($image['localRelativePath']);
                    }
                }
            }
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $mediaIds;
    }

}
