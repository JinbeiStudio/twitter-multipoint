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
        $this->created_at = (gettype($this->created_at) === 'string' ?: $this->created_at->format('d/m/Y H:i:s'));

        // Tweet ou RT
        $this->text = ($this->full_text ?: 'pas de texte');
        if ($this->retweeted_status) {
            $this->text = 'RT <a href="https://twitter.com/' . str_replace(' ', '_', $this->retweeted_status["user"]["name"]) . '">@' . $this->retweeted_status["user"]["name"] . '</a>&nbsp;: ' . $this->retweeted_status["full_text"];
        }
        // Ajout des #hastags
        $this->text = preg_replace('/(?:^|\s)#([0-9A-Za-zÀ-ÖØ-öø-ÿ]+)/', ' <a href="https://twitter.com/search?q=%23$1">#$1</a>', $this->text);
        // Ajout des @utilisateur
        $this->text = preg_replace('/(?:^|\s)@(\w+)/', ' <a href="https://twitter.com/$1">@$1</a>', $this->text);
        // Ajout des liens
        $this->text = preg_replace('/(?:^|\s)https:\/\/t.co\/(\w+)/', ' <a target="_blank" href="https://t.co/$1">https://t.co/$1</a>', $this->text);


        /* Gestion des Citation (RT avec commentaires) */
        if ($this->is_quote_status) {
            $this->quote = true;
            $this->quote_user = $this->quoted_status["user"]["name"];
            $this->quote_text = preg_replace('/(?:^|\s)#(\w+)/', ' <a href="https://twitter.com/search?q=%23$1">#$1</a>', $this->quoted_status["full_text"]);
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

                //On crée le fichier s'il n'existe pas
                if (!is_dir('tmp/' . $this->token)) {
                    mkdir('tmp/' . $this->token);
                }

                //On déplace le fichier
                file_put_contents('tmp/' . $this->token . '/' . $userPicture, file_get_contents($url));

                //On mémorise l'emplacement du fichier
                $this->user["profile_image_temp"] = 'tmp/' . $this->token . '/' . $userPicture;
            }
        }

        //si une bannière est présente
        if (!empty($this->user["profile_banner_url"])) {
            $url = $this->user["profile_banner_url"];
            $userBackground = basename($url);

            //On crée le fichier s'il n'existe pas
            if (!is_dir('tmp/' . $this->token)) {
                mkdir('tmp/' . $this->token);
            }

            $content = @file_get_contents($url);
            //On déplace le fichier

            if ($content !== FALSE) {
                $save = @file_put_contents('tmp/' . $this->token . '/' . $userBackground, $content);
                if ($save !== FALSE) {
                    $this->user["profile_banner_temp"] = 'tmp/' . $this->token . '/' . $userBackground;
                }
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
}
