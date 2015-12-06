<?php

function removeDirRec($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (is_dir($dir. '/' .$object))
                    removeDirRec($dir. '/' .$object);
                else
                    unlink($dir. '/' .$object);
            }
        }
        rmdir($dir);
    }
}

if (file_exists(__DIR__ . '/demo.zip')) {
    unlink(__DIR__ . '/demo.zip');
}

if (is_dir(__DIR__ . '/upload')) {
    removeDirRec(__DIR__ . '/upload');
}

if (is_dir(__DIR__ . '/template/img')) {
    removeDirRec(__DIR__ . '/template/img');
}

if (file_exists(__DIR__ . '/template/setting.json')) {
    unlink(__DIR__ . '/template/setting.json');
}