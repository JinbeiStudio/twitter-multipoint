<?php
// echo "<h1>Simple Twitter API Test</h1>";
require_once('TwitterAPIExchange.php');

$tweet = new Twitter();
$tweet->search("cinema");
$tweet->convert();
echo('<pre>');
print_r($tweet->getResult());//[0]->display();
echo('</pre>');



$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#cinema';

$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);

$resultTwitter = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();


$resultTwitter = json_decode($resultTwitter);

?>
