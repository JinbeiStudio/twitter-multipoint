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
        return '<pre>' . print_r($this) . '</pre>';
    }
}