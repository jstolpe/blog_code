<?php
	include 'defines.php';

	// get pages endpoint
	$endpointFormat = ENDPOINT_BASE . 'me/accounts?access_token={access-token}';
	$pagesEndpoint = ENDPOINT_BASE . 'me/accounts';

	// endpoint params
	$pagesParams = array(
		'access_token' => $accessToken
	);

	// add params to endpoint
	$pagesEndpoint .= '?' . http_build_query( $pagesParams );

	// setup curl
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $pagesEndpoint );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	// make call and get response
	$response = curl_exec( $ch );
	curl_close( $ch );
	$responseArray = json_decode( $response, true );
	unset( $responseArray['data'][0]['access_token'] );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Get User's Pages</title>
	</head>
	<body>
		<h1>Get User's Pages</h1>
		<hr />
		<h3>Endpoint: <?php echo $endpointFormat; ?></h3>
		<hr />
		<h3>Display:</h3>
		<h4>Facebook Page: <?php echo $responseArray['data'][0]['name']; ?></h4>
		<h4>Facebook Page ID: <?php echo $responseArray['data'][0]['id']; ?></h4>
		<hr />
		<h3>Raw Response</h3>
		<textarea style="width:100%;height:600px;"><?php print_r( $responseArray ); ?></textarea>
	</body>
</html>