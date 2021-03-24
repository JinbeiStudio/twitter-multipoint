<?php
session_start();
require_once 'Twitter.php';
require_once 'tokenGen.php';

$twitter = new Twitter($_SESSION['token']);
$terme = $_POST['recherche'];
$_SESSION['terme'] = $terme;
//On fait la recherche et on affiche les éventuelles erreurs
if (!$twitter->search($terme, $_POST['count'])['status']) {
    //header("Location: ../index.php");
    print_r($twitter->errors);
    exit();
}

//Pas d'erreurs
//on converti le résultat en objet
$twitter->convert();

//On le stocke dans la session
$resultat = serialize($twitter->getResult());
$_SESSION['recherche'] = $resultat;

//Redirection
header("Location: ../index.php");
exit();
