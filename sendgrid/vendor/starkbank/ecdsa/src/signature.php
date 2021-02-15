<?php

namespace EllipticCurve;


class Signature {

    function __construct ($der) {
        $this->der = $der;
    }

    function toDer () {
        return $this->der;
    }

    function toBase64 () {
        return base64_encode($this->der);
    }

    static function fromDer ($str) {
        return new Signature($str);
    }

    static function fromBase64 ($str) {
        return new Signature(base64_decode($str));
    }
}

?>