<?php

namespace App\Controller;

class CarsController extends AbstractController {

    public function index() {
        $cars = $this->container->getCarManager()->findAll();

        
        echo $this->container->getTwig()->render('/cars/index.html.twig', [
            'cars'      => $cars,
            'prenom'    => "Thomas"
        ]);

    }

    public function show(int $id) {
        $car = $this->container->getCarManager()->findOneById($id);
        echo $this->container->getTwig()->render('/cars/show.html.twig', [
            'car' => $car
        ]);
    }

    /**
     * Afficher le formulaire de création d'un Car
     * Route : GET /cars/new
     */
    public function new() {
        echo $this->container->getTwig()->render('/cars/form.html.twig');
    }

    /**
     * Enregistrer un Car en base de données (vient d'un formulaire)
     * Route : POST /cars
     */
    public function create() {
        $this->container->getCarManager()->create($_POST);

        header('Location: ' . $this->configuration['env']['base_path'] . '/cars');
    }


    /**
     * Afficher le formulaire d'édition d'un Car
     * Route : GET /cars/:id/edit
     */
    public function edit(int $id) {
        $car = $this->container->getCarManager()->findOneById($id);

        echo $this->container->getTwig()->render('/cars/form.html.twig', [
            'car' => $car
        ]);

    }

    /**
     * Update d'un Car en base de données (vient d'un formulaire edit)
     * Route : POST /cars/:id/edit
     */
    public function update(int $id) {
        $this->container->getCarManager()->update($id, $_POST);
        header('Location: ' . $this->configuration['env']['base_path'] . '/cars/' . $id);

    }

}