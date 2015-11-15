<?php

function htmlTemplate($image_name, $menu) {
    $page_height = pageHeight($image_name);
    return "<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Demo</title>
<link rel='stylesheet' href='style.css'>
</head>
<body style='background-image: url(images/{$image_name}); height:{$page_height}px;'>
    <div class='wrap left'>
        {$menu}
    </div>
</body>
</html>";
}

function pageHeight($image_name) {

    $image_sizes = getimagesize('resim/images/' . $image_name);
    $height = $image_sizes[1] / ($image_sizes[0] / 1920);
    return $height;
}

function realExists($file_name) {
    return $file_name != '.' && $file_name != '..' && $file_name != '.DS_Store' ? true : false;
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
    if (realExists($file_name) && !is_dir('resim/' . $file_name)) {
        $index = $i == 0 ? '' : $i;
        $page_no = $i + 1;
        $menu .= "<div class='thumb'>" .
            "<img src='images/{$file_name}' />" .
            "<a href='index{$index}.html'><span>{$page_no}</span></a>" .
            "</div>";
        $i++;
    }
    rename(__DIR__ . '/resim/' . $file_name, __DIR__ . '/resim/images/' . $file_name);
}
closedir($dir);
# END -- Build Menu

# START -- Create HTML File
$i = 0;
$dir = opendir('resim/images');
while ($file_name = readdir($dir)) {
    $index = $i == 0 ? '' : $i;

    if (realExists($file_name)) {
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
$css_content = "body {margin:0; padding:0;  background:no-repeat; background-size:1920px; background-position:top center;}
.wrap {position:fixed; width:60px;}
.wrap.left {left:10px;}
.wrap.right {right:10px;}
.thumb {position:relative; width:60px; height:60px; float:left; margin-top:10px; box-shadow: 0 0 5px 2px #333;}
.thumb img {position:absolute; left:0; top:0; width:60px;height:60px;z-index:1;}
.thumb a {display:block; position:absolute; left:0; top:0; width:60px;height:60px; text-align:center; z-index:2; background-color: rgba(0, 0, 0, 0.50);}
.thumb a span {color:#fff;font-size:48px;text-shadow: 1px 1px 1px #000;}
img {border: none}
a {text-decoration:none}";
$css_file = fopen('resim/style.css', 'w');
fwrite($css_file, $css_content);
fclose($css_file);
# END -- Create CSS File

# START -- Create ZIP File
$rootPath = __DIR__ . '/resim';

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

