<?php

namespace components;

use Yii;
use yii\base\Component;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AmazonS3 extends Component
{

    public $directory;
    public $dirName;
    public $region;
    public $amazons3Key;
    public $amazons3Secret;
    public $amazons3Bucket;
    public $s3BucketName;
    private $s3Client;
    public $result;
    public $error;

    public function __construct($directory = FALSE, $dirName = NULL, $config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        $this->amazons3Key = Yii::$app->params['amazons3.key'];
        $this->amazons3Secret = Yii::$app->params['amazons3.secret'];
        $this->region = Yii::$app->params['amazons3.region'];

        $bucketName = Yii::$app->params['amazons3.bucket'];

        $this->amazons3Bucket = $bucketName;

        // Instantiate the S3 client with your AWS credentials
        $this->s3Client = new S3Client([
            'credentials' => [
                'key' => $this->amazons3Key,
                'secret' => $this->amazons3Secret
            ],
            'region' => $this->region,
            'version' => 'latest'
        ]);

        if (empty($this->s3BucketName)) {
            $this->s3BucketName = $this->amazons3Bucket;
        }

        parent::init();
    }

    public function getPrivateMediaUrl($mediaPath)
    {

        $parseUrl = parse_url($mediaPath, PHP_URL_PATH);
        $key = ltrim($parseUrl, "/");

        $url_creator = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $this->s3BucketName,
            'ResponseContentDisposition' => 'attachment; filename="logs-"'.date('Y-m-d').'.csv',
            'Key' => $key
        ]);

        $minutes = Yii::$app->params['aws.url.validity.minutes'];
        $request = $this->s3Client->createPresignedRequest($url_creator, "+$minutes minutes");
        
        return (string) $request->getUri();
    }

    public function uploadFile($bucketKeyPath, $absoluteSourceFilePath, $acl = 'public-read')
    {
        try {

            $fileContent = file_get_contents($absoluteSourceFilePath);
            $this->result = $this->s3Client->putObject(array(
                'Bucket' => $this->s3BucketName,
                'Key' => $bucketKeyPath,
                'Body' => $fileContent,
                // 'ACL'    => $acl,
                'CacheControl' => 'max-age=172800',
                'ContentType' => mime_content_type($absoluteSourceFilePath)
            ));

            return $this->result;
        }
        catch (S3Exception $e) {
            $this->error = $e->getMessage();
        }

        return false;
    }

    public function deleteFile($bucketKeyPath)
    {
        try {
            $this->result = $this->s3Client->deleteObject(array(
                'Bucket' => $this->s3BucketName,
                'Key' => $bucketKeyPath,
            ));

            return true;
        }
        catch (S3Exception $e) {
            $this->error = $e->getMessage();
        }

        return false;
    }

    /**
     * 
     * @param type $bucketKeyPathArr [['key' => our Object Key1]['key' => our Object Key1]]
     * @return boolean
     */
    public function deleteMultipleFiles($bucketKeyPathArr)
    {
        try {
            $this->result = $this->s3Client->deleteObjects(array(
                'Bucket' => $this->s3BucketName,
                'Delete' => [
                    'Objects' => $bucketKeyPathArr
                ],
            ));

            return true;
        }
        catch (S3Exception $e) {
            $this->error = $e->getMessage();
        }

        return false;
    }

}
