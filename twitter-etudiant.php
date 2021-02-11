<?php
echo "<h1>Simple Twitter API Test</h1>";
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "2348986722-DIF6jg9iLe2NBFIyANE3h0SkrmoltjmOljJF4Tg",
    'oauth_access_token_secret' => "kQIsM6kRSGcV5CS2mP1unFMYjvuGpEoho7hsdK5IlTErX",
    'consumer_key' => "rHNPhJIO1GBNmKfFGqICjcyTY",
    'consumer_secret' => "dfBP1RDT4KZ9NVEuvqdSgvCzLmombznXU1zz1iTKx3C9T9CpA7"
);


$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#lannion';

$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);

echo $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
