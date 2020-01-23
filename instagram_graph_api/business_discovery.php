<?php
	include 'defines.php';

	// get instagram user metadata endpoint
	$endpointFormat = ENDPOINT_BASE . '{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}&access_token={access-token}';
	$endpoint = ENDPOINT_BASE . $instagramAccountId;

	// username
	$username = 'IG-USER-NAME';

	// endpoint params
	$igParams = array(
		'fields' => 'business_discovery.username(' . $username . '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}',
		'access_token' => $accessToken
	);

	// add params to endpoint
	$endpoint .= '?' . http_build_query( $igParams );

	// setup curl
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $endpoint );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	// make call and get response
	$response = curl_exec( $ch );
	curl_close( $ch );
	$responseArray = json_decode( $response, true );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Getting an Instagram Users Metadata</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>Getting an Instagram Users Metadata</h1>
		<hr />
		<br />
		<div style="display:inline-block;width:100%">
			<div style="float:left">
				<img style="width:50px;border-radius:50%;" src="<?php echo $responseArray['business_discovery']['profile_picture_url']; ?>" />
			</div>
			<div style="float:left;margin-left:20px">
				<a target="_blank" href="https://www.instagram.com/<?php echo $responseArray['business_discovery']['username']; ?>">
					<h3><?php echo $responseArray['business_discovery']['username']; ?></h3>
				</a>
				<div style="display:inline-block">
					<b><?php echo $responseArray['business_discovery']['media_count']; ?></b> posts
				</div>
				<div style="display:inline-block;margin-left:20px">
					<b><?php echo $responseArray['business_discovery']['followers_count']; ?></b> followers
				</div>
				<div style="display:inline-block;margin-left:20px">
					<b><?php echo $responseArray['business_discovery']['follows_count']; ?></b> following
				</div>
			</div>
		</div>
		<div>
			<h4><?php echo $responseArray['business_discovery']['name']; ?></h4>
			<div>
				<?php echo nl2br( $responseArray['business_discovery']['biography'] ); ?>
			</div>
			<div>
				<a target="_blank" href="<?php echo $responseArray['business_discovery']['website']; ?>">
					<h3><?php echo $responseArray['business_discovery']['website']; ?></h3>
				</a>
			</div>
		</div>
		<br />
		<hr />
		<h3>Endpoint: <?php echo $endpointFormat; ?></h3>
		<hr />
		<h3>Raw Response</h3>
		<textarea style="width:100%;height:300px;"><?php print_r( $responseArray ); ?></textarea>
	</body>
</html>