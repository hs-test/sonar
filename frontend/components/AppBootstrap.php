<?php

namespace frontend\components;

use Yii;

/**
 * Description of AppBootstrap
 *
 * @author Pawan Kumar
 */
class AppBootstrap implements \yii\base\BootstrapInterface
{

    public function bootstrap($app)
    {
        $pslManager = new \Pdp\PublicSuffixListManager;
        $parser = new \Pdp\Parser($pslManager->getList());
        $hostInfo = $parser->parseHost($app->request->getServerName());
        $domain = $hostInfo->registerableDomain;
        $url = $app->request->absoluteUrl;

        $parsedUrl = $parser->parseUrl($url);

        try {

            $subdomain = $hostInfo->host;
            if (Yii::$app->params['is_ssl'] === 1 && isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'http') {
                $redirectUrl = preg_replace('/^http:/i', 'https:', $url);
                $app->response->redirect($redirectUrl, 301)->send();
                exit;
            }
        }
        catch (\Exception $ex) {
            //print_r($ex->getTraceAsString()); die;
        }
    }

}
