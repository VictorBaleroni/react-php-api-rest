<?php

namespace Src\core;

use Src\http\Url\Uri;

class Core{
    private $routes = [];
    private $groupMiddlewares = [];
    private $groupPrefix = '';

    public function globalMiddlewares(array $globalMiddlewares){
        foreach($globalMiddlewares as $middlewares){
            $middleware = new $middlewares();
            $middleware->handle();
        }
    }

    public function group(string $prefix, callable $callback, array $middlewares =[]){
        $prevPrefixs = $this->groupPrefix;
        $prevMiddlewares = $this->groupMiddlewares;

        $this->groupPrefix .= $prefix;
        $this->groupMiddlewares = array_merge($this->groupMiddlewares, $middlewares);

        $callback($this);

        $this->groupPrefix = $prevPrefixs;
        $this->groupMiddlewares = $prevMiddlewares;
    }

    public function get(){
    }
    
    public function post(){}

    public function put(){}
    
    public function delete(){}

    private function addRoute($method, $path, $handler, $middlewares){
        $fullPath = $this->groupPrefix . $path;
        $allMiddlewares = array_merge($this->groupMiddlewares, $middlewares);
        
        $this->routes[] = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler,
            'middlewares' => $allMiddlewares
        ];
    }
}
