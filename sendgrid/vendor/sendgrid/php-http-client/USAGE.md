# Usage

Usage examples for SendGrid php-http-client

## Initialization

```
// If running this outside of this context, use the following include and
// comment out the two includes below
// require __DIR__ . '/vendor/autoload.php';
include(dirname(__DIR__) . '/lib/Client.php');
// This gets the parent directory, for your current directory use getcwd()
$path_to_config = dirname(__DIR__);
$apiKey = getenv('SENDGRID_API_KEY');
$headers = ['Authorization: Bearer ' . $apiKey];
$client = new SendGrid\Client('https://api.sendgrid.com', $headers, '/v3');
```

## Table of Contents

- [GET](#get)
- [DELETE](#delete)
- [POST](#post)
- [PUT](#put)
- [PATCH](#patch)

<a name="get"></a>
## GET

#### GET Collection

```
$query_params = ['limit' => 100, 'offset' => 0];
$request_headers = ['X-Mock: 200'];
$response = $client->api_keys()->get(null, $query_params, $request_headers);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```

#### GET with auto retry on rate limit

```
$query_params = ['limit' => 100, 'offset' => 0];
$request_headers = ['X-Mock: 200'];
$retryOnLimit = true;
$response = $client->api_keys()->get(null, $query_params, $request_headers, $retryOnLimit);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```

<a name="delete"></a>
## DELETE

```
$response = $client->api_keys()->_($api_key_id)->delete();
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```

<a name="post"></a>
## POST

```
$request_body = [
    'name' => 'My PHP API Key',
    'scopes' => [
        'mail.send',
        'alerts.create',
        'alerts.read'
    ]
];
$response = $client->api_keys()->post($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
$response_body = json_decode($response->body());
$api_key_id = $response_body->api_key_id;
```
<a name="put"></a>
## PUT

```
$request_body = [
    'name' => 'A New Hope',
    'scopes' => [
        'user.profile.read',
        'user.profile.update'
    ]
];
$response = $client->api_keys()->_($api_key_id)->put($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```
<a name="patch"></a>
## PATCH

```
$request_body = [
    'name' => 'A New Hope'
];
$response = $client->api_keys()->_($api_key_id)->patch($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
```
