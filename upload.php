<?php

if (!empty($_FILES)) {
    $temp_img = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];

    if (!is_dir(__DIR__ . '/resim')) {
        mkdir(__DIR__ . '/resim');
    }

    $save_path_and_name = __DIR__ . '/resim/' . $name;
    echo $save_path_and_name;
}