<?php

function sef($string) {
    $sef = trim($string);
    $sef = strtolower($sef);
    $find = array('<b>', '</b>');
    $sef = str_replace ($find, '', $sef);
    $find = array(' ', '&quot;', '&amp;', '&', '\r\n', '\n', '/', '\\', '+', '<', '>');
    $sef = str_replace ($find, '-', $sef);
    $find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
    $sef = str_replace ($find, 'e', $sef);
    $find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
    $sef = str_replace ($find, 'a', $sef);
    $find = array('í', 'ì', 'î', 'ï', 'ı', 'İ', 'Í', 'Ì', 'Î', 'Ï');
    $sef = str_replace ($find, 'i', $sef);
    $find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
    $sef = str_replace ($find, 'o', $sef);
    $find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
    $sef = str_replace ($find, 'u', $sef);
    $find = array('ç', 'Ç');
    $sef = str_replace ($find, 'c', $sef);
    $find = array('ş', 'Ş');
    $sef = str_replace ($find, 's', $sef);
    $find = array('ğ', 'Ğ');
    $sef = str_replace ($find, 'g', $sef);
    $find = array('/[^a-z0-9\-.<>]/', '/[\-]+/', '/<[^>]*>/');
    $repl = array('', '-', '');
    $sef = preg_replace ($find, $repl, $sef);
    if (strrpos($sef, -1) == '-') $sef = strpos($sef, 0, -1);
    $sef = str_replace ('--', '-', $sef);

    return $sef;
}

if (!empty($_FILES)) {
    $temp_img = $_FILES['file']['tmp_name'];
    $name = sef($_FILES['file']['name']);

    if (!is_dir(__DIR__ . '/upload')) {
        mkdir(__DIR__ . '/upload');
    }

    $save_path_and_name = __DIR__ . '/upload/' . $name;
    move_uploaded_file($temp_img, $save_path_and_name);

    $response = [
        'path' => 'upload/',
        'name' => $name
    ];

    echo json_encode($response);
}