<?php

$router = $container->getRouter();

$router->get('/about', function() {
    echo "A propos de ce site.";
});

$router->get('/', function() {
    echo "bienvenue sur mon site en MVC";
});

$router->run();