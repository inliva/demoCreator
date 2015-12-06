<?php

if (is_file(__DIR__ . '/demo.zip')) {
    $zip_name = 'demo.zip';
    $zip_file = __DIR__ . '/' . $zip_name;

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zip_name);
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);
} else {
    header('Location: ' . 'index.php');
}

?>