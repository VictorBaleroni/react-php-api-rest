<?php

namespace Src\core;

use ReflectionFunction;
use ReflectionMethod;
use Src\http\Request;

class Container{
    public function splashParams($callback, array $params = []){
        $reflection = is_array($callback) ? new ReflectionMethod($callback[0], $callback[1]) : new ReflectionFunction($callback);
        $args = [];

        foreach($reflection->getParameters() as $param){
            $type = $param->getType();
            $name = $param->getName();

            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();

                if($className === Request::class) {
                    $args[] = new Request();
                }
                // elseif(is_subclass_of($className, \App\Core\Model::class)) {
                //     $id = $params[$name] ?? null;
                //     print_r($params[$name]);
                //     $args[] = $className::find($id);
                // }
                else{
                    $args[] = new $className();
                }
            } else {
                $args[] = $params[$name] ?? null;
            }
        }

        if(is_array($callback)){
            return $reflection->invokeArgs($callback[0], $args);
        }else{
            return $reflection->invokeArgs($args);
        }
    }
}