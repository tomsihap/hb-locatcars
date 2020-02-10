<?php

use App\Controller\UserController;
use App\Controller\UsersController;
use Bramus\Router\Router;

$router = new Router;

$router->get('/hello', function() {
    echo "hello world";
});



$router->run();
