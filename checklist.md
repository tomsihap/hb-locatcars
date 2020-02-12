# Checklist projet MVC

## 1. Rappels sur la structure du système de fichiers
```bash
/hb-locatcars                       # Le projet
    /config                         # Fichiers de configuration
        config.php                  # Configuration générale
        routes.php                  # Les routes
    /src                            # Les classes du projet
        /service                    # Les services
            ServiceContainer.php    # Le Service Container
            ManagerInterface.php    # L'interface des Managers
        /model                      # Les Models
        /controller                 # Les Controllers
            AbstractContainer.php   # Le parent des controllers
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
            // Si la classe a des dépendances (par exemple, un manager a besoin de PDO...)
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

class CarsController extends AbstractController {

    // La méthode appelée par la route /cars
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

### 3. Créer le Model
Pour remplacer nos données brutes par des objets hydratés par les données de la BDD, on fait un Model avec attributs, getters et setters.
```php
<?php
namespace App\Model;

class Car {
    private $id;
    private $brand;
    private $model;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return void
     */
    public function setBrand(string $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return void
     */
    public function setModel(string $model)
    {
        $this->model = $model;
    }
}
```

### 4. Créer la table en base de données et s'y connecter
- Créez la table et/ou la base de données
- Gérez la configuration dans `config.php` si besoin

### 5. Créer le CarMananger
À quoi ça sert : le controller va appeler le CarManager, qui va se connecter à PDO, et qui va retourner des objets Car.

On implémente le ManagerInterface qui va nous obliger à avoir les méthodes de base qui y sont décrites. On remplit au moins `arrayToObject` et `findAll` qui vont nous permettre de retourner des objets :
- Dans le controller, on appelle `carManager->findAll()`
- La méthode `findAll()` récupère avec PDO un tableau d'arrays
- La méthode `findAll()` utilise `arrayToObject()` pour transformer chaque array en objet
- La méthode `findAll()` retourne enfin la liste des objets
- Ça y est, le controller a les objets Car

```php
<?php
namespace App\Service;

use App\Model\Car;
use PDO;

class CarManager implements ManagerInterface {

    // Le manager a besoin de PDO
    private $pdo;

    // On demande dès le constructeur d'instancier PDO
    // pour utiliser le Manager
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Transforme un array en objet Car
     * @param array $array
     * @return Car
     */
    public function arrayToObject(array $array)
    {
        $car = new Car;
        $car->setId($array['id']);
        $car->setBrand($array['brand']);
        $car->setModel($array['model']);

        return $car;
    }

    /**
     * @return Car[]
     */
    public function findAll()
    {
        $query = "SELECT * FROM car";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $cars = [];

        foreach($data as $d) {
            $cars[] = $this->arrayToObject($d);
        }

        return $cars;
    }

    /**
     * @param int $id
     * @return Car
     */
    public function findOneById(int $id)
    {
    }

    /**
     * @param string $field
     * @param string $value
     * @return Car[]
     */
    public function findByField(string $field, string $value)
    {
    }
}
```

### 6. Enregistrer le CarManager dans le ServiceContainer
Pour avoir accès au CarManager de partout dans notre app sans avoir à gérer ses dépendances - ici, PDO par exemple-, on l'enregistre dans le service container :

```php
class ServiceContainer {
    
    private $carManager;

    public function getCarManager() {
        if ($this->carManager === null)
        {
            // CarManager a besoin de PDO, on l'injecte ici !
            $this->carManager = new CarManager($this->getPdo());
        }

        return $this->carManager;
    }
}
```

### 7. On appelle le CarManager dans CarController :

```php
    public function index() {
        // $this->container existe grâce au AbstractController, la classe parente 
        $cars = $this->container->getCarManager()->findAll();

        var_dump($cars);
    }
```

### 8. On veut afficher ça !
#### 1. Vous n'avez PAS encore Twig installé
##### Installer Twig
`composer require twig/twig`

##### Enregistrer le service Twig dans le ServiceContainer
```php
class ServiceContainer {
    private $twig;

    public function getTwig() {

        if ($this->twig === null) {
            try {
                // On dit que nos templates seront dans le dossier template
                $loader = new FilesystemLoader(__DIR__ . '/../../template');
                $twig = new Environment($loader);
                $this->twig = $twig;
            }
            catch(Error $e) {
                var_dump($e);
            }
        }
        return $this->twig;
    }
}
```


#### 2. Vous avez Twig installé
##### Créer le template
- Créez un fichier `index.html.twig` (index car c'est le nom de la méthode qui aura besoin de ce template) dans `template/cars/index.html.twig`.

##### Appeler le template dans le controller

```php
class CarsController extends AbstractController {

    public function index() {
        $cars = $this->container->getCarManager()->findAll();

        echo $this->container->getTwig()->render('/cars/index.html.twig', [
            'cars' => $cars, // On envoie la variable $cars à notre template. Il la recevra nommée "cars".
        ]);

    }
}
```

##### Utiliser la variable "cars" dans Twig
La documentation complète de Twig est ici : https://twig.symfony.com/doc/3.x/
```html
<ul>
        {% for car in cars %}
            <li>{{car.brand}} {{ car.model }}</li>
        {% endfor %}
    </ul>
```