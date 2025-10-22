<?php

namespace Src\core;

use Src\http\Request;
use Src\http\Response;
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

    public function get(string $path, string $handler, array $middlewares = []){
        $this->addRoute('GET', $path, $handler, $middlewares);
    }
    
    public function post(string $path, string $handler, array $middlewares = []){
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, string $handler, array $middlewares = []){
        $this->addRoute('PUT', $path, $handler, $middlewares);
    }
    
    public function delete(string $path, string $handler, array $middlewares = []){
        $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, string $handler, array $middlewares = []){
        $fullPath = $this->groupPrefix . $path;
        $allMiddlewares = array_merge($this->groupMiddlewares, $middlewares);
        
        $this->routes[] = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler,
            'middlewares' => $allMiddlewares
        ];
    }

    public function dispatch(Request $request, Response $response){
        $method = $request->method;
        $path = $request->uri;

        foreach($this->routes as $route){
            if($this->matchRoute($route, $method, $path)){
                return $this->execRoute($route, $request, $response);
            }
        }
        
        $response->status(404);
        return $response->json(['error' => 'Página não encontrada']);
    }

    private function matchRoute(array $route, string $method, string $path){
        if ($route['method'] !== $method) {
            return false;
        }
        
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
        $pattern = "#^$pattern$#";
        
        return preg_match($pattern, $path);
    }

    private function execRoute($route, $request, $response){
        //
    }
}
