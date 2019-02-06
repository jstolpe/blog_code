# Twitter Login API for PHP (v5)
[![Build Status](https://img.shields.io/travis/abraham/twitteroauth.svg)](https://travis-ci.org/abraham/twitteroauth) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/abraham/twitteroauth/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/abraham/twitteroauth/?branch=master) [![Issues Count](https://img.shields.io/github/issues/abraham/twitteroauth.svg)](https://github.com/abraham/twitteroauth/issues) [![Latest Version](https://img.shields.io/packagist/v/abraham/twitteroauth.svg)](https://packagist.org/packages/abraham/twitteroauth)
------------

This repository contains the open source PHP Login API that allows you to access the Twitter Platform from your PHP Website / App.<br><br>
This small project helps web developers to implement the user registration with Twitter using PHP at their website. Also the user information would be stored in an array as shown in the images below.
<br/><br/><br/>
![Screenshot of Twitter Basic Data Flow](https://cloud.githubusercontent.com/assets/15896579/24586137/a83241d6-17b7-11e7-9604-f78c1f042ad0.JPG?raw=true "Screenshot of Twitter Basic Data Flow")
<br/><br/><br/>



## Twitter Apps Creation

To access Twitter API you need to create Twitter App and specify Consumer Key (API Key) & Consumer Secret(API Secret) at the time of call Twitter API. Follow the step-by-step guide to creating and configure a Twitter App from the App Dashboard.

Log in with your Twitter account and go to the [Twitter App Dashboard](https://apps.twitter.com/app/new).
Create a new Twitter apps with your desired name (like Amir).
If you want to test Twitter login at the localhost server, then your App Domains should be localhost. Also, localhost domain will only work, once you add platform. For add a platform click on Settings link from the left side menu panel » Click on the Add Platform button » Choose Website category » Enter site URL.
Once you completed the above steps, your apps settings page would something like the below.<br>

Note: For getting email twitter provides double security or masking layer, so go to twitter dashboard under Permissions tab check receive email address and save. It may take max 24 hour time to approve.  



## Installation

1. Clone the Repository.<br>
2. Open the index.php file and enter the CONSUMER_KEY,CONSUMER_SECRET and OAUTH_CALLBACK from your newly created APP ID as shown in the snippet below. Note OAUTH_CALLBACK or Redirect Url is the Url where your want to reload page after successfully getting data from twitter database(i.e. index.php page).<br>

3. Keep all the files as it is we have to make changes in index.php and callback.php<br>
4.Once you get data in array your can easily get data from individual index of array and send to database as per your requirement<br><br>
5.Browse the index.php file in the browser and test the Login with Twitter functionality.<br>

## Snippet

```<?php

session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'J6...................tLV'); 	// add your app consumer key between single quotes
define('CONSUMER_SECRET', 'YDK..................................xti'); // add your app consumer 																			secret key between single quotes
define('OAUTH_CALLBACK', 'http://apitest.chasingpapers.com/callback.php'); // your app callback URL i.e. page 																			you want to load after successful 																			  getting the data
//define('oauth_token', '842987337353052160-LL8z2AHxYRP7lHo8iDaq8cLNzeSu8OP');
//define('oauth_token_secret', '6eZZno5qC6d8E5Gtc9jakmhEgvP07F3MfxOBwJ5ysLm8x');
if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	//echo $url;
	echo "<a href='$url'><img src='twitter-login-blue.png' style='margin-left:4%; margin-top: 4%'></a>";
} else {
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
//    $user1 = $connection->get("https://api.twitter.com/1.1/account/verify_credentials.json", ['include_email' => true]);
    echo "<img src='$user->profile_image_url'>";echo "<br>";		//profile image twitter link
    echo $user->name;echo "<br>";									//Full Name
    echo $user->location;echo "<br>";								//location
    echo $user->screen_name;echo "<br>";							//username
    echo $user->created_at;echo "<br>";
//    echo $user->profile_image_url;echo "<br>";
    echo $user->email;echo "<br>";									//Email, note you need to check permission on Twitter App Dashboard and it will take max 24 hours to use email 
    echo "<pre>";
    print_r($user);
    echo "<pre>";								//These are the sets of data you will be getting from Twitter 												Database 
}
```

## Tricks
In the Twitter App Dashboard: <br>1. Site Url / Mobile Site Url is the page where tw login button exists and <br/>2. OAuth redirect URIs / Callback URI's is the page you want to get into after successful login(i.e. Website Home Login page => index.php) and this should be same as redirect url/ callback uri in index.php.php code

## Preview

![Screenshot of Twitter Project Page 1](https://cloud.githubusercontent.com/assets/15896579/24586138/ab48b760-17b7-11e7-97ff-223b308a879a.png?raw=true "Screenshot of Twitter Project Page 1")
<br/><br/><br/>

![Screenshot of Twitter Project Page 2](https://cloud.githubusercontent.com/assets/15896579/24586140/b0c59c3a-17b7-11e7-84bf-cbb16c300d30.png?raw=true "Screenshot of Twitter Project Page 2")
<br/><br/><br/>

![Screenshot of Twitter Project Page 3](https://cloud.githubusercontent.com/assets/15896579/24586141/b4077bfc-17b7-11e7-885e-5502706c99e7.png?raw=true "Screenshot of Twitter Project Page 3")
<br/><br/><br/>

![Screenshot of Twitter Project Page 4](https://cloud.githubusercontent.com/assets/15896579/24586142/b6c1e3a0-17b7-11e7-85a0-613ef606fb24.png?raw=true "Screenshot of Twitter Project Page 4")
<br/><br/><br/>

![Screenshot of Twitter Project Page 5](https://cloud.githubusercontent.com/assets/15896579/24586143/b9445586-17b7-11e7-931f-b363888b5a79.png?raw=true "Screenshot of Twitter Project Page 5")
<br/><br/><br/>
![Screenshot of Twitter APP Dashboard Page 1](https://cloud.githubusercontent.com/assets/15896579/24586147/be95cf42-17b7-11e7-8c3b-2fb4481226f5.png?raw=true "Screenshot of Twitter APP Dashboard Page 1")
<br/><br/><br/>

![Screenshot of Twitter APP Dashboardt Page 2](https://cloud.githubusercontent.com/assets/15896579/24586150/c1cf3b58-17b7-11e7-868c-ccf1777bce71.png?raw=true "Screenshot of Twitter APP Dashboard Page 2")
<br/><br/><br/>

![Screenshot of Twitter APP Dashboard Page 3](https://cloud.githubusercontent.com/assets/15896579/24586152/c5110044-17b7-11e7-8645-7cf58341668c.png?raw=true "Screenshot of Twitter APP Dashboard Page 3")
<br/><br/><br/>

![Screenshot of Twitter APP Dashboard Page 4](https://cloud.githubusercontent.com/assets/15896579/24586154/c9084298-17b7-11e7-8026-bb802b5cc910.png?raw=true "Screenshot of Twitter APP Dashboard Page 4")
<br/><br/><br/>

![Screenshot of Twitter APP Dashboard Page 5](https://cloud.githubusercontent.com/assets/15896579/24586155/cd8233c4-17b7-11e7-9b2c-7670b2fb12b5.png?raw=true "Screenshot of Twitter APP Dashboard Page 5")
<br/><br/><br/>

![Screenshot of Twitter APP Dashboard Page 6](https://cloud.githubusercontent.com/assets/15896579/24586158/d132385c-17b7-11e7-8335-e941c91eebc8.png?raw=true "Screenshot of Twitter APP Dashboard Page 6")




<br/><br/><br/>



## License

(The MIT License)

Copyright (c) 2016 Amir Mustafa

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.






