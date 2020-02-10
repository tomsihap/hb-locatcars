<?php

namespace App\Controller;

class CarsController {

    public function index() {
        include_once __DIR__ . '/../../template/cars/index.php';
    }
}