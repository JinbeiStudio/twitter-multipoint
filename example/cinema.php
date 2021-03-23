<?php
// echo "<h1>Simple Twitter API Test</h1>";
require_once('./functions/TwitterAPIExchange.php');
require_once('./functions/Twitter.php');

$tweet = new Twitter();
$tweet->search("cinema");
$tweet->convert();
/* echo('<pre>');
print_r($tweet->getResult());//[0]->display();
echo('</pre>'); */
