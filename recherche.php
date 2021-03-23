<?php

require_once('Twitter.php');

$tweet = new Twitter();
$_SESSION['recherche'] = $tweet->search($_POST['recherche']);
header("index.php");
exit();
