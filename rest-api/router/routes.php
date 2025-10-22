<?php

use Src\http\Request;
use Src\http\Response;
use Src\core\Core;
use Src\Middlewares\CorsMiddleware;

$request = new Request();
$response = new Response();

$core = new Core();

$core->globalMiddlewares([CorsMiddleware::class]);

$core->get('/', HomeController::class);

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