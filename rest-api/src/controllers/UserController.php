<?php

use Src\core\Controller;

class UserController extends Controller{
    public function get(){
        echo 'get';
    }

    public function post(){
        echo 'post';
    }
    
    public function put($id){
        echo $id;
    }
}
