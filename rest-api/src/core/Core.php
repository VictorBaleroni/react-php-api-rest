<?php

namespace Src\core;

use Src\http\Request;
use Src\http\Response;

class Core{
    private $routes = [];
    private $groupMiddlewares = [];
    private $groupPrefix = '';
    private $params = [];
    protected $container;

    public function __construct(){
        $this->container = new Container();    
    }

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

    public function get(string $path, string|callable $handler, array $middlewares = []){
        $this->addRoute('GET', $path, $handler, $middlewares);
    }
    
    public function post(string $path, string|callable $handler, array $middlewares = []){
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, string|callable $handler, array $middlewares = []){
        $this->addRoute('PUT', $path, $handler, $middlewares);
    }
    
    public function delete(string $path, string|callable $handler, array $middlewares = []){
        $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, string|callable $handler, array $middlewares = []){
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
        
        if(preg_match($pattern, $path, $matches)){
            if(count($matches) > 1){
                preg_match_all('/\{([^}]+)\}/', $route['path'], $nameParams);
                array_shift($matches);
                
                $this->params = array_combine($nameParams[1], $matches);
            }
            return true;
        }else{
            return false;
        }
    }

    private function execRoute($route, $request, $response){
        $middlewares = $route['middlewares'];

        $pipeline = array_reduce(array_reverse($middlewares ?? []), 
        function($next, $middlewareClass) use ($request, $response){
            return function() use ($middlewareClass, $next, $request, $response){
                $middleware = new $middlewareClass();
                return $middleware->handle($next, $request);
            };
        }, function() use ($route, $request, $response){
            return $this->execHandler($route['handler'], $request, $response);
        });

        return $pipeline();
    }

    private function execHandler($handler, $request, $response){
        if(is_callable($handler)){
            return $handler($request, $response, $this->params ?? null);
        }

        if(is_string($handler)){
            [$controller, $method] = explode('@', $handler);
            $controllerClass = "../Src/controllers/$controller.php";
            require $controllerClass;

            if(class_exists($controller)){
                $controllerInstance = new $controller();
                //Esse abaixo nao consegue passar arrays como parametros
                //return call_user_func_array([$controllerInstance, $method], $this->params ?? null);
                //Esse abaixo consegue mas nao separa o params direito!
                //return $controllerInstance->$method($this->params ?? null);
                //Esse sim!
                return $this->container->splashParams([$controllerInstance, $method], $this->params);
            }
        }

        throw new \Exception("Handler inválido: " . print_r($handler, true));
    }
}
