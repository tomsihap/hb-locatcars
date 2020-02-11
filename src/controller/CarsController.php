<?php

namespace App\Controller;

class CarsController {

    public function index() {

        $cars = [
            [
                "brand" => "Ford",
                "model" => "Fiesta",
            ],
            [
                "brand" => "Citroën",
                "model" => "C3",
            ],
        ];

        include_once __DIR__ . '/../../template/cars/index.php';
    }

    public function show(int $id) {
        echo "Voici la voiture numéro " . $id ;
    }
}