# Projet Twitter Multipoint

## Membre du groupe
- Emeric DURDOS
- Gabriel TAVERNIER
- Julien GABRIEL

## Direction choisie
Nous avons choisi de faire une application qui fournit le pourcentage des langues les plus populaires pour chaque mots clés recherchés.

## Mise en place de l’application
Nous avons choisi de travailler sans framework back et de partir sur une programmation objet.

Nous avons d’abord créer les classes _Tweet_ et _Twitter_ qui s’occupent respectivement du traitement d’un tweet et l’ensemble des résultats de la recherche.

Nous avons ensuite utilisé la classe _Twitter_ pour faire une recherche et convertir le json de retour en tableau d’objets Tweets qui sont envoyés à la page pour les afficher.
L’objet _Tweet_ formate les données pour préparer l’affichage.

Le domaine sur lequel _Twitter_ héberge les images de profil et de bannière sont automatiquement bloquées par certains navigateurs (firefox notamment) car ils considèrent qu’il s’agit de tracking. Nous devons donc les sauvegarder sur le serveur.

## Gestion des recherches
Lors de la conversion du résultat de la recherche, on profite que la fonction balaye les éléments pour utiliser un tableau d’association des code langue pour créer un tableau qui met en relation les langues présentes dans la recherche avec leur nombre d’apparitions. Ce tableau est utilisé ensuite dans l’onglet analyse pour afficher les statistiques.

## Formatage du contenu d’un tweet pour l’affichage
### Gestion des images
Il nous a donc fallu télécharger les images et les stocker sur notre serveur. Cela implique de supprimer régulièrement les images inutilisées pour limiter la surcharge du serveur.
Pour ce faire nous avons mis en place un système de tokens sauvegardés en sessions qui correspond à un dossier temporaire sur le serveur.
Les tokens sont composés comme ceci :  
`t_[entier aléatoire]_[date de création du token]`

De cette manière, lorsqu'un utilisateur fait une recherche, nous vérifions son token afin de lui attribuer un nouveau token s’il ne contient pas la date du jour ou s’il est absent.
Nous supprimons aussi tous les dossiers ne contenant pas la date du jour.

Et nous créons un nouveau dossier pour cet utilisateur où toutes les images qu’il faudra lui charger seront stockées. Ce système de token est utile pour dater les documents et éviter qu’un utilisateur ne supprime le dossier d’un autre.

Le téléchargement des images est uniquement effectué lorsque l’utilisateur demande l’affichage de tweets et si les fichiers n’existent pas déjà. Cela permet d'éviter des temps de chargement inutiles.

### Gestion du texte
Lors d’une recherche standard l’objet renvoyé contenant les tweets contient un champ "text" dans lequel le contenu est tronqué. Nous avons donc ajouté le paramètre "tweet_mode=extended" dans notre requête afin d’obtenir le champ "full_text" dans l’objet renvoyé.  
Malheureusement lors d’un ReTweet, le champ "full_text" est malgré tout tronqué. Le Tweet original au complet est disponible dans l’objet "retweeted_status.full_text". Lors du formatage du texte soit on affiche le contenu du tweet soit on reconstruit le tweet avec le prefixe `@ RT["user"]["screen_name"] :`.  
Nous avons aussi ajouté la gestion des "citations" qui sont des Retweets avec ajout de contenu. Nous testons donc la présence du champ "quoted_status" pour reconstituer ensuite la citation.  
Le contenu textuel récupéré est du texte brut. Il ne contient pas les liens sur les `#hashtags`, les `@user` ou encore les liens. Nous avons donc créé 3 méthodes pour convertir ces données en liens vers le site de _Twitter_.

### Données complémentaires
Derniers détails, nous avons ajouté le nombre de ReTweet et de Like. Nous souhaitions également ajouter de nombre de réponses au Tweet mais cette donnée n’est disponible qu’avec la version premium de l’API. 
Nous avons également rajouté un lien vers le tweet original, cette fonction étant très pratique lors de la phase de développement pour vérifier que nous récupérions bien le maximum de données.

## Plugins utilisés
### DataTables
Nous avons utilisé le plugin DataTables afin de pouvoir ajouter de nombreuses fonctionnalités à notre tableau de statistiques. Ce plug in permet de trier les différentes colonnes du tableau, mais également d’y faire une recherche à l’aide de la barre associée. Nous avons également installé le module permettant de faire des exports sur excel, en pdf ou encore d’imprimer le tableau. 

### ChartJS
Le plugin Chart JS nous a permis de réaliser le camembert représentant la répartition des langues pour la recherche associée. Nous lui passons les données récupérées stockées dans un tableau afin de réaliser le graphique. Nous avons également utilisé un plug in de couleur afin de pouvoir colorer automatiquement le graphique avec des couleurs correspondant à notre thème bootstrap.

### Bootstrap
Nous avons fait le choix d’utiliser le framework bootstrap pour la réalisation du Front. En effet il s’agit d’un framework développé Twitter, l'esthétique est donc très proche de celle du site Twitter. Nous avons également pu styliser notre tableau Datatables à l’aide de ce framework afin de garder une cohérence esthétique dans toute l’application.

## Améliorations envisagées
### Gestion des médias
Actuellement nous ne gérons pas les médias inclus dans un tweet (type image ou vidéo). 
De la même manière que les images de profil ou de bannière, les médias inclus dans un tweet proviennent de domaines bloqués par certains navigateurs. Il nous faudrait donc également les stocker sur notre serveur pour pouvoir les afficher ensuite.
Notre application n’étant pas des plus rapides et l’espace disque étant limité nous avons choisi de ne pas rajouter cette fonctionnalité pour le moment. 

### Traduction des termes de recherche
Afin d’avoir les statistiques les plus réalistes possible nous pourrions traduire les mots clés recherchés à l’aide d’une api. En effet, si le terme recherché est dans une langue précise cela biaise la statistique en faveur de cette langue. Il faudrait donc traduire les mots clés dans le maximum de langue possible afin de pouvoir les résultats les plus justes.

### Sauvegarde en base de données avec anticipation des recherches
L’API nous impose une limite sur le nombre de tweets recherchés à la fois. Nous avons donc dû limiter le nombre de tweets appelés par l’API ce qui rend la statistique moins précise. Une solution serait de programmer un enregistrement en base de données des mots clés les plus recherchés mais cela demanderait d’anticiper le besoin du client.

### Amélioration des performances
L’application est parfois sujette à certains ralentissements lorsque l’on fait une recherche. Nous pensons que cela provient du chargement des images depuis les domaines d'hébergement twitter. Il faudra creuser davantage le sujet.







