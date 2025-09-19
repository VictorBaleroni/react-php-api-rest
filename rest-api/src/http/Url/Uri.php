<?php

namespace Src\http\Url;

class Uri{
    public static function uri(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public static function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
}