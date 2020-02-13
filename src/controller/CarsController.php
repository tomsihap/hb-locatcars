<?php

namespace App\Controller;

class CarsController extends AbstractController {

    public function index() {
        $cars = $this->container->getCarManager()->findAll();

        header('Content-Type: application/json');
        echo json_encode($cars);
        echo $this->container->getTwig()->render('/cars/index.html.twig', [
            'cars'      => $cars,
            'prenom'    => "Thomas"
        ]);

    }

    public function show(int $id) {
        echo "Voici la voiture numéro " . $id ;
    }
}