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
        $this->name = ($this->user["name"] ?: 'pas de nom');
        $this->text = ($this->text ?: 'pas de texte');
        $this->created_at = ($this->created_at ? new DateTime($this->created_at) : 'Pas de date');
        $this->created_at = (gettype($this->created_at) === 'string' ?: $this->created_at->format('Y-m-d H:i:s'));
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
                if(!file_exists($path))
                {
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
            if (!file_exists($path)) 
            {
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
                
                
                    
            }
            elseif(file_exists($path))
            {
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
}
