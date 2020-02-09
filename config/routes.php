<?php

use Bramus\Router\Router;

$router = new Router;
$router->get('/hello', function() {
    echo "Hello world";
});

$router->run();