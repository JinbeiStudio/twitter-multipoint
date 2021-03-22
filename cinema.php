<?php
// echo "<h1>Simple Twitter API Test</h1>";
require_once('TwitterAPIExchange.php');
require_once('Twitter.php');

$tweet = new Twitter();
$tweet->search("cinema");
$tweet->convert();
/* echo('<pre>');
print_r($tweet->getResult());//[0]->display();
echo('</pre>'); */
?>
