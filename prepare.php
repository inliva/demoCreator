<?php

$response = ['status' => 'Error'];

// Get settting data from post
$setting_json = $_POST['setting'];

# START -- Check Setting Data
if (empty($setting_json)) {
    $response['message'] = 'Empty data!';
    response();
}

$setting = json_decode($setting_json);

if (!is_object($setting) || empty($setting->images)) {
    $response['message'] = 'Empty data!';
    response();
}
# END -- Check Setting Data

// Response and finish
function response() {
    global $response;
    echo json_encode($response);
    exit;
}

// Check uploaded images
if (!is_dir(__DIR__ . '/upload')) {
    $response['message'] = 'Empty images folder!';
    response();
}

// Check image target directory
if (!is_dir('template/img')) {
    mkdir('template/img');
}

# START -- Move Images
$menu = '';
$i = 0;
$dir = opendir('upload');

while ($file_name = readdir($dir)) {
    rename(__DIR__ . '/upload/' . $file_name, __DIR__ . '/template/img/' . $file_name);
}
closedir($dir);
# END -- Move Images


# START -- Create Setting JSON file
$setting_file = fopen('template/setting.json', 'w');
fwrite($setting_file, $setting_json);
fclose($setting_file);
# END -- Create Setting JSON file


# START -- Create ZIP File
$rootPath = __DIR__ . '/template';

$zip = new ZipArchive();
$zip->open('demo.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();
# END -- Create ZIP File

$response['status'] = 'Success';
$response['message'] = 'Zip file created!';
response();