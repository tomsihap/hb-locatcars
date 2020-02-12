<?php

namespace App\Controller;

abstract class AbstractController {

    protected $container;

    public function __construct() {
        global $container;
        $this->container = $container;
    }
}