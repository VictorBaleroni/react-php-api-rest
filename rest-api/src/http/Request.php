<?php

namespace Src\http;

class Request{
    public $method;
    public $uri;
    public $headers;
    public $query;
    public $body;

    public function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->headers = getallheaders();
        $this->query = $_GET;
        $this->body = $this->getBody();
    }

    private function getBody(){
        if ($this->method === 'POST') {
            return $_POST;
        }

        $input = file_get_contents('php://input');
        if (strpos($this->headers['Content-Type'] ?? '', 'application/json') !== false) {
            return json_decode($input, true) ?? [];
        }
        return [];
    }

    public function get($key, $default = null){
        return $this->query[$key] ?? $default;
    }
    
    public function post($key, $default = null){
        return $this->body[$key] ?? $default;
    }
    
    public function header($key, $default = null){
        return $this->headers[$key] ?? $default;
    }
}