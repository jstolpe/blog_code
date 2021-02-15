![SendGrid Logo](twilio_sendgrid_logo.png)

[![Travis Badge](https://travis-ci.com/sendgrid/php-http-client.svg?branch=main)](https://travis-ci.com/sendgrid/php-http-client)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sendgrid/php-http-client.svg?style=flat-square)](https://packagist.org/packages/sendgrid/php-http-client)
[![Email Notifications Badge](https://dx.sendgrid.com/badge/php)](https://dx.sendgrid.com/newsletter/php)
[![Twitter Follow](https://img.shields.io/twitter/follow/sendgrid.svg?style=social&label=Follow)](https://twitter.com/sendgrid)
[![GitHub contributors](https://img.shields.io/github/contributors/sendgrid/php-http-client.svg)](https://github.com/sendgrid/php-http-client/graphs/contributors)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

**Quickly and easily access any RESTful or RESTful-like API.**

If you are looking for the SendGrid API client library, please see [this repo](https://github.com/sendgrid/sendgrid-php).

# Announcements
**The default branch name for this repository has been changed to `main` as of 07/27/2020.**

All updates to this library are documented in our [CHANGELOG](CHANGELOG.md).

# Table of Contents
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [How to Contribute](#contribute)
- [Thanks](#thanks)
- [About](#about)
- [License](#license)

<a name="installation"></a>
# Installation

## Prerequisites

- PHP version 5.6, 7.0, 7.1, 7.2, 7.3, or 7.4

## Install with Composer

Add php-http-client to your `composer.json` file. If you are not using [Composer](http://getcomposer.org), you should be. It's an excellent way to manage dependencies in your PHP application.

```json
{
  "require": {
    "sendgrid/php-http-client": "^3.13.0"
  }
}
```

Then at the top of your PHP script require the autoloader:

```php
require __DIR__ . '/vendor/autoload.php';
```

Then from the command line:

```bash
composer install
```

## Install without Composer

You should create a `lib` directory in the directory of your application and clone to `lib` repositories [php-http-client](https://github.com/sendgrid/php-http-client.git) and [sendgrid-php](https://github.com/sendgrid/sendgrid-php.git):

```
$ cd /path/to/your/app
$ mkdir lib
$ cd lib
$ git clone https://github.com/sendgrid/php-http-client.git
```

In the next step you should create `loader.php`:

```
$ cd /path/to/your/app
$ touch loader.php
```

And add the code below to the `loader.php`:

```php
<?php

require_once __DIR__ . '/lib/php-http-client/lib/Client.php';
require_once __DIR__ . '/lib/php-http-client/lib/Response.php';
```

After it you can use the `php-http-client` library in your project:

```php
<?php

include __DIR__ . '/loader.php';

$client = new SendGrid\Client();
```

<a name="quick-start"></a>
# Quick Start

Here is a quick example:

`GET /your/api/{param}/call`

```php
// include __DIR__ . '/loader.php';
require 'vendor/autoload.php';
$apiKey = YOUR_SENDGRID_API_KEY;
$authHeaders = [
    'Authorization: Bearer ' . $apiKey
];
$client = new SendGrid\Client('https://api.sendgrid.com', $authHeaders);
$param = 'foo';
$response = $client->your()->api()->_($param)->call()->get();

var_dump(
    $response->statusCode(),
    $response->headers(),
    $response->body()
);
```

`POST /your/api/{param}/call` with headers, query parameters and a request body with versioning.

```php
// include __DIR__ . '/loader.php';
require 'vendor/autoload.php';
$apiKey = YOUR_SENDGRID_API_KEY;
$authHeaders = [
    'Authorization: Bearer ' . $apiKey
];
$client = new SendGrid\Client('https://api.sendgrid.com', $authHeaders);
$queryParams = [
    'hello' => 0, 'world' => 1
];
$requestHeaders = [
    'X-Test' => 'test'
];
$data = [
    'some' => 1, 'awesome' => 2, 'data' => 3
];
$param = 'bar';
$response = $client->your()->api()->_($param)->call()->post($data, $queryParams, $requestHeaders);

var_dump(
    $response->statusCode(),
    $response->headers(),
    $response->body()
);
```

If there is an issues with the request, such as misconfigured CURL SSL options, an `InvalidRequest` will be thrown
with message from CURL on why the request failed. Use the message as a hit to troubleshooting steps of your environment.

<a name="usage"></a>
# Usage

- [Usage Examples](USAGE.md)

## Environment Variables

You can do the following to create a .env file:

```cp .env_example .env```

Then, just add your API Key into your .env file.

<a name="contribute"></a>
# How to Contribute

We encourage contribution to our libraries, please see our [CONTRIBUTING](CONTRIBUTING.md) guide for details.

Quick links:

- [Feature Request](CONTRIBUTING.md#feature-request)
- [Bug Reports](CONTRIBUTING.md#submit-a-bug-report)
- [Improvements to the Codebase](CONTRIBUTING.md#improvements-to-the-codebase)
- [Review Pull Requests](CONTRIBUTING.md#code-reviews)

<a name="thanks"></a>
# Thanks

We were inspired by the work done on [birdy](https://github.com/inueni/birdy) and [universalclient](https://github.com/dgreisen/universalclient).

<a name="about"></a>
# About

php-http-client is maintained and funded by Twilio SendGrid, Inc. The names and logos for php-http-client are trademarks of Twilio SendGrid, Inc.

If you need help installing or using the library, please check the [Twilio SendGrid Support Help Center](https://support.sendgrid.com).

If you've instead found a bug in the library or would like new features added, go ahead and open issues or pull requests against this repo!

<a name="license"></a>
# License
[The MIT License (MIT)](LICENSE)
