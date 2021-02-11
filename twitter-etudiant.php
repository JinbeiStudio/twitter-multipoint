<?php
    echo "<h1>Simple Twitter API Test</h1>";
    require_once('TwitterAPIExchange.php');
     
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => "...",
        'oauth_access_token_secret' => "...",
        'consumer_key' => "...",
        'consumer_secret' => "..."
    );
    

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#lannion';

$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);

echo $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest();


?>