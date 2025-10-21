<?php

use Src\core\Core;
use Src\Middlewares\CorsMiddleware;

$core = new Core();

$core->globalMiddlewares([CorsMiddleware::class]);

$core->get();