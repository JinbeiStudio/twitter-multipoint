<?php
if(!isset($_SESSION['token']))
{
    $_SESSION['token'] = 't_' . rand(0,999999) . '_' . date('Y-m-d');
}