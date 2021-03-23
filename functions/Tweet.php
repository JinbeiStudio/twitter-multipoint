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
            $name = $this->user["name"] ?: 'name';
            $created_at = $this->created_at ?: 'date';
            $text = $this->text ?: 'text';

        return  "<div class='card' style='width: 18rem;'>
            <div class='card-body'>
                <h5 class='card-title'> $name </h5>
                <h6>$created_at</h6>
                <p class='card-text'> $text</p>
                </div>
            ";

    }
}