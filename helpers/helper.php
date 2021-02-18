<?php

function model($model){
     //Requires Model FIle
     require_once '../app/models/'.$model.'.php';
     
               //Instantiate Model
               return new $model();
}