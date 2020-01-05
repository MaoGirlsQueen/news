<?php


namespace app\common\lib\exception;


use think\Exception;


class ApiException extends Exception
{
    public $message = '';
    public $code = 0;
    public $httpCode = 400;


    public function __construct($message = "", $httpCode=0, $code = 0 )
    {

        $this->message = $message;
        $this->code = $code;
        $this->httpCode = $httpCode;
    }
}