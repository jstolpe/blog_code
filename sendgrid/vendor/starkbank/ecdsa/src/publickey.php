<?php

namespace EllipticCurve;


class PublicKey {
    
    function __construct ($pem) {
        $this->pem = $pem;
        $this->openSslPublicKey = openssl_get_publickey($pem);
    }

    function toString () {
        return base64_encode($this->toDer());
    }

    function toDer () {
        $pem = $this->toPem();
    
        $lines = array();
        foreach(explode("\n", $pem) as $value) { 
            if (substr($value, 0, 5) !== "-----") {
                array_push($lines, $value);
            }
        }

        $pem_data = join("", $lines);

        return base64_decode($pem_data);
    }

    function toPem () {
        return $this->pem;
    }

    static function fromPem ($str) {
        $rebuilt = array();
        foreach(explode("\n", $str) as $line) { 
            $line = trim($line);
            if (strlen($line) > 1) {
                array_push($rebuilt, $line);
            }
        };
        $rebuilt = join("\n", $rebuilt) . "\n";
        return new PublicKey($rebuilt);
    }

    static function fromDer ($str) {
        $pem_data = base64_encode($str);
        $pem = "-----BEGIN PUBLIC KEY-----\n" . substr($pem_data, 0, 64) . "\n" . substr($pem_data, 64) . "\n-----END PUBLIC KEY-----\n";
        return new PublicKey($pem);
    }

    static function fromString ($str) {
        return PublicKey::fromDer(base64_decode($str));
    }

}

?>