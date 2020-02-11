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
    private $router; # Attribut correspondant au service

    public function getRouter()  {
        if ($this->router === null) {
            
        }
    }
}
```