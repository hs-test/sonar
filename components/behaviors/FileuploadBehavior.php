<?php

namespace components\behaviors;

use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use components\exceptions\AppException;

/**
 * Description of FileuploadBehavior
 *
 * @author Azam
 */
class FileuploadBehavior extends Behavior
{

    const DIRECTORY_LIMITER = 2000;
    const DIR_MODE = 0755;

    public $uploadDir;
    public $uploadResponse;
    public $localRelativePath;
    public $localAbsFilePath;
    public $uniqueFileName;
    public $imageProperties;
    public $isImage;
    public $appendedDir;
    public $dirPath;
    public $s3Result;
    
    const RESOURCE_TYPE_IMAGE = 'image';
    const RESOURCE_TYPE_VIDEO = 'video';
    const RESOURCE_TYPE_AUDIO = 'audio';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->uploadResponse = [];
        $this->isImage = false;

        if (empty($this->uploadDir)) {
            $this->uploadDir = \Yii::$app->params['upload.dir'];
        }
    }

    /**
     * Function to upload file to local storage and also put it to s3 at the same time
     * 
     * @param \yii\web\UploadedFile $attribute
     */
    public function uploadAndSaveToS3(\yii\web\UploadedFile $attribute, $options = array())
    {
        if ($this->uploadFile($attribute, $options)) {

            foreach ($this->uploadResponse as $imagePrefix => $image) {

                if (isset($options['delete_orig']) && $options['delete_orig'] == 1 && $imagePrefix == 'orig') {
                    continue;
                }

                //uploading the file to S3 Bucket
                $s3Result = $this->uploadFiletoS3($image['localAbsFilePath'], $image['localRelativePath']);
                if ($s3Result !== FALSE) {
                    $image['s3Result'] = $s3Result;
                    $this->uploadResponse[$imagePrefix] = $image;
                }
            }

            return true;
        }

        return false;
    }

    public function processLocalFileAndSaveToS3($localFilePath, $options = array())
    {
        $options["ProcessLocalFile"] = TRUE;
        $options["LocalFilePath"] = $localFilePath;

        return $this->uploadAndSaveToS3(new \yii\web\UploadedFile(), $options);
    }
    
    /**
     * Function to upload file to local storage and also put it to cloudinary at the same time
     * 
     * @param \yii\web\UploadedFile $attribute
     */
    public function uploadAndSaveToCloudinary(\yii\web\UploadedFile $attribute, $options = array())
    {
        if ($this->uploadFile($attribute, $options)) {
            foreach ($this->uploadResponse as $imagePrefix => $image) {
                $options['resourceType'] = (isset($image['isVideo']) && $image['isVideo']) ? self::RESOURCE_TYPE_VIDEO : self::RESOURCE_TYPE_IMAGE;
                //uploading the file to Cloudinary
                $cloudinaryResult = $this->uploadFileToCloudinary($image['localAbsFilePath'], $options);
                         
                if ($cloudinaryResult !== FALSE) {
                    $image['cloudinaryResult'] = $cloudinaryResult;
                    $this->uploadResponse[$imagePrefix] = $image;
                }
            }
            
            return true;
        }
        
        return false;
    }
    
    public function uploadRemoteFileToCloudinary($remoteFileUrl, $options = array())
    {
        //uploading the file to Cloudinary
        if(isset($options['croppingOptions']) && is_array($options['croppingOptions'])) {
            $cloudinaryResult = $this->uploadCropFileToCloudinary($remoteFileUrl, $options['croppingOptions']);
        }
        else {
            $options['mediaType'] = (isset($options['mediaType']) && !empty($options['mediaType'])) ?  $options['mediaType'] : self::RESOURCE_TYPE_IMAGE;
            $cloudinaryResult = $this->uploadFileToCloudinary($remoteFileUrl, $options);
        }

        if ($cloudinaryResult !== FALSE) {
            
            $fileName = basename($remoteFileUrl);
            
            $this->uploadResponse['orig'] = [
                'origFileName' => $fileName,
                'uniqueFileName' => $fileName,
                'localRelativePath' => '',
                'localAbsFilePath' => '',
                'fileSize' => $cloudinaryResult['bytes'],
                'uploaded' => TRUE,
                'isImage' => ($cloudinaryResult['resource_type'] == 'image') ? true : false,
                'isVideo' => ($cloudinaryResult['resource_type'] == 'video') ? true : false,
                'imageProperties' => [],
                's3Result' => null,
                'cloudinaryResult' => $cloudinaryResult
            ];
            
            if ($cloudinaryResult['resource_type'] == 'image') {
                $this->uploadResponse['orig']['imageProperties'] = getimagesize($cloudinaryResult['url']);
            }
            
            return true;
        }
        
        return false;
    }
    
    public function processLocalFileAndSaveToCloudinary($file, $options = array())
    {
        $options["ProcessLocalFile"] = TRUE;
        
        return $this->uploadAndSaveToCloudinary($file, $options);
    }
    
    /*Cloudinary*/
    public function uploadFileToCloudinary($localFilePath, $options = [])
    {    
        $cloudName = ['cloudName' => \Yii::$app->params['cloudinary.cloudName']];
        $options['resource_type'] = (isset($options['resourceType']) && !empty($options['resourceType'])) ?  $options['resourceType'] : self::RESOURCE_TYPE_IMAGE;
        
        $result = \Yii::$app->cloudinary->uploadFile($localFilePath, $options);
        
        
        if ($result === false) {
            
            ob_start();
            debug_print_backtrace();
            $trace = ob_get_contents();
            ob_end_clean();
            
            \Yii::error('Error uploading to Cloudinary:' . \Yii::$app->cloudinary->error . ', Trace: ' . $trace);
            throw new \Exception('Error saving file to remote CDN');
        }
        
        //incase of video, lets get the thumbnail image and save it as media record and public_id as Video ID
        if ($result['resource_type'] == 'video') {
            $cloudinaryVideoResult = $result;
            $thumbnailPath = cl_video_thumbnail_path($cloudinaryVideoResult['public_id']);
            
            $result = \Yii::$app->cloudinary->uploadFile($thumbnailPath, ['resource_type' => self::RESOURCE_TYPE_IMAGE]);
            if ($result === false) {
                ob_start();
                debug_print_backtrace();
                $trace = ob_get_contents();
                ob_end_clean();

                \Yii::error('Error uploading to Cloudinary:' . \Yii::$app->cloudinary->error . ', Trace: ' . $trace);
                throw new \Exception('Error saving file to remote CDN');
            }
            $result['cloudinaryVideoDetails'] = $cloudinaryVideoResult;
        }
        
        return \yii\helpers\ArrayHelper::merge($result, $cloudName);
    }
    
    public function uploadCropFileToCloudinary($existingImageUrl, $croppingOptions)
    {    
        $cloudName = ['cloudName' => \Yii::$app->cloudinary->cloudName];
        $result = \Yii::$app->cloudinary->cropAndUploadFile($existingImageUrl, $croppingOptions);
        
        if ($result === false) {
            \Yii::error('Error uploading to Cloudinary:' . \Yii::$app->cloudinary->error);
            
            throw new \Exception('Error saving file to remote CDN');
        }
        
        return \yii\helpers\ArrayHelper::merge($result, $cloudName);
    }
    
    public function deleteFileFromCloudinary($publicId)
    {
        return \Yii::$app->cloudinary->deleteFile($publicId);
    }

    public function uploadFile(\yii\web\UploadedFile $attribute, $options = array())
    {
        //lets create the directory structure
        $this->_createDirectoryByLimiter();
        
        if(isset($options['appendedDir']) && !empty($options['appendedDir'])) {
            $this->appendedDir = $options['appendedDir'];
        }
        if(isset($options['dirPath']) && !empty($options['dirPath'])) {
            $this->dirPath = $options['dirPath'];
        }
        
        if (!isset($options['ProcessLocalFile'])) { 
            
            $uniqueFileName = $this->generateRandomFileName($this->dirPath, $attribute->extension);
            $origLocalAbsFilePath = $this->dirPath . DIRECTORY_SEPARATOR . $uniqueFileName;
            $origFileName = $attribute->name;
            $type = explode('/',$attribute->type);
            $fileType = $type[0];
            $renamePrefix = '';
            
            //save file to local server
            if (!$attribute->saveAs($origLocalAbsFilePath)) {

                \Yii::error('Error saving file:' . $uniqueFileName . ' to dir: ' . $this->dirPath);

                throw new \Exception('Error saving file');
            }
        }
        else if ($options['ProcessLocalFile'] && is_file($options['LocalFilePath'])) {
            
            $filePathInfo = pathinfo($options['LocalFilePath']);
            
            $renamePrefix = (isset($options['RenamePrefix'])) ? $options['RenamePrefix'].'_' : '';
            $uniqueFileName = (isset($options['RenameFile']) && $options['RenameFile'] === FALSE) ? (isset($options['uniqueName']) ? $options['uniqueName'] : $filePathInfo['basename']) : $this->generateRandomFileName($this->dirPath, $filePathInfo['extension']);  
            $origLocalAbsFilePath = $this->dirPath . DIRECTORY_SEPARATOR .$renamePrefix.$uniqueFileName;
            $origFileName = $filePathInfo['basename'];
            $type = explode('/',$attribute->type);
            $fileType = $type[0];
            
            if (isset($options['delete_orig']) && $options['delete_orig'] == 1) {
                //lets move the source file
                rename($options['LocalFilePath'], $origLocalAbsFilePath);
            }
            else {
                //lets make a copy of the source file
                copy($options['LocalFilePath'], $origLocalAbsFilePath);
            }    
        }
        
        //local relative path
        $localRelativePath = $this->appendedDir . '/' . $renamePrefix.$uniqueFileName;
        
        $this->uploadResponse['orig'] = [
            'origFileName' => $origFileName,
            'uniqueFileName' => $uniqueFileName,
            'localRelativePath' => $localRelativePath,
            'localAbsFilePath' => $origLocalAbsFilePath,
            'fileSize' => filesize($origLocalAbsFilePath),
            'uploaded' => TRUE,
            'isImage' => ($fileType == self::RESOURCE_TYPE_IMAGE) ? true : false,
            'isVideo' => ($fileType == self::RESOURCE_TYPE_VIDEO) ? true : false,
            'imageProperties' => [],
            's3Result' => null,
            'cloudinaryResult' => null
        ];
        
        //lets go through all the resize array and create thumbnails
        if ( is_array($options) && isset($options['resize']) && is_array($options['resize']) ) {
            
            foreach ($options['resize'] as $imagePrefix => $resizeDimensions) {
                
                $thumbFileName = $imagePrefix . '_' . $uniqueFileName;
                $thumbLocalAbsFilePath = $this->dirPath . DIRECTORY_SEPARATOR . $thumbFileName;
                $thumbLocalRelativePath = $this->appendedDir . '/' . $thumbFileName;
                
                Image::thumbnail($origLocalAbsFilePath, $resizeDimensions['w'], $resizeDimensions['h'])
                    ->save($thumbLocalAbsFilePath/*, ['quality' => 80]*/);
                
                $this->uploadResponse[$imagePrefix] = [
                    'origFileName' => $origFileName,
                    'uniqueFileName' => $thumbFileName,
                    'localRelativePath' => $thumbLocalRelativePath,
                    'localAbsFilePath' => $thumbLocalAbsFilePath,
                    'fileSize' => filesize($thumbLocalAbsFilePath),
                    'uploaded' => TRUE,
                    'isImage' => false,
                    'imageProperties' => [],
                    's3Result' => null,
                    'cloudinaryResult' => null
                ];
            }
        }
        
        //if we have thumbnails
        foreach ($this->uploadResponse as $imagePrefix => $image) {
            if(($imageProperties = getimagesize($image['localAbsFilePath']))) {
                $image['isImage'] = true;
                $image['isVideo'] = false;
                $image['imageProperties'] = $imageProperties;
                
                $this->uploadResponse[$imagePrefix] = $image;
            }
        }
        
        return true;
    }

    /**
     * Function to upload a local file to Amazon S3
     * @param type $localFilePath
     * @param type $s3PathUniqueKey
     * 
     * @throws \Exception
     */
    public function uploadFiletoS3($localFilePath, $s3PathUniqueKey)
    {
        $s3Result = \Yii::$app->amazons3->uploadFile($s3PathUniqueKey, $localFilePath);
        if ($s3Result === false) {
            throw new AppException("Oops! While saving file to remote CDN occur error. error:" . \Yii::$app->amazons3->error);
        }
        return $s3Result;
    }

    public function deleteFileFromS3($s3PathUniqueKey)
    {
        return \Yii::$app->amazons3->deleteFile($s3PathUniqueKey);
    }

    public function deleteLocalFile($relativeFilePath)
    {
        $filePath = $this->uploadDir . '/' . $relativeFilePath;
        @unlink($filePath);
    }

    private function _createDirectoryByLimiter()
    {
        $this->appendedDir = date('Y/M/d');
        $this->dirPath = $this->uploadDir . '/' . $this->appendedDir;
        $this->createDirectory($this->dirPath);
    }

    private function createDirectory($dirPath = "")
    {
        if ($dirPath != '' && !is_dir($dirPath)) {
            if (!FileHelper::createDirectory($dirPath)) {

                \Yii::error('Error creating directory to upload: ' . $dirPath);

                throw new \Exception('Error creating directory to upload');
            }
        }
    }

    public function generateRandomFileName($dirPath, $extension, $fileNameLength = 20, $prefix = '')
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        while (true)
        {
            $randomString = '';

            for ($i = 0; $i < $fileNameLength; $i++) {
                $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            if (!file_exists($dirPath . DIRECTORY_SEPARATOR . $randomString . $extension)) {
                break;
            }
        }


        return $randomString . "." . $extension;
    }
}
