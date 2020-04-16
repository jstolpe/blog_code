<?php
	//include '../defines.php';

	// VERIFICATION STEPS
	//file_put_contents( 'verify.log', print_r( $_GET, true ), FILE_APPEND );
	//echo $_GET['hub_challenge'];
	//die();

	// TESTING OF THE WEBHOOKS
	// $json = file_get_contents( 'php://input' );
	// $data = json_decode( $json );
	// file_put_contents( 'data.log', print_r( $data, true ), FILE_APPEND );
	// //die();

	// $commentId = '17893015459452492';
	// $mediaId = '17908649842399636';

	// $params = array(
	// 	'endpoint_url' => 'https://graph.facebook.com/' . $instagramAccountId . '/mentions',
	// 	'type' => 'POST',
	// 	'url_params' => array(
	// 		'comment_id' => $commentId,
	// 		'media_id' => $mediaId,
	// 		'message' => 'This is an auto reply from a webhook!',
	// 		'access_token' => $accessToken,
	// 	)
	// );

	// $responseInfo = makeApiCall( $params );

	// echo '<pre>';
	// print_r($responseInfo);

	function makeApiCall( $params ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params['url_params'] ) );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		curl_setopt( $ch, CURLOPT_URL, $params['endpoint_url'] );

		// set other curl options
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );

		curl_close( $ch );

		$responseArray = json_decode( $response, true );

		return $responseArray;
	}
?>
<html>
	<head>
		<title>Instagram Graph API Webhooks</title>
	</head>
	<body>
		<h1>Instagram Graph API Webhooks</h1>
	</body>
</html>