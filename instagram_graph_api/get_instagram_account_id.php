<?php
	include 'defines.php';

	// get instagram account id endpoint
	$endpointFormat = ENDPOINT_BASE . '{page-id}?fields=instagram_business_account&access_token={access-token}';
	$instagramAccountEndpoint = ENDPOINT_BASE . $pageId;

	// endpoint params
	$igParams = array(
		'fields' => 'instagram_business_account',
		'access_token' => $accessToken
	);

	// add params to endpoint
	$instagramAccountEndpoint .= '?' . http_build_query( $igParams );

	// setup curl
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $instagramAccountEndpoint );
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
		<title>Get Page's Instagram Business Account</title>
	</head>
	<body>
		<h1>Get Page's Instagram Business Account</h1>
		<hr />
		<h3>Endpoint: <?php echo $endpointFormat; ?></h3>
		<hr />
		<h3>Display:</h3>
		<h4>Instagram Business Account Id: <?php echo $responseArray['instagram_business_account']['id']; ?></h4>
		<h4>Facebook Page ID: <?php echo $responseArray['id']; ?></h4>
		<hr />
		<h3>Raw Response</h3>
		<textarea style="width:100%;height:300px;"><?php print_r( $responseArray ); ?></textarea>
	</body>
</html>