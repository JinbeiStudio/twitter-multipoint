<?php
session_start();
require_once('Twitter.php');

$twitter = new Twitter();

$terme = htmlentities($_POST['recherche']);

if(!$twitter->search($terme)['status'])
{
    //header("Location: ../index.php");
    print_r($twitter->errors);
    exit();
}

$twitter->convert();
$resultat = serialize($twitter->getResult());
$_SESSION['recherche'] = $resultat;
/*
echo '<pre>';
print_r($_SESSION['recherche']);
echo '</pre>';
*/
header("Location: ../index.php");
exit();
