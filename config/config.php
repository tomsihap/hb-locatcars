<?php

use App\Service\ServiceContainer;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new ServiceContainer;

require_once __DIR__ . '/routes.php';