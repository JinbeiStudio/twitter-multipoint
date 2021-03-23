<?php

$tweets = unserialize($_SESSION['recherche']);

//Affichage du nb de twweets trouvés ou message en cas de résultat nul
echo count($tweets) ? count($tweets).' Résultats' :  'Aucun résultat n\'as été trouvé. Elargissez votre recherche.';

//Boucle d'affichage des cartes de tweets
foreach ($tweets as $tweet) {
    echo $tweet->display();
} 
?>