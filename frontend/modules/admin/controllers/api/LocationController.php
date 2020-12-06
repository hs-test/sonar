<?php

namespace app\modules\admin\controllers\api; 

use Yii;
use app\modules\admin\controllers\AppController;

/**
 * Description of LocationController
 *
 * @author Pawan Kumar
 */
class LocationController extends AppController
{

    public function behaviors()
    {
        $controllerBehaviors = [
            'ajax' => [
                'class' => \components\filters\AjaxFilter::className(),
                'only' => ['get-village', 'get-district','get-discom']
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($controllerBehaviors, parent::behaviors());
    }

    public function actionGetDistrict()
    {
        $stateCode = Yii::$app->request->post('stateCode');
        if (empty($stateCode)) {
            throw new \components\exceptions\AppException("Invalid request.");
        }
        
        $params = [];
        $userGuid = Yii::$app->request->post('userGuid');
        if (!empty($userGuid)) {
            $user = \common\models\User::findByGuid($userGuid);
            if (empty($user) && $user['parent_id']) {
                throw new \components\exceptions\AppException("Invalid request.");
            }
            
            $userLocation = \common\models\UserLocation::findByUserId($user['parent_id'], ['resultCount' => \common\models\caching\ModelCache::RETURN_ALL]);
            $params['inDistrictCode'] = \yii\helpers\ArrayHelper::getColumn($userLocation, 'district_code'); 
            
        }

        $districtArr = \common\models\District::getDistrictList($stateCode, $params);
        $template = $this->renderPartial('/api/location/_dropdown.php', [
            'dropdownArr' => $districtArr,
            'prompt' => 'Select District'
        ]);

        return \components\Helper::outputJsonResponse([
                    'success' => 1,
                    'template' => $template
        ]);
    }

    public function actionGetVillage()
    {
        $districtCode = Yii::$app->request->post('districtcode');
        if (empty($districtCode)) {
            throw new \components\exceptions\AppException("Invalid Request.");
        }

        $villageArr = \common\models\Village::getVillageList($districtCode);
        $template = $this->renderPartial('/api/location/_dropdown.php', [
            'dropdownArr' => $villageArr,
            'prompt' => 'Select Village'
        ]);

        return \components\Helper::outputJsonResponse(['success' => 1, 'template' => $template]);
    }
    
    public function actionGetDiscom()
    {
        $stateCode = Yii::$app->request->post('stateCode');
        if (empty($stateCode)) {
            throw new \components\exceptions\AppException("Invalid request.");
        }

        $params = [];

        $discomCode = '';
        if (Yii::$app->user->hasDiscomMDRole() || Yii::$app->user->hasDiscomNodalOfficerRole()) {
            $discomCode = Yii::$app->user->identity->discom_id;
        }

        $discomArr = \common\models\Discom::getDiscomList(null, ['joinWithUser' => 'innerJoin', 'joinWithUserLocation' => 'innerJoin', 'stateCode' => $stateCode, 'id' => $discomCode]); //\common\models\District::getDistrictList($stateCode, $params);

        $template = $this->renderPartial('/api/location/_dropdown.php', [
            'dropdownArr' => $discomArr,
            'prompt' => 'Select Discom'
        ]);

        return \components\Helper::outputJsonResponse([
                    'success' => 1,
                    'template' => $template
        ]);
    }

}
