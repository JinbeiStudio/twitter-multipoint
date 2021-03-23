<?php
session_start();
require_once('Twitter.php');

$tweet = new Twitter();

$terme = htmlentities($_POST['recherche']);

if(!$tweet->search($terme)['status'])
{
    //header("Location: ../index.php");
    print_r( $tweet->errors);
    exit();
}
$tweet->convert();
$resultat = serialize($tweet->getResult());

$_SESSION['recherche'] = $resultat;

header("Location: ../index.php");
exit();
