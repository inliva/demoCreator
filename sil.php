<?php
function klasorSil($dir) {
    if (substr($dir, strlen($dir)-1, 1)!= '/') {
        $dir .= '/';
    }
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

if (file_exists('indir.zip')) {
    unlink('indir.zip');
}

if (is_dir('resim')) {
    klasorSil('resim');
}

?>