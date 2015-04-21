![alt text](http://www.iadvize.com/fr/wp-content/themes/iadvize/layoutImg/logos/logoBD.jpg "iAdvize")
#iadvize-vdm

###**Description du test**

Ce test a pour but de mettre en oeuvre une application permettant 2 choses : 

  1. Permettre à l’aide d’une ligne de commande, d’aller chercher les 200 derniers enregistrements du site “Vie de merde”<sup>1</sup> et de les stocker. (Champs à récupérer : Contenu, Date et heure, et auteur)
  2. Permettre la lecture des enregistrements précédemment récupérés à l’aide d’une API REST au format JSON (voir la description de l’API attendue ci-dessous)

###**Eléments requis**

 - [x] Vous devez utiliser un framework PHP de votre choix
 - [x] Vous avez le choix dans la méthode ou le procédé de stockage
 - [x] Vous devez utiliser GIT pour versionner vos fichiers
 - [x] Vous devez utiliser Composer  pour gérer vos dépendances <sup>2</sup>
 - [ ] Vous devez tester unitairement votre code (In progress :memo:)
 - [x] Vous devez mettre à disposition votre code via Github
 - [x] Vous ne devez pas utiliser l’API du site “Vie de Merde” pour récuperer les informations

###**Note**

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

####**Paramètres :**

 - from (optionnel) ­ Date de début
 - to (optionnel) ­ Date de fin
 - author (optionnel) ­ Auteur

####**Utilisation :**

 - /api/posts
 - /api/posts?from=2014­01­01&to=2014­12­31
 - /api/posts?author=Genius


----------

###Description de l’API : /api/posts/\<id\>
	 
####**Sortie souhaitée :**
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

####**Paramètres :**

 - :id (obligatoire) ­ Identifiant

####**Utilisation :**

 - /api/posts/1
