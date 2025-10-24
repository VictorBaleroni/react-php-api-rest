<?php

use Src\http\Request;
use Src\http\Response;
use Src\core\Core;
use Src\Middlewares\CorsMiddleware;

$request = new Request();
$response = new Response();

$core = new Core();

$core->globalMiddlewares([CorsMiddleware::class]);

$core->get('/', 'HomeController@index');
$core->get('/user/{id}', 'UserController@get');
$core->post('/userpost', 'UserController@post');
$core->get('/test/{id}', function(Request $request, $id){
    echo $id;
});

try{
    $core->dispatch($request, $response);
} catch(Exception $e){
    $errResp = new Response();
    $errResp->status(500);
    $errResp->json([
        'error' => 'Erro interno do servidor!',
        'message' => $e->getMessage()
    ]);
}