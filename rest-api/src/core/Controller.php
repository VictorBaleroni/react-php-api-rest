<?php

namespace Src\core;

class Controller{
    public function model($model){
        require '../Src/Model/'.$model.'.php';
        $classe = 'Src\\Model\\'. $model;
        return new $classe;
    }
}
