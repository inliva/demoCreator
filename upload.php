<?php

if (!empty($_FILES)) {

    $temp = $_FILES['file']['tmp_name'];
    // $ds = DIRECTOR_SEPARATOR;

    $dosya = '/resim';

    $kaydetPath = dirname(__FILE__).'/'.$dosya.'/';
    $hedefdosya = $kaydetPath.$_FILES['file']['name'];

    move_uploaded_file($temp, $hedefdosya);


}