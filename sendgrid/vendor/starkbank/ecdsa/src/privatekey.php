<?php

namespace EllipticCurve;
use EllipticCurve\PublicKey;


class PrivateKey {
    function __construct($curve="secp256k1", $openSslPrivateKey=null) {
        if (is_null($openSslPrivateKey)) {
            $config = array(
                "digest_alg" => "sha256",
                "private_key_bits" => 2048,
                "private_key_type" => OPENSSL_KEYTYPE_EC,
                "curve_name" => $curve
            );

            $response = openssl_pkey_new($config);

            openssl_pkey_export($response, $openSslPrivateKey, null, $config);

            $openSslPrivateKey = openssl_pkey_get_private($openSslPrivateKey);
        }

        $this->openSslPrivateKey = $openSslPrivateKey;
    }

    function publicKey() {
        $openSslPublicKey = openssl_pkey_get_details($this->openSslPrivateKey)["key"];

        return new PublicKey($openSslPublicKey);
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
        openssl_pkey_export($this->openSslPrivateKey, $out, null);
        return $out;
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
        return new PrivateKey(null, openssl_get_privatekey($rebuilt));
    }

    static function fromDer ($str) {
        $pem_data = base64_encode($str);
        $pem = "-----BEGIN EC PRIVATE KEY-----\n" . substr($pem_data, 0, 64) . "\n" . substr($pem_data, 64, 64) . "\n" . substr($pem_data, 128, 64) . "\n-----END EC PRIVATE KEY-----\n";
        return new PrivateKey(null, openssl_get_privatekey($pem));
    }

    static function fromString ($str) {
        return PrivateKey::fromDer(base64_decode($str));
    }

}

?>