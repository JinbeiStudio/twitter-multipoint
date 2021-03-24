<?php
class Tweet
{
    function __construct($datas)
    {
        //Pour chaque champs récupérés, on crée un attribut
        foreach ($datas as $field => $data) {
            $this->$field = $data;
        }
    }

    function display()
    {
        //Affecte les variables necessaires à l'affichage du tweet avec des valeurs par défaut en cas d'absence
        $name = $this->user["name"] ?: 'name';
        $created_at = $this->created_at ?: 'date';
        $text = $this->text ?: 'text';

        return  "<div class='card' style='width: 18rem;'>
                    <div class='card-body'>
                        <h5 class='card-title'> $name </h5>
                        <h6>$created_at</h6>
                        <p class='card-text'> $text</p>
                    </div>
                </div>
            ";
    }

    function loadImages()
    {
        $this->user["profile_image_temp"] = "./src/img/default_profile_400x400.png";
        $this->user["profile_banner_temp"] = "./src/img/default_background_400x133.jpg";

        if (!empty($this->user["profile_image_url"])) {
            $url = $this->user["profile_image_url"];
            $parse = parse_url($url);
            if ($parse['host'] !== 'abs.twimg.com') {
                $userPicture = basename($url);
                file_put_contents('tmp/' . $userPicture, file_get_contents($url));
                $this->user["profile_image_temp"] = 'tmp/' . $userPicture;
            }
        }

        if (!empty($this->user["profile_banner_url"])) {
            $url = $this->user["profile_banner_url"];
            $userBackground = basename($url);
            file_put_contents('tmp/' . $userBackground, file_get_contents($url));
            $this->user["profile_banner_temp"] = 'tmp/' . $userBackground;
        }
    }
}
