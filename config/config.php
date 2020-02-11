<?php

use App\Service\CarManager;
use App\Service\ServiceContainer;

$configuration = [
    'db' => [
        'dsn'      => 'mysql:dbname=hblocatcars;host=localhost;port=8889;charset=utf8',
        'username' => 'root',
        'password' => 'root',
    ]
];

require_once __DIR__ . '/../vendor/autoload.php';

$container = new ServiceContainer($configuration);

$carManager = new CarManager;
dd($carManager->findAll());

//require_once __DIR__ . '/routes.php';