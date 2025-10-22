<?php

namespace Src\http;

class Response{
    
    public function status(int $code = 200){
        return http_response_code($code);
    }

    public function header(string $key, string $value){
        return header("$key: $value");
    }

    public function json(array $data){
        $this->header('Content-Type', 'application/json');
        echo json_encode($data);
    }
}