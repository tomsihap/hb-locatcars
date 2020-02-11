# Checklist projet MVC

## 1. Structurer le système de fichiers
```bash
/hb-locatcars                       # Le projet
    /config                         # Fichiers de configuration
        config.php                  # Configuration générale
        routes.php                  # Les routes
    /src                            # Les classes du projet
        /service                    # Les services
            ServiceContainer.php    # Le Service Container
        /model                      # Les Models
        /controller                 # Les Controllers
    /template                       # Les Vues
    index.php                       # La porte d'entrée de notre application
```

## 2. Installer les dépendances avec Composer :
### SI vous créez un projet de zéro
```bash
composer require bramus/router ~1.4
composer require ...
```

### SI vous reprennez un projet existant qui a déjà une liste de dépendances
```bash
composer install
```

## 3. Ajouter des services au Service Container
Si vous ajoutez des dépendances à votre projet que vous avez besoin d'instancier (`new Router` par exemple), il faut ajouter ces dépendances au container de services :

Fichier : `ServiceContainer.php`
```php
class ServiceContainer {
    // On ajoute l'attribut qui correspond au service à rajouter
    private $router;

    // On créée le getter qui gère le service
    public function getRouter()  {
        // Si le service n'est pas déjà instancié dans $this->router,
        // alors on l'instancie :
        if ($this->router === null) {

            // Router est une classe: AUTOCOMPLÉTEZ-LA pour avoir le use !
            $this->router = new Router;
        }
    }
}
```

## 4. Commencer à coder ! Faire une première feature : liste des voitures

Étapes :
1. Créer la route `/cars`
2. Créer le contrôleur et la méthode qui gèreront ce qui se passe quand l'user va dans `/cars` et la remplir avec des données brutes pour l'instant : récupérer des données puis les afficher
3. Faire la partie récupération de données :
   1. Créer un Model pour Car
   2. Créer un Service pour CarManager (récupérer les éléments Car)
   3. Enregistrer notre nouveau service dans le ServiceContainer pour pouvoir l'utiliser partout dans le code


### 1. Créer la route
Dans `routes.php`:
```php
$router->get('/cars', 'CarsController@index');
```

### 2. Créer le controller :

Dans `src/controller/CarsController` :

```php
namespace App\Controller;

class CarsController {

    public function index() {

        // Les voitures mises "en dur" avant de les récupérer réellement
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

        // On affiche en brut les données avant d'appeler la vue réellement
        var_dump($cars);
    }
}
```