<?php

namespace components;

use Yii;

/**
 * Description of Helper
 *
 * @author Azam
 */
class Helper
{
    public static function htmlEncode($content)
    {
        $txt = \yii\helpers\Html::encode($content);

        return $txt;
    }
    
    public static function isTestingApplication()
    {
        if (defined('YII_ENV') && YII_ENV === "test") { //strpos(strtolower(Yii::$app->id), 'test')
            return TRUE;
        }

        return FALSE;
    }

    public static function GUIDv4($trim = true)
    {
        // Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
                return trim(com_create_guid(), '{}');
            else
                return com_create_guid();
        }

        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        // Fallback (PHP 4.2+)
        mt_srand((double) microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace .
                substr($charid, 0, 8) . $hyphen .
                substr($charid, 8, 4) . $hyphen .
                substr($charid, 12, 4) . $hyphen .
                substr($charid, 16, 4) . $hyphen .
                substr($charid, 20, 12) .
                $rbrace;
        return $guidv4;
    }

    public static function randomStringToken($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function outputJsonResponse($returnArr = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $returnArr;
    }

    public static function convertModelErrorsToString($errors)
    {
        $errorStr = '';
        foreach ($errors as $attribute => $attributeErrors) {
            $errorStr .= str_replace(".", "", implode(",", $attributeErrors)) . ", ";
        }
        return rtrim($errorStr, ", ");
    }

    public static function cache($key, $value = NULL, $expire = 19800)
    {
        $cache = \Yii::$app->cache;

        // Remove cache if value is false
        if (false === $value) {
            $cache->delete($key);
            return true;
        }

        // check if key exists and return the value
        $isCached = $cache->get($key);
        if ($isCached) {
            return $isCached;
        }

        // set cache
        if ($value) {
            $cache->set($key, $value, $expire); // time in seconds to store cache
            return true;
        }

        return false;
    }
    
    public static function currencyFormat($number)
    {
        $inWords = '';
        if (empty($number)) {
            return $inWords;
        }
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1)
        {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
            }
            else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = ucfirst(implode('', $str));
        $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';

        $inWords = $result . 'Rupees';
        if (!empty($point)) {
            $inWords .= $points . " Paise";
        }

        return $inWords;
    }

}
