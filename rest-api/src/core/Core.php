<?php

namespace Src\core;

use Src\http\Url\Uri;

class Core{
    private $routes;
    private $uri;
    private $urlMethod;
    protected $controller = '';
    protected $method = '';
    protected $params = [];

    public function __construct($routes){
        $this->routes = $routes;
        $this->uri = Uri::uri();
        $this->urlMethod = Uri::getMethod();
        $this->getController($this->uri);

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function getController($url){
        if(!empty($url)){
           foreach($this->routes as $path => $sepController){
                if($path == $this->urlMethod){
                    foreach($sepController as $key => $value){
                        $pattern = '#^'.preg_replace('/{id}/', '(\w+)', $key).'$#';

                        if(preg_match($pattern, $url, $matches)){
                            $this->getParams($matches);
                            [$this->controller, $this->method] = explode('@', $value);
                            break;
                        }
                    }
                }
           }
           $controllerPath = '../Src/Controllers/' . $this->controller . '.php';

            if(file_exists($controllerPath)){
                require $controllerPath;
                
                if(class_exists($this->controller)){
                    $this->controller = new $this->controller();
                }else{
                    throw new \Exception("O Controller {$this->controller} não encontrado.");    
                }
            }else{
                throw new \Exception("Arquivo não encontrado.");
            }
        }
    }

    private function getParams($params){
        if(count($params) > 1){
            $this->params = array_slice($params, 1);
        }
    }
}
