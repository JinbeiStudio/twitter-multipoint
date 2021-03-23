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
        $name = 'name';
        $created_at = 'date';
        $text = 'text';
        if(isset($this->user["name"]))
        {
            $name = $this->user["name"];
        }
        
        if(isset($this->created_at))
        {
            $created_at = $this->created_at;
        }

        if(isset($this->text)){
            $text = $this->text;
        }
        
        

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