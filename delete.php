<?php

$response = [
    'status' => 'Error',
];

if (!empty($_POST['name'])) {
    $dir = __DIR__ . '/upload';
    $image = $dir . '/' . $_POST['name'];

    if (is_dir($dir)) {
        if (is_file($image)) {
            unlink($image);
        } else {
            $response['message'] = 'Image not found!';
        }
    } else {
        $response['message'] = 'Upload directory not found!';
    }

    $response['status'] = 'Success';
    $response['message'] = 'Image deleted!';
}

echo json_encode($response);