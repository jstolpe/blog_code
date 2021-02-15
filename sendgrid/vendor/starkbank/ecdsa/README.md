## A lightweight and fast PHP ECDSA

### Overview

This is a PHP implementation of the Elliptic Curve Digital Signature Algorithm. It is compatible with PHP 5.5+. Please note that this library relies heavily on the openssl package for PHP, so - depending on you PHP installation - you may need to re-compile it with the "–with-openssl" flag.

### Installation

#### Composer

To install the package with Composer, run:

```sh
composer require starkbank/ecdsa
```

To use the bindings, use Composer's autoload:

```sh
require_once('vendor/autoload.php');
```

### Curves

The module is wrapped around the builtin openssl functions, so all standar curves should be supported. The default is `secp256k1`.

### Speed

We ran a test on a MAC Pro i7 2017. We ran the library 100 times and got the average time displayed bellow:

| Library            | sign          | verify  |
| ------------------ |:-------------:| -------:|
| starkbank-ecdsa    |     0.6ms     |  0.4ms  |

### Sample Code

How to sign a json message for [Stark Bank]:

```php

# Generate privateKey from PEM string
$privateKey = EllipticCurve\PrivateKey::fromPem("
    -----BEGIN EC PARAMETERS-----
    BgUrgQQACg==
    -----END EC PARAMETERS-----
    -----BEGIN EC PRIVATE KEY-----
    MHQCAQEEIODvZuS34wFbt0X53+P5EnSj6tMjfVK01dD1dgDH02RzoAcGBSuBBAAK
    oUQDQgAE/nvHu/SQQaos9TUljQsUuKI15Zr5SabPrbwtbfT/408rkVVzq8vAisbB
    RmpeRREXj5aog/Mq8RrdYy75W9q/Ig==
    -----END EC PRIVATE KEY-----
");


# Create message from json
$message = array(
    "transfers" => array(
        array(
            "amount" => 100000000,
            "taxId" => "594.739.480-42",
            "name" => "Daenerys Targaryen Stormborn",
            "bankCode" => "341",
            "branchCode" => "2201",
            "accountNumber" => "76543-8",
            "tags" => array("daenerys", "targaryen", "transfer-1-external-id")
        )
    )
);

$message = json_encode($message, JSON_PRETTY_PRINT);

$signature = EllipticCurve\Ecdsa::sign($message, $privateKey);

# Generate Signature in base64. This result can be sent to Stark Bank in header as Digital-Signature parameter
echo "\n" . $signature->toBase64();

# To double check if message matches the signature
$publicKey = $privateKey->publicKey();

echo "\n" . EllipticCurve\Ecdsa::verify($message, $signature, $publicKey);

```

Simple use:

```php

# Generate new Keys
$privateKey = new EllipticCurve\PrivateKey;
$publicKey = $privateKey->publicKey();

$message = "My test message";

# Generate Signature
$signature = EllipticCurve\Ecdsa::sign($message, $privateKey);

# Verify if signature is valid
echo "\n" . EllipticCurve\Ecdsa::verify($message, $signature, $publicKey);

```

### OpenSSL

This library is compatible with OpenSSL, so you can use it to generate keys:

```
openssl ecparam -name secp256k1 -genkey -out privateKey.pem
openssl ec -in privateKey.pem -pubout -out publicKey.pem
```

Create a message.txt file and sign it:

```
openssl dgst -sha256 -sign privateKey.pem -out signatureDer.txt message.txt
```

It's time to verify:

```php

$publicKeyPem = EllipticCurve\Utils\File::read("publicKey.pem");
$signatureDer = EllipticCurve\Utils\File::read("signatureDer.txt");
$message = EllipticCurve\Utils\File::read("message.txt");

$publicKey = EllipticCurve\PublicKey::fromPem($publicKeyPem);
$signature = EllipticCurve\Signature::fromDer($signatureDer);

echo "\n" . EllipticCurve\Ecdsa::verify($message, $signature, $publicKey);

```

You can also verify it on terminal:

```
openssl dgst -sha256 -verify publicKey.pem -signature signatureDer.txt message.txt
```

NOTE: If you want to create a Digital Signature to use in the [Stark Bank], you need to convert the binary signature to base64.

```
openssl base64 -in signatureDer.txt -out signatureBase64.txt
```

You can also verify it with this library:

```php
$signatureDer = EllipticCurve\Utils\File::read("signatureDer.txt");

$signature = EllipticCurve\Signature::fromDer($signatureDer);

echo "\n" . $signature->toBase64();
```

[Stark Bank]: https://starkbank.com

### Run all unit tests

```sh
php tests/test.php
```

[python-ecdsa]: https://github.com/warner/python-ecdsa
