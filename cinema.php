<?php
echo "<h1>Test Cinéma</h1>";
require_once 'Twitter.php';

$tweet = new Twitter();
$tweet->search("cinema");
$tweet->convert();
echo('<pre>');
print_r($tweet->getResult());//[0]->display();
echo('</pre>');


?>

<main>


</main>