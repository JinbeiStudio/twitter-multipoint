<?php
session_start();
require_once('Twitter.php');

$tweet = new Twitter();

$tweet->search($_POST['recherche']);
$tweet->convert();
$resultat = serialize($tweet->getResult());

$_SESSION['recherche'] = $resultat;

header("Location: ../index.php");
exit();
