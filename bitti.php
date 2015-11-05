<?php
$zipname = 'indir.zip';

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);


// function yonlendir($url, $time = 3){ // Time değeri yoksa 3 sn alır.
  
//   if ($time) header("Refresh: {$time}; url={$url}");
//   else header("Location: {$url}");
// }

function klasorSil($dir) {
if (substr($dir, strlen($dir)-1, 1)!= '/')
$dir .= '/';
//echo $dir; //silinen klasörün adı
if ($handle = opendir($dir)) {
	while ($obj = readdir($handle)) {
		if ($obj!= '.' && $obj!= '..') {
			if (is_dir($dir.$obj)) {
				if (!klasorSil($dir.$obj))
					return false;
				} elseif (is_file($dir.$obj)) {
					if (!unlink($dir.$obj))
						return false;
					}
			}
	}
		closedir($handle);
	}
return false;
}
unlink('indir.zip');
klasorSil('resim');