<?php
//Buocle d'affichage des cartes de tweets
foreach (unserialize($_SESSION['recherche']) as $tweet) {
    echo $tweet->display();
} 
?>