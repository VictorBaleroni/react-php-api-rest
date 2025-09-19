<?php

function dd($dump){
    var_dump($dump);
    die();
}

function loadEnv(string $path){
    if(!file_exists($path)){
        throw new \Exception('Env file not exist');
    }
    $contents = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($contents as $content){
        if (str_starts_with(trim($content), '#')) {
            continue;
        }
        list($key, $value) = explode('=', $content, 2);
        
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        $_ENV[$key] = $value;
    }
}