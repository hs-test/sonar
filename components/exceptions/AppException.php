<?php

namespace components\exceptions;

/**
 * Description of AppException
 *
 * @author Pawan Kumar
 */
class AppException extends \yii\base\UserException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
