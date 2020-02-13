<?php

$router = $container->getRouter();
$router->setNamespace('App\Controller');

$router->get('/cars', 'CarsController@index');
$router->get('/cars/(\d+)', 'CarsController@show');

$router->get('/cars/(\d+)/edit', 'CarsController@edit');    // Formulaire Edit
$router->post('/cars/(\d+)/edit', 'CarsController@update'); // Traitement Edit

$router->get('/cars/new', 'CarsController@new');            // Formulaire Create
$router->post('/cars', 'CarsController@create');            // Traitement Create

$router->run();