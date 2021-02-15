<?php

namespace EllipticCurve\Utils;

class File {
    static function read($path, $mode="r") {
        $file = fopen($path, $mode);
        $content = fread($file, filesize($path));
        fclose($file);
        return $content;
    }
}

?>