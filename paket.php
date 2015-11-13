<?php

function htmlTemplate($image_name, $menu) {
    $image_height = imageHeight($image_name);
    return "<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Demo</title>
<link rel='stylesheet' href='style.css'>
</head>
<body style='background-image: url(images/{$image_name}); height:{$image_height}'>
    <div id='wrap'>
        {$menu}
    </div>
</body>
</html>";
}

function imageHeight($image_name) {
    return imagesy('resim/images/' . $image_name);
}

if (!is_dir('resim')) {
    echo 'Empty images folder!';
    exit;
}

if (!is_dir('resim/images')) {
    mkdir('resim/images');
}

# START -- Build Menu
$menu = '';
$i = 0;
$dir = opendir('resim');
while ($file_name = readdir($dir)) {
    if ($file_name != '.' && $file_name != '..' && $file_name != '.DS_Store') {
        $index = $i == 0 ? '' : $i;
        $page_no = $i + 1;
        $menu .= "<div class='thumb'><a href='index{$index}.html'><div class='siyah'><span>{$page_no}</span></div></a></div>";
        $i++;
    }
    rename($file_name, 'images/' . $file_name);
}
closedir($dir);
# END -- Build Menu

# START -- Create HTML File
$i = 0;
$dir = opendir('resim/images');
while ($file_name = readdir($dir)) {
    $index = $i == 0 ? '' : $i;

    if ($file_name != '.' && $file_name != '..' && $file_name != '.DS_Store') {
        $sablon = htmlTemplate($file_name, $menu);
        $i++;
        $olustur = fopen('resim/index' . $index . '.html', 'w');
        fwrite($olustur, $sablon);
        fclose($olustur);
    }
}
closedir($dir);
# END -- Create HTML File

# START -- Create CSS File
$css_content = "body {margin:0; padding:0;  background:no-repeat; !important; background-size:1920px; background-position:top center;}
#wrap {position:absolute; top:30px; right:10px; width:60px;}
.thumb {width:60px; height:60px; float:left; margin:5px 0 0 0; float:left;}
.thumb img {width:60px;height:60px;  margin:5px 0 0 0;}
.siyah {background-color:#000;width:60px;height:60px}
.siyah span {color:#fff;font-size:41px;margin-left:9px;margin-top:7px;position:absolute}
img {border: none}
a {text-decoration:none}";
$css_file = fopen('resim/style.css', 'w');
fwrite($css_file, $css_content);
fclose($css_file);
# END -- Create CSS File

# START -- Create ZIP File
$rootPath = realpath(__DIR__ . '/resim');

$zip = new ZipArchive();
$zip->open('indir.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

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

