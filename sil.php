<?php

function removeDirRec($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object))
                    removeDirRec($dir."/".$object);
                else
                    unlink($dir."/".$object);
            }
        }
        rmdir($dir);
    }
}

if (file_exists('indir.zip')) {
    unlink('indir.zip');
}

if (is_dir('resim')) {
    removeDirRec('resim');
}