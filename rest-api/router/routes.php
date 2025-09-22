<?php

// ! /api/user

$routes = [
    "GET" => [
        "/" => "HomeController@index",
        "/user" => "UserController@get"
    ],
    "POST" => [
        "/post" => "UserController@post"
    ],
    "PUT" => [
        "/put/{id}" => "UserController@put"
    ]
];