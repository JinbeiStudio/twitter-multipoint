<?php
echo "<h1>Test Cinéma</h1>";
require_once('tweet.php');

$tweet = new Tweet();
print_r($tweet->search("cinema"));

?>

<main>


</main>