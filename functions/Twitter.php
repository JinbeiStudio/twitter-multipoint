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
            $this->result[] = new Tweet([], $this->token);
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

    public function getLang()
    {
        if($this->result['format'] === 'Tweet')
        {
            $ret = [];
            foreach($this->result['content'] as $tweet)
            {
                
                if(in_array ($tweet->lang, array_keys($ret)))
                {
                    $ret[$tweet->lang] += 1;
                }
                else
                {
                    $ret[$tweet->lang] = 1;
                }
            }
            return $ret;
        }
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

    private function deleteDirectory($path)
    {
        //Liste les noms des fichiers
        $files = glob('../' . $path . '/*');

        //Supprime les fichiers
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
        //suppression du dossier vide
        if (is_dir('../' . $path)) {
            rmdir('../' . $path);
        }
    }

    private function unaccent($text)
    {
        $search_replace  = [
            'A'=>['À', 'Á', 'Â', 'Ã', 'Ä', 'Å'], 
            'C'=>['Ç'],
            'E'=>['È', 'É', 'Ê', 'Ë'], 
            'I'=>['Ì', 'Í', 'Î', 'Ï'], 
            'O'=>['Ò', 'Ó', 'Ô', 'Õ', 'Ö'], 
            'U'=>['Ù', 'Ú', 'Û', 'Ü'],
            'Y'=>['Ý'], 
            'a'=>['à', 'á', 'â', 'ã', 'ä', 'å'], 
            'c'=>['ç'],
            'e'=>[ 'è', 'é', 'ê', 'ë'],
            'i'=> ['ì', 'í', 'î', 'ï'], 
            'o'=>['ð', 'ò', 'ó', 'ô', 'õ', 'ö'], 
            'u'=>['ù', 'ú', 'û', 'ü'], 
            'y'=>['ý', 'ÿ']
        ];
        $resultat = $text;
        foreach($search_replace as $replace=>$search)
        {
            $resultat = str_replace($search,$replace, $resultat);
        }
        return $resultat;
    }
}
