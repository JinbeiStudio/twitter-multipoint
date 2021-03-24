<?php
class Tweet
{
    function __construct($datas)
    {
        //Pour chaque champs récupérés, on crée un attribut
        foreach($datas as $field=>$data)
        {
            $this->$field = $data;
        }
    }

    function display()
    {
        //Affecte les variables necessaires à l'affichage du tweet avec des valeurs par défaut en cas d'absence
            $name = $this->user["name"] ?: 'pas de nom';
            $text = $this->text ?: 'pas de texte';
            $created_at = $this->created_at ? new DateTime($this->created_at) : 'Pas de date';
            $created_at = gettype($created_at)==='string' ?: $created_at->format('Y-m-d H:i:s');

            $userPicture = "./src/img/default_profile_400x400.png";

        if (!empty($this->user["profile_image_url"])) {
            $userPicture = $this->user["profile_image_url"];
            $parse = parse_url($userPicture);
            $this->picFileName = '../src/img/default_profile_400x400.png';

            //si l'image est présente
            if (!$parse['host'] == 'abs.twimg.com') {
                //On la rename et on la sauvegarde
                $this->picFileName = basename($userPicture);
                file_put_contents('tmp/' .  $this->picFileName, file_get_contents($userPicture));
            }
        }

        if (!empty($this->user["profile_banner_url"])) {
            $url = $this->user["profile_banner_url"];
            $userBackground = basename($url);
            file_put_contents('tmp/' . $userBackground, file_get_contents($url));
            $userBackground = 'tmp/' . $userBackground;
        }

        return  "
        <div class='card m-2' style='width: 18rem;'>" .
            ( ($userBackground) ? "<img src='<?php echo $userBackground; ?>' class='card-img-top' style='margin-bottom: -44px;'>":'') .
            "<div class='card-body'>
                <div class='$userPicture'><img src='<?php echo 'tmp/' . $this->picFileName; ?>' class='rounded-circle mx-auto d-block shadow-sm' width='48' height='48' /></div>
                <h5 class='card-title'><?php echo $name; ?></h5>
                <h6><?php echo $created_at; ?></h6>
                <p class='card-text'><?php echo $text; ?></p>
            </div><!-- .card-body -->
        </div><!-- .card -->
            ";

    }

    function __destruct() {
        if($this->picFileName === '../src/img/default_profile_400x400.png')
        {
            //On supprime l'image
            unlink($this->picFileName);
            echo('On detruit '. $this->picFileName);
        }
    }
}