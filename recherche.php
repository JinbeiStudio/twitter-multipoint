<?php

$tweet = new Tweet();
$_SESSION['recherche'] = $tweet->search($_POST['recherche']);
header("index.php");
exit();
