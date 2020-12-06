<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\admin\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Description of ImportForm
 *
 * @author Pawan
 */
class ImportForm extends Model
{

    public $file;
    public $filePath;
    public $response;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType' => false, 'maxSize' => 1024 * 1024 * 20],
        ];
    }

    public function upload()
    {
        $this->file = \yii\web\UploadedFile::getInstance($this, 'file');
        if ($this->validate()) {

            $uploadDir = \Yii::$app->params['upload.dir'] . "/" . \Yii::$app->params['upload.dir.tempFolderName'];

            $fileName = time() . '_' . $this->file->name;
            $filePath = $uploadDir . '/' . $fileName;

            if ($this->file->saveAs($filePath)) {
                $options = [
                    'ProcessLocalFile' => true,
                    'RenameFile' => true,
                ];
                $filePath = \Yii::getAlias('@webroot') . \Yii::$app->params['upload.baseHttpPath.relative'] . '/' . \Yii::$app->params['upload.dir.tempFolderName'] . '/' . $fileName;

                $mediaModel = new \common\models\Media;
                $this->response = $mediaModel->processLocalFileAndCreateNewMedia($filePath, $options);

                return TRUE;
            }
        }
        return FALSE;
    }

}
