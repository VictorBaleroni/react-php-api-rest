<?php

use Src\core\Controller;
use Src\http\Request;

class UserController extends Controller{
    public function get($id = null){
        echo $id;
    }

    public function post(){
        $request = new Request();
        $email = $request->json('email');
        $pass = $request->json('password');
        echo json_encode([$email, $pass]);
    }
    
    public function put($id = null){

    }

    public function delete($id = null){
        
    }
}
