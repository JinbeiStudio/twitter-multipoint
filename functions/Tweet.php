<?php
class Tweet
{
    function __construct($datas)
    {
        //$this->data = $datas;
        foreach($datas as $field=>$data)
        {
            $this->$field = $data;
        }
    }

    function display()
    {
        $name = $this->user["name"] . 'test';
        $created_at = $this->created_at;
        $text = $this->text;

        // return '<pre>' . print_r($this->created_at) . '</pre>';
        return  "<div class='card' style='width: 18rem;'>
            <div class='card-body'>
                <h5 class='card-title'> $name </h5>
                <h6>$created_at</h6>
                <p class='card-text'> $text</p>
                </div>
            ";

    }
}