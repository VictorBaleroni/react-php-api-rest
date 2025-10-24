<?php

namespace Src\http;

class Request{
    public $method;
    public $uri;
    public $headers;
    public $query;
    public $post;
    public $body;

    public function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->headers = getallheaders();
        $this->query = $_GET;
        $this->post = $this->getPost();
        $this->body = $this->getBody();
    }

    private function getPost(){
        if ($this->method === 'POST') {
            return $_POST;
        }
    }

    private function getBody(){
            return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function get($key, $default = null){
        return $this->query[$key] ?? $default;
    }
    
    public function post($key, $default = null){
        return $this->post[$key] ?? $default;
    }

    public function json($key, $default = null){
        return $this->body[$key] ?? $default;
    }
    
    public function header($key, $default = null){
        return $this->headers[$key] ?? $default;
    }
}