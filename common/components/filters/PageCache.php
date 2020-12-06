<?php

namespace common\components\filters;

use yii\filters\PageCache as BasePageCache;
use Yii;

/**
 * Description of PageCache
 *
 * @author Pawan Kumar
 */
class PageCache extends BasePageCache
{
    public $schoolId;
    public $slug;
    public $duration = 120;

    public function init()
    {
        //adding get params as variations for caching
        if ($this->enabled) {
            $getVars = Yii::$app->request->get();
            if (!empty($getVars)) {
                $this->variations = \yii\helpers\ArrayHelper::merge($this->variations, $getVars);
            }
        }

        if ($this->enabled) {
            $this->schoolId = Yii::$app->school->getId();
        }

        parent::init();
    }

    public function calculateCacheKey()
    {
        $key = '__pageCache';
        $key .= isset($this->schoolId) && $this->schoolId > 0 ? '-school-' . $this->schoolId : '';
        $key .= isset($this->slug) && !empty($this->slug) ? '-page-' . $this->slug : '';

        //used to bust cache for get params. Set in frontend\components\filters\PageCache
        if (is_array($this->variations)) {
            foreach ($this->variations as $value) {
                $key .= "-" . md5($value);
            }
        }
        return $key;
    }

    public function beforeAction($action)
    {
        $parentResult = parent::beforeAction($action);
        
        //Update CSRF token in cached page contents
        if ($this->enabled) {
            $response = Yii::$app->getResponse();
            $csrfToken = Yii::$app->request->csrfToken;
            $response->content = preg_replace('/<meta name="csrf-token" content="(.*==)">/i', '<meta name="csrf-token" content="' . $csrfToken . '" />', $response->content);
        }
        return $parentResult;
    }

}
