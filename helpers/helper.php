<?php
// For Session
session_start();

// For Model
function model($model){
     //Requires Model FIle
     require_once (plugin_dir_path( __FILE__ ).'../model/'.$model.'.php');
     
               //Instantiate Model
               return new $model();
}


// to generate random characters
function generate_random_Chars()
{
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($charset), 0, 8);
}


// for redirection

function redirect($page)
{
    // header('location:'.$page);
    echo '<script language="javascript">window.location.href ="'.$page.'"</script>';
}