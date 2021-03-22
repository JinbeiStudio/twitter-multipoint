<?php
echo "<h1>Test Cinéma</h1>";
require_once 'Twitter.php';

$tweet = new Twitter();
print_r($tweet->search("cinema"));

?>

<main>


</main>