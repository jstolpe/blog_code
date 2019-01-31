<?php
	// include config so we have access to our creds
	include( 'config.php' );

	if ( isset( $_GET['code'] ) ) { // we are being redirected back from IG with a code
		$params = array( // post parmas 
			'client_id' => IG_CLIENT_ID,
			'client_secret' => IG_CLIENT_SECRET,
			'grant_type' => 'authorization_code',
			'redirect_uri' => IG_REDIRECT_URI,
			'code' => $_GET['code']
		);

		// call IG access_token endpoint with params to get a valid access token
		$ch = curl_init( 'https://api.instagram.com/oauth/access_token' );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		$response_raw = curl_exec( $ch );
		$response = json_decode( $response_raw, true );
		curl_close( $ch );

		// display our repsonse from IG
		echo '<pre>';
		print_r( $response );
		echo '</pre>';
	}
?>
<!-- We need to go to IG, authorize user and redirect back to this page for a code -->
<h1>Instagram</h1>
<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo IG_CLIENT_ID; ?>&redirect_uri=<?php echo IG_REDIRECT_URI; ?>&response_type=code">
	GET CODE
</a>
