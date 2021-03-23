<?php
session_start();
require_once('Twitter.php');

$tweet = new Twitter();

$terme = htmlentities($_POST['recherche']);
$tweet->search($terme);
$tweet->convert();
$resultat = serialize($tweet->getResult());

$_SESSION['recherche'] = $resultat;

header("Location: ../index.php");
exit();
