If you can't find a solution below, please open an [issue](https://github.com/sendgrid/php-http-client/issues).

## Table of Contents

* [Viewing the Request Body](#request-body)
* [Handling SSL Errors](#ssl-errors)

<a name="request-body"></a>
## Viewing the Request Body

When debugging or testing, it may be useful to examine the raw request body. In the `examples/example.php` file, after your API call, use this code to echo out the status code, body, and headers:

```php
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```

<a name="ssl-errors">
## Handling SSL Errors

If any SSL errors occur during API calls, an `InvalidRequest` will be thrown. This will provide information to help debug the issue further.

If the issue is caused by an unrecognized certificate, it may be possible that PHP is unable to locate your system's CA bundle. An easy fix would be requiring the `composer/ca-bundle` package - this library will automatically detect and use that to locate the CA bundle, or use Mozilla's as a fallback.
