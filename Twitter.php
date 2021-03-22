<?php
require_once('TwitterAPIExchange.php');

class Twitter
{
    const settings = [
        'oauth_access_token' => "2348986722-DIF6jg9iLe2NBFIyANE3h0SkrmoltjmOljJF4Tg",
        'oauth_access_token_secret' => "kQIsM6kRSGcV5CS2mP1unFMYjvuGpEoho7hsdK5IlTErX",
        'consumer_key' => "rHNPhJIO1GBNmKfFGqICjcyTY",
        'consumer_secret' => "dfBP1RDT4KZ9NVEuvqdSgvCzLmombznXU1zz1iTKx3C9T9CpA7"
    ];

    function __construct()
    {
        $this->url = 'https://api.twitter.com/1.1/search/tweets.json';
        $this->twitter = new TwitterAPIExchange(self::settings);
    }

    public function search($getfield)
    {
        return $this->twitter->setGetfield("?q=#" . $getfield)
            ->buildOauth($this->url, 'GET')
            ->performRequest();
    }
}
