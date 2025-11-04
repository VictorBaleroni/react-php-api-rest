<?php

use Src\core\Controller;
use Src\http\Request;
use Src\models\Users;

class UserController extends Controller{
    public function get($id = null){
         $search = Users::where('name', 'victor2')->first();
        
         print_r($search);
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
