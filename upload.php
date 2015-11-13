<?php

if (!empty($_FILES)) {

    $temp_img = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $extension = strtolower(pathinfo($temp_img, PATHINFO_EXTENSION));

    $dir = '/resim';

    switch ($extension) {
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($temp_img);
            break;

        case 'png':
            $image = imagecreatefrompng($temp_img);
            break;

        case 'gif':
            $image = imagecreatefromgif($temp_img);
            break;

        default:
            throw new InvalidArgumentException('File "' . $temp_img . '" is not valid jpg, png or gif image.');
            break;
    }

    $imagey = imagesy($image);

    $save_path = dirname(__FILE__).'/'.$dir.'/';
    $hedefdosya = $save_path . $temp_img;

    move_uploaded_file($temp_img, $hedefdosya);

}