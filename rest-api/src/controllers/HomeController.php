<?php

use Src\core\Controller;
use Src\http\Request;
use Src\http\Response;

class HomeController extends Controller{
    public function index(){
        Response::json(['Bem vindo a API']);
    }
}