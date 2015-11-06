<?php


$menu = '';
$i = 0;
$dizin = opendir('resim');

	while($dosya = readdir($dizin)) {
		//$indexno = explode('.', $dosya);
		if($dosya != '.' && $dosya != '..' && $dosya != '.DS_Store'){
			$indexno = $i == 0 ? '' : $i;
			$sayfano = $i+1;
		   	$menu .= "<div class='thumb'><a href='index{$indexno}.html'><div class='siyah'><span>{$sayfano}</span></div></a></div>";
		   	$i++;
	   }
	}
	
	$i = 0;
	$dizin = opendir('resim');
	while($dosya = readdir($dizin)) {

		$indexno = $i == 0 ? '' : $i;
		if($dosya != '.' && $dosya != '..' && $dosya != '.DS_Store'){
			
		$sablon =  "
			
			<!DOCTYPE html>
			<html>
			<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>demo</title>
			<style type='text/css'>
				body		{margin:0; padding:0;  background:url({$dosya}) no-repeat; !important; background-size:1920px; background-position:top center; height:1420px;}
				#wrap		{position:absolute; top:30px; right:10px; width:60px;}
				.thumb		{width:60px; height:60px; float:left; margin:5px 0 0 0; float:left;}
				.thumb img	{width:60px;height:60px;  margin:5px 0 0 0;}
				.siyah {background-color:#000;width:60px;height:60px}
				.siyah span {color:#fff;font-size:41px;margin-left:9px;margin-top:7px;position:absolute}
				img {border: none} 
				a {text-decoration:none}
			</style>
			</head>
			<body>
				<div id='wrap'>
					{$menu}
				</div>
			</body>
			</html>


        ";
      
		 $i++;

		 $olustur = fopen('resim/index'.$indexno.'.html', 'w');

		fwrite($olustur, $sablon);
		fclose($olustur);
	   }

	}

$rootPath = realpath(__DIR__ . '/resim');

$zip = new ZipArchive();
$zip->open('indir.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();

