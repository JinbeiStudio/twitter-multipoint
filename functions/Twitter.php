<?php
require_once('TwitterAPIExchange.php');
require_once('Tweet.php');


class Twitter
{
    const settings = [
        'oauth_access_token' => "2348986722-DIF6jg9iLe2NBFIyANE3h0SkrmoltjmOljJF4Tg",
        'oauth_access_token_secret' => "kQIsM6kRSGcV5CS2mP1unFMYjvuGpEoho7hsdK5IlTErX",
        'consumer_key' => "rHNPhJIO1GBNmKfFGqICjcyTY",
        'consumer_secret' => "dfBP1RDT4KZ9NVEuvqdSgvCzLmombznXU1zz1iTKx3C9T9CpA7"
    ];

    private $result = [
        'content' => null,
        'format' => null
    ];

    function __construct($token)
    {
        $this->url = 'https://api.twitter.com/1.1/search/tweets.json';
        $this->twitter = new TwitterAPIExchange(self::settings);
        $this->token = $token;
        //On vide le dossier lié au token
        $this->deleteDirectory('tmp/' . $this->token);
    }

    //Effectue la recherche, renvoie un tableau où status indique la résolution de la recherche 
    public function search($getfield)
    {
        $this->result['content'] = $this->twitter->setGetfield("?q=" . $getfield)
            ->buildOauth($this->url, 'GET')
            ->performRequest();
        $this->result['format'] = 'json';


        $decode = json_decode($this->result['content'], true);
        //En cas d'erreurs, retourne le détail
        if (isset($decode['errors'])) {
            $this->errors = $decode['errors'];
            $this->errors['url'] = $this->url . "?q=#" . $getfield;
            $this->result = [];
            $this->result[] = new Tweet([],$this->token);
            return [
                'status' => false,
                'errors' => $this->errors,
            ];
        }

        //pas d'erreurs, retour valide
        return [
            'status' => true
        ];
    }

    //Converti le résultat de la recherche en Objects Tweets
    public function convert()
    {
        $this->result['content'] = json_decode($this->result['content'], true);
        $newTab = [];
        if (isset($this->result['content']['statuses'])) {
            foreach ($this->result['content']['statuses'] as $tweet) {
                $newTab[] = new Tweet($tweet, $this->token);
            }
        }
        $this->result['content'] = $newTab;
        $this->result['format'] = 'Tweet';
    }

    //Renvoie le résultat
    public function getResult()
    {
        return $this->result['content'];
    }

    private function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
    }

}
