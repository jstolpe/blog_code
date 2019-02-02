<?php
	// include config and twitter api wrappe
	require_once( 'config.php' );
	require_once( 'TwitterAPIExchange.php' );

	// settings for twitter api connection
	$settings = array(
		'oauth_access_token' => TWITTER_ACCESS_TOKEN, 
		'oauth_access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET, 
		'consumer_key' => TWITTER_CONSUMER_KEY, 
		'consumer_secret' => TWITTER_CONSUMER_SECRET
	);

	// twitter api endpoint
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	
	// twitter api endpoint request type
	$requestMethod = 'GET';

	// twitter api endpoint data
	$getfield = '?screen_name=justin_stolpe&count=1';

	// make our api call to twiiter
	$twitter = new TwitterAPIExchange( $settings );
	$twitter->setGetfield( $getfield );
	$twitter->buildOauth( $url, $requestMethod );
	$response = $twitter->performRequest( true, array( CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0 ) );
	$tweets = json_decode( $response, true );
    
    // display all info we got back from twitter
    //echo '<pre>';
    //print_r( $tweets );
?>
<h1>Latest Tweet</h1>
<?php foreach ( $tweets as $tweet ) : ?>
	<img src="<?php echo $tweet['user']['profile_image_url']; ?>" />
	<a href="https://twitter.com/<?php echo $tweet['user']['screen_name']; ?>" target="_blank">
		<b>@<?php echo $tweet['user']['screen_name']; ?></b>
	</a> tweeted:
	<br />
	<br />
	<?php echo $tweet['text']; ?>
	<br />
	<br />
	Tweeted on <?php echo $tweet['created_at']; ?>
	<br />
	<hr />
<?php endforeach; ?>