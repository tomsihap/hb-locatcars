<?php

$router = $container->getRouter();
$router->setNamespace('App\Controller');
$router->get('/cars', 'CarsController@index');

$router->run();