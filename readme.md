# TP : Créer un projet en MVC avec PHP

## 1. Présentation du projet
Un projet en MVC est composé de plusieurs éléments :

### Les éléments de MVC
- Des **Models**, qui sont des classes qui schématiseront nos tables en base de données. Leur rôle est de contenir des données, comme des arrays mais en mieux grâce aux méthodes qu'on peut rajouter, aux typages qu'on peut donner à nos données, etc !
- Des **Vues**, qui sont les pages qui afficheront des données mais sans faire de travail dessus : en effet, leur rôle n'est que d'afficher les données qui auront déjà été traitées ailleurs dans notre code.
- Des **Controllers**, qui servent à faire le lien entre les Models et les vues (en effet, le Model ne sert pas à l'affichage, la vue ne récupère pas de données... Il faut un lien entre les deux !)

### Les outils en plus
- Des classes **services**, de faire du traitement de données (les récupérer en base de données, travailler dessus, les traduire si besoin...)
- Un **routeur**, qui sert à lire l'URL donnée par l'utilisateur, et appeler le bon Controller au bon moment.


## 2. Comment fonctionne un projet MVC ?

Voyons concrètement comment un projet en MVC s'exécute :

1. **Une requête HTTP** : l'utilisateur va sur une page, un formulaire est envoyé... Par exemple : `example.com`, `example.com/home`, `example.com/users/`, `example.com/articles/3`

> Bon, et comment on gère ces URL au juste ? On ne voit aucun fichier `*.php` ni `*.html` dans l'URL, comment on fait pour gérer ces pages ?!

2. **Un routeur** : c'est un outil qui nous permet de lire l'URL et de choisir en fonction l'action à faire. Ça veut dire que dorénavant, on n'utilisera plus de fichiers PHP qui seront directement ouverts par l'utilisateur (comme `battle.php`, `show.php`, `form.php`, `list.php`...). En fait, le routeur va lire l'URL (exemple : `example.com/users`) et gérer l'action à faire (`"afficher la page de liste des utilisateurs"`).

3. **Un Controller** : Bon, comment le routeur gère "l'action à faire" ? En fait, le routeur est un petit fichier à qui on dit : "si l'utilisateur va **ici**, va dans **cette méthode de cette classe** pour faire l'action". Et cette fameuse classe... C'est le Controller. C'est une classe qui contient plusieurs méthodes, une par page en général. Ces méthodes, en général, vont : a. récupérer les données si besoin, b. appeler la page template qui correspond, c'est un des fichiers qui contient du HTML.

4. **Un Model** : C'est notre classe qui représente les données. Le Controller demande au Model les données nécessaires pour la page qui lui a été demandée par le routeur.

5. **Une Vue** : C'est le template ! C'est le seul fichier qui contiendra du HTML. Le Controller, qui a récupéré les données auprès du Model, envoie les données à la Vue qui les affiche enfin.

6. Un peu partout... **Des services**. Eux, ils restent là. On en a encore besoin de partout ! Enfin plus exactement, c'est le Controller qui appellera des services quand il en aura besoin.

## Un projet MVC en pratique
Les étapes dans un cas d'exemple :

1. L'utilisateur va sur `example.com/users`
2. Dans le fichier routeur, on aura écrit que d'aller sur `/users`, ça correspond à actionner la méthode de `list()` de `UsersController` (ou autrement dit : `UsersController::list()`).
3. `UsersController()`, ou plutôt sa méthode `list()`, aura besoin de récupérer la liste des Users. On fera appel à un service, gérés par un service container, par exemple: `$container->getUsersManager()->findAll()`, qui nous retourne un tableau d'objets `User`.
4. Ensuite, après les traitements éventuels effectués sur la liste de `User` (`$users`), il faut afficher la page : on affiche le fichier `Vue`, qui peut être par exemple `templates/users/list.php` et qui a besoin d'une variable `$users` pour fonctionner (eh oui, notre vue ne sert qu'à afficher des users, pas à les récupérér au préalable).

# Créer le projet

> Vous allez créer un système de location de voitures. Les fonctionnalités seront :
> - CRUD voitures
> - CRUD utilisateurs
> - CRUD locations (un utilisateur loue une voiture)
> - Système de connexion
> - Système de rôles (rôle Administrateur, rôle Conducteur, rôle Loueur)

## 1. Structurer le projet
Créez la structure de projet suivante :
```
/hb-locatcars
    /config
        config.php
        routes.php
    /src
        /service
            ServiceContainer.php
        /model
        /controller
    /template
    index.php
```

### Github !
C'est le moment de mettre votre projet sur Github ! Pour cela : créez un nouveau repository sur Github (https://github.com/new), idéalement en public pour montrer au monde vos nouvelles oeuvres. Une fois créé, une page apparaît avec les rubriques suivantes :

- Quick setup — if you’ve done this kind of thing before
  - *Dedans, vérifiez que vous avez bien coché HTTP ! On apprendra SSH plus tard.*
- …or create a new repository on the command line
  - *Rien d'intéressant pour nous ici*
- …or push an existing repository from the command line
  - *Dedans, copiez-collez la ligne qui commence par `git remote add origin https://...`*
- …or import code from another repository
  - *Rien d'intéressant pour nous ici*

Dans votre projet, ouvrez un terminal **EXACTEMENT** dans le dossier du projet (**VÉRIFIEZ** votre VSCode ! Il ne doit PAS être ouvert dans un dossier au dessus ou en dessous, il ne doit y avoir QUE le projet `hb-locatcars` et rien d'autre du tout !).
Le terminal ouvert, saisissez :
```bash
git init
git remote add origin https://.... # La ligne copiée collée
```

### Que...quoi ?
`git init` sert à indiquer à notre projet qu'il sera versionné. En fait, on peut utiliser Git sans Github ! Une fois `git init` de tapé, on est déjà capables de faire des commits. Mais sans `remote`, on ne pourra pas les envoyer en ligne.

`git remote add origin https://....` ajoute justement une `remote`. C'est l'URL du serveur vers lequel envoyer nos commits quand on fait un `push`.

Et c'est tout ! Vous êtes dorénavant capables de faire des commits dans votre projet. Pour cela, deux choix :

1. **VSCode :** sur le côté, vous avez une icône, la troisième en général, qui correspond au versionning. Cliquez dessus. Pour faire un commit : saisissez quelque chose dans le champ `Message` puis tapez `Ctrl+Entrée` (ou `Cmd+Entrée` sous Mac). Validez les fenêtres éventuelles qui peuvent apparaître (en cliquant sur `Yes/Always/Toujours` quand c'est possible). Votre commit est fait ! Pour pusher (envoyer sur le serveur), vous devez cliquer sur 


2. **Terminal :** Dans le terminal, saisissez :
```bash
git add -A # Ajout de tous les fichiers au commit
git commit -m "Message du commit"
git push
```



## 2. Utiliser Composer pour installer un routeur
Dans notre projet, nous voudrons accéder aux pages en indiquant une URL "REST", c'est à dire qui représente nos données, sans indiquer de fichier en particulier. C'est exactement comme on peut trouver dans des API REST : en allant sur `/users/2`, on accède à l'utilisateur #2, sans savoir si il y a un fichier `users.php`, `listUsers.php` ou quoi que ce soit d'appelé. L'idée est d'avoir des URL propres et prévisibles !

Pour cela, on va utiliser un routeur : on déclarera des routes, c'est à dire des chemins d'URL, et on indiquera grâce au routeur quel fichier/classe/méthode sera utilisé réellement.

Plutôt que de réinventer la roue, on va utiliser un gestionnaire de dépendances pour utiliser une librairie déjà existante ! Comme `npm` avec Javascript, on utilisera `Composer` pour PHP. La liste des packages existants est disponible sur `packagist.org`. Recherchez le routeur `bramus router`.

Dans la documentation, on voit comment l'installer : on a besoin de l'outil Composer, puis de saisir dans la console : `composer require bramus/router ~1.4` :

### Installer Composer
L'installateur de Composer est disponible sur https://getcomposer.org/download/. Une fois installé, ouvrez un terminal et saisissez `composer --version` pour vérifier si Composer a bien été installé !

### Installer le routeur
Maintenant que Composer est installé, ouvrez un terminal **DANS le dossier du projet** (c'est à dire : pas dans un dossier au dessus ni en dessous ni ailleurs !). Dans notre structure de projet par exemple, notre terminal est situé dans `hb-locatcars`.

> Rappels terminal : pour lister les fichiers dans lequel je suis : `ls` (`ls -alh` pour plus de détails). Pour aller dans un dossier : `cd nomDuDossier` (ou encore `cd ..` pour remonter d'un dossier au dessus).

Une fois sûrs de vous, tapez dans la console la ligne indiquée dans la rubrique Installation sur la page du routeur sur Packagist.org (en ce moment : `composer require bramus/router ~1.4`). 

> Rappels SemVer : les versions sont en notation SemVer (Semantic Versionning) : https://putaindecode.io/articles/semver-c-est-quoi/

### Utiliser des packages issus de Composer
Comment fonctionne Composer ? Si 

## 3. Utiliser notre routeur

## 4. Nos premières routes

## 5. Utiliser des templates avec Twig

## 6. Utiliser des contrôleurs

## 7. Créer le modèle de données

## 8. Créer les services

## 9. Utiliser les services pour se connecter à la base de données
