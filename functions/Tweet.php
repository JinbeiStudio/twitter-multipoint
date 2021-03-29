<?php
class Tweet
{

    function __construct($datas, $token)
    {
        //Pour chaque champs récupérés, on crée un attribut
        foreach ($datas as $field => $data) {
            $this->$field = $data;
        }

        $this->imgLoaded = false;
        $this->token = $token;
    }

    function display()
    {
        //On charge les images si besoin
        if (!$this->imgLoaded) {
            $this->loadImages();
        }

        //Affecte les variables necessaires à l'affichage du tweet avec des valeurs par défaut en cas d'absence
        $this->name = (trim($this->user["name"]) ?: 'pas de nom');
        $this->created_at = ($this->created_at ? new DateTime($this->created_at) : 'Pas de date');
        $this->created_at = (gettype($this->created_at) === 'string' ?: $this->created_at->format('d F Y H:i:s'));


        // Tweet ou RT
        $this->text = ($this->full_text ?: 'pas de texte');
        if ($this->retweeted_status) {
            $this->text = 'RT @' . $this->retweeted_status["user"]["screen_name"] . '&nbsp;: ' . $this->retweeted_status["full_text"];
        }

        $this->linkifyHashtag('text'); // Ajout des liens sur les #hashtag
        $this->linkifyAt('text'); // Ajout des liens sur les @utilisateur
        $this->linkifyLink('text'); // Ajout des liens sur les liens

        /* Gestion des Citations (RT avec commentaires) */
        if ($this->quoted_status["full_text"]) {
            $this->quote = true;
            $this->quote_user = $this->quoted_status["user"]["name"];
            $this->quote_text = $this->quoted_status["full_text"];
            $this->linkifyHashtag('quote_text')->linkifyAt('quote_text')->linkifyLink('quote_text');
        }
        /* Gestion des Citations dans un RT */
        if ($this->retweeted_status["is_quote_status"]) {
            $this->RT_quote = true;
            $this->RT_quote_user = $this->retweeted_status["quoted_status"]["user"]["name"];
            $this->RT_quote_text = $this->retweeted_status["quoted_status"]["full_text"];
            $this->linkifyHashtag('RT_quote_text')->linkifyAt('RT_quote_text')->linkifyLink('RT_quote_text');
        }

        /* Gestion du footer */
        // URL du tweet d'origine
        $this->url = 'https://twitter.com/' . $this->user["screen_name"] . '/status/' . $this->id;
        // Nombre du like 
        $this->favorite_count = ($this->retweeted_status) ? $this->retweeted_status["favorite_count"] : $this->favorite_count;
    }

    function loadImages()
    {
        $this->imgLoaded = true;

        //Valeurs par défauts
        $this->user["profile_image_temp"] = "./src/img/default_profile_400x400.png";
        $this->user["profile_banner_temp"] = "./src/img/default_background_400x133.jpg";

        //si une image de profil est présente
        if (!empty($this->user["profile_image_url"])) {
            $url = $this->user["profile_image_url"];
            $parse = parse_url($url);

            //si l'host revoie vers un domaine valide
            if ($parse['host'] !== 'abs.twimg.com') {
                //On la rename et on la sauvegarde
                $userPicture = basename($url);

                //On crée le dossier s'il n'existe pas
                if (!is_dir('tmp/' . $this->token)) {
                    mkdir('tmp/' . $this->token);
                }

                //On déplace le fichier
                $path = 'tmp/' . $this->token . '/' . $userPicture;
                if (!file_exists($path)) {
                    file_put_contents($path, file_get_contents($url));
                }

                //On mémorise l'emplacement du fichier
                $this->user["profile_image_temp"] = $path;
            }
        }

        //si une bannière est présente
        if (!empty($this->user["profile_banner_url"])) {
            $url = $this->user["profile_banner_url"];
            $userBackground = basename($url);

            //On crée le dossier s'il n'existe pas
            if (!is_dir('tmp/' . $this->token)) {
                mkdir('tmp/' . $this->token);
            }

            //On détermine le chemin du fichier
            $path = 'tmp/' . $this->token . '/' . $userBackground;

            //Si le fichier n'existe pas
            if (!file_exists($path)) {
                //On stocke l'image récupérée
                $content = @file_get_contents($url);

                //si l'image à bien été récupérée
                if ($content !== FALSE) {
                    $save = @file_put_contents($path, $content);
                    if ($save !== FALSE) {
                        //On mémorise l'emplacement du fichier
                        $this->user["profile_banner_temp"] =  $path;
                    }
                }
            } elseif (file_exists($path)) {
                //On mémorise l'emplacement du fichier
                $this->user["profile_banner_temp"] = $path;
            }
        }
    }

    function deleteImages()
    {
        //Si l'image de profil n'est pas celle par défaut
        if ($this->user["profile_image_temp"] !== './src/img/default_profile_400x400.png') {
            //On supprime l'image
            unlink($this->user["profile_image_temp"]);
        }

        //Si l'image de bannière n'est pas celle par défaut
        if ($this->user["profile_banner_temp"] !== './src/img/default_background_400x234.jpg') {
            //On supprime l'image
            unlink($this->user["profile_banner_temp"]);
        }
    }

    /**
     * @param string $key
     */
    private function linkifyHashtag($key)
    {
        $this->$key = preg_replace('/(?:^|\s)#([0-9A-Za-zÀ-ÖØ-öø-ÿ_]+)/', ' <a href="https://twitter.com/search?q=%23$1" class="hashtag" target="_blank">#$1</a>', $this->$key);
        return $this;
    }

    /**
     * @param string $key
     */
    private function linkifyAt($key)
    {
        $this->$key = preg_replace('/(?:^|\s)@(\w+)/', ' <a href="https://twitter.com/$1" class="user" target="_blank">@$1</a>', $this->$key);
        return $this;
    }

    /**
     * @param string $key
     */
    private function linkifyLink($key)
    {
        $this->$key = preg_replace('/(?:^|\s)https:\/\/t.co\/(\w+)/', ' <a href="https://t.co/$1" target="_blank">https://t.co/$1</a>', $this->$key);
        return $this;
    }
}
