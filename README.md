![alt text](http://www.iadvize.com/fr/wp-content/themes/iadvize/layoutImg/logos/logoBD.jpg "iAdvize")
#iadvize-vdm

###Description du test

Ce test a pour but de mettre en oeuvre une application permettant 2 choses : 

  1. Permettre à l’aide d’une ligne de commande, d’aller chercher les 200 derniers enregistrements du site “Vie de merde”<sup>1</sup> et de les stocker. (Champs à récupérer : Contenu, Date et heure, et auteur)
  2. Permettre la lecture des enregistrements précédemment récupérés à l’aide d’une API REST au format JSON (voir la description de l’API attendue ci-dessous)

###Eléments requis

 - [x] Vous devez utiliser un framework PHP de votre choix
 - [x] Vous avez le choix dans la méthode ou le procédé de stockage
 - [x] Vous devez utiliser GIT pour versionner vos fichiers
 - [x] Vous devez utiliser Composer  pour gérer vos dépendances <sup>2</sup>
 - [ ] Vous devez tester unitairement votre code (In progress :memo:)
 - [x] Vous devez mettre à disposition votre code via Github
 - [x] Vous ne devez pas utiliser l’API du site “Vie de Merde” pour récuperer les informations

###Note

 - La description fonctionnelle via BeHat  serait un plus <sup>3</sup>
 - Si vous ne parvenez pas à utiliser l’ensemble des éléments requis, n’hésitez ­pas à présenter tout de même votre test dans sa version la plus aboutie.
 - Vous disposez du temps dont vous avez besoin à la bonne réalisation du test

----------
<sup>1</sup> Site “Vie de merde” : http://www.viedemerde.fr/<br/>
<sup>2</sup> Site “Composer” : https://getcomposer.org/<br/>
<sup>3</sup> Site “BeHat” : http://behat.org/<br/>

----------


###Description de l’API : /api/posts

####**Sortie souhaitée**
```json
{ 
    "posts": [ 
        { 
            "id": 1, 
            "content": "Aujourd'hui, iAdvize m'a demandé de réaliser un test de développeur PHP.", 
            "date": "2014-01-01 00:00:00", 
            "author": "Genius" 
        } 
    ], 
    "count": 1 
}
```

####Paramètres :

 - from (optionnel) ­ Date de début
 - to (optionnel) ­ Date de fin
 - author (optionnel) ­ Auteur

####Utilisation :

 - /api/posts
 - /api/posts?from=2014­01­01&to=2014­12­31
 - /api/posts?author=Genius

----------


###Description de l’API : /api/posts/\<id\>
	 
####Sortie souhaitée :
```json	 
{ 
    "post": { 
        "id": 1, 
        "content": "Aujourd'hui, iAdvize m'a demandé de réaliser un test de développeur PHP.", 
        "date": "2014-01-01 00:00:00", 
        "author": "Genius" 
    } 
}
```

####Paramètres :

 - :id (obligatoire) ­ Identifiant

####Utilisation :

 - /api/posts/1

----------


###Configuration de l'application

L'application utilise les éléments suivants :
 - [Composer](https://getcomposer.org/) : Gestionnaire de paquet PHP
 - [SlimFramework v2](http://www.slimframework.com/) : Framework ultra léger
 - [Apache Log4PHP v2.3.0](http://logging.apache.org/log4php/) : Traceur PHP
 - [Sunra PhpSimpleHtmlDomParser](http://simplehtmldom.sourceforge.net/) : Parser HTML vers PHP
 - [phpunit v4.6](https://phpunit.de/) : Outils de tests PHP
 - [phpunit-skeleton-generator v2.0.1](https://github.com/sebastianbergmann/phpunit-skeleton-generator) : Génération des squelettes pour les classes de test phpunit

Elle est structurée de la manière suivante :
 - class
  - business : Classes métiers (Interaction Services\<-\>Données)
  - service : Classes de service aux APIs
  - vdm : Classes d'accès aux données
 - config : Fichiers de configuration
  - *__global.conf.php* : Définition des variables globales
  - *_default.conf.php* : Fichier d'environnement par défaut
  - *prod.conf.php* : Définition des variables spécifiques à l'environnement de production
  - *dev.conf.php* : Définition des variables spécifiques à l'environnement de développement
 - data
  - json : Répertoire de stockage du fichier JSON (Contenant les articles récupérés, pas stockage de SQL:grimacing:)
  - logs : Répertoire de stockage des traces applicatives
  - mockups/html : Répertoire contenant des bouchons HTML (Mode Offline)
  - windows-tools : Utilitaires Windows pour l'execution des commandes Composer/PHPUnit (Oui, c'est plus simple sous Linux:neckbeard:)
 - lib : Répertoires des librairies chargés par Composer
 - navigation : Fichiers de navigation de l'application (Définition des routes)
 - test : Répertoire contenant tout les tests PHPUnit

####Minimum requis :
 - PHP >=5.4
 - Apache 2
  - Activer le module "mod_rewrite"

Sous Windows, vous pouvez utiliser [uWamp](http://www.uwamp.com/fr/) (Serveur portable Apache/PHP/MySQL/SQLLite)

####Fichier "*__global.conf.php*" :
 - **APP_NAME** : Défini le nom de l'application
 - **APP_LEVEL** : Défini le préfixe de la configuration à charger (_default si non renseigné)

####Fichier "*_default.conf.php*" :
 - **VDM_BASE_URL** : URL de base du site VieDeMerde (Peut être remplacer par "./data/mockups/html/vdm.html." pour le mode bouchonné)
 - **VDM_MAX_ARTICLES_DOWNLOAD** : Nombre d'articles maximum à télécharger depuis le site VieDeMerde
 - **VDM_MAX_ARTICLES_SHOW** : Nombre maximum d'articles à renvoyer par l'API
 - **VDM_ARTICLES_JSON_FILE** : Chemin complet du fichier d'enregistrement JSON
 - **LOGS_FOLDER** : Définition du répertoire des traces
 - **Logger::configure\[rootLogger\]\[level\]** : Définition du niveau des traces de Log4PHP
