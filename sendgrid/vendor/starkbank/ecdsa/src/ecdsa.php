<?php

namespace EllipticCurve;
use EllipticCurve\Signature;


class Ecdsa {
    
    public static function sign ($message, $privateKey) {
        $signature = null;
        openssl_sign($message, $signature, $privateKey->openSslPrivateKey, OPENSSL_ALGO_SHA256);
        return new Signature($signature);
    }

    public static function verify ($message, $signature, $publicKey) {
        $success = openssl_verify($message, $signature->toDer(), $publicKey->openSslPublicKey, OPENSSL_ALGO_SHA256);
        if ($success == 1) {
            return true;
        }
        return false;
    }
}

?>