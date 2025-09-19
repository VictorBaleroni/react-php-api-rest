<?php

$routes = [
    "GET" => [
        "/" => "HomeController@index",
        "/user" => "UserController@get"
    ],
    "POST" => [
        "/post" => "UserController@post"
    ]
];