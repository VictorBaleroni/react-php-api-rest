<?php

namespace Src\http;

class Response{
    
    public static function status(int $code = 200){
        return http_response_code($code);
    }

    public static function header(string $key, string $value){
        return header("$key: $value");
    }

    public static function json(array $data){
        self::header('Content-Type', 'application/json');
        echo json_encode($data);
    }
}