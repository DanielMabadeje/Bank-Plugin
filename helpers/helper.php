<?php

function model($model){
     //Requires Model FIle
     require_once (plugin_dir_path( __FILE__ ).'../model/'.$model.'.php');
     
               //Instantiate Model
               return new $model();
}


function generate_random_Chars()
{
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($charset), 0, 8);
}