<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use common\models\Media;

class UploadForm extends Model
{

    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file','maxFiles' => 10,'extensions' => 'png', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 2097152, 'tooBig' => 'Limit is 2MB'], // <--- here!
        ];
    }
    
     
    public function upload()
    {

        try {

            $uploadDir = \Yii::$app->params['upload.dir'] . "/" . \Yii::$app->params['upload.dir.tempFolderName'];
            $fileName = time() . '_' . $this->file->name;
            $filePath = $uploadDir . '/' . $fileName;
            //$extension = $this->file->extension;
            //saving the file to temporary folder                
            if ($this->file->saveAs($filePath)) {

                $options = [
                    'ProcessLocalFile' => true,
                    'RenameFile' => true,
                ];
                $filePath = \Yii::getAlias('@webroot') . \Yii::$app->params['upload.baseHttpPath.relative'] . '/' . \Yii::$app->params['upload.dir.tempFolderName'] . '/' . $fileName;

                $mediaModel = new \common\models\Media;
                $awsResponse = $mediaModel->processLocalFileAndCreateNewMedia($filePath, $options);

                return $awsResponse['orig'];
            }
        }
        catch (\Exception $ex) {
            $this->addError('file', $ex->getMessage());
            return false;
        }
    }

}
?>