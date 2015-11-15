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

if (file_exists(__DIR__ . 'indir.zip')) {
    unlink(__DIR__ . 'indir.zip');
}

if (is_dir(__DIR__ . 'resim')) {
    removeDirRec(__DIR__ . 'resim');
}