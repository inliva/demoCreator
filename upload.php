<?php

if (!empty($_FILES)) {

    $temp_img = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];

    if (!is_dir('resim')) {
        mkdir('resim');
    }

    $save_path_and_name = dirname(__FILE__) . '/resim/' . $name;

    move_uploaded_file($temp_img, $save_path_and_name);
}