<?php

namespace app\modules\admin\controllers;

/**
 * Description of UploadFileController
 *
 * @author Azam
 */
class UploadFileController extends AppController {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors() {
        $controllerBehaviors = [
            'ajax' => [
                'class' => \components\filters\AjaxFilter::className(),
                'only' => ['upload-modal', 'upload'],
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($controllerBehaviors, parent::behaviors());
    }

    public function actionUploadModal() {
        return $this->renderPartial('upload-modal');
    }

    public function actionUpload() {
        $response = ['success' => 0, 'url' => ''];
        if (\Yii::$app->request->isPost) {

            $file = \yii\web\UploadedFile::getInstanceByName('file');

            $uploadDir = \Yii::$app->params['upload.dir'] . "/" . \Yii::$app->params['upload.dir.tempFolderName'];
            $this->createDirectory($uploadDir);
            $fileName = time() . '_' . $file->name;
            $filePath = $uploadDir . '/' . $fileName;
            $extension = $file->extension;

            //saving the file to temporary folder
            if ($file->saveAs($filePath)) {

                $options = [
                    'ProcessLocalFile' => true,
                    'RenameFile' => true
                ];
                $filePath = \Yii::getAlias('@webroot') . \Yii::$app->params['upload.baseHttpPath.relative'] . '/' . \Yii::$app->params['upload.dir.tempFolderName'] . '/' . $fileName;

                $model = new \common\models\Media;
                $awsResponse = $model->processLocalFileAndCreateNewMedia($filePath, $options);

                $response = ['success' => 1, 'extension' => $extension, 'fileName' => $file->name, 'media' => $awsResponse];
            } else {
                $response = ['success' => 0, 'error' => 'Unable to saving image or file.'];
            }
        }

        return \components\Helper::outputJsonResponse($response);
    }

    private function createDirectory($dirPath = "") {
        if ($dirPath != '' && !is_dir($dirPath)) {
            if (!\yii\helpers\FileHelper::createDirectory($dirPath)) {

                \Yii::error('Error creating directory to upload: ' . $dirPath);

                throw new \Exception('Error creating directory to upload');
            }
        }
    }

    public function actionRemoveMedia() {
        if (!\Yii::$app->request->isAjax) {
            throw new \components\exceptions\AppException("Error: Invalid request.");
        }

        $id = (int) \Yii::$app->request->post('id');
        $guid = (string) \Yii::$app->request->post('guid');

        try {
            if ($id > 0) {
                $params = (!empty($guid)) ? ['id' => $id, 'guid' => $guid] : ['id' => $id];
                $mediaModel = \common\models\Media::findOne($params);
                if ($mediaModel === null) {
                    throw new \components\exceptions\AppException("Oops! you trying to delete media doesn't exist.");
                }
                $mediaModel->delete();
                return \components\Helper::outputJsonResponse(['success' => 1]);
            }
            return \components\Helper::outputJsonResponse(['success' => 0]);
        } catch (\Exception $ex) {
            throw new \components\exceptions\AppException("Error:" . $ex->getMessage());
        }
    }

}
