<?php
	// include config so we have access to our creds
	include( 'config.php' );

	// hit the users/self endpoint with our valid access token to get info on our user
	$ch = curl_init( 'https://api.instagram.com/v1/users/self/?access_token=' . IG_ACCESS_TOKEN );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	$response_raw = curl_exec( $ch );
	$response = json_decode( $response_raw, true );
	curl_close( $ch );

	if ( isset( $_GET['debug'] ) ) { // if this is set display raw IG response in browser
		echo '<pre>';
		print_r( $response );
		echo '</pre>';
	}
?>
<!-- display users info via html -->
<img src="<?php echo $response['data']['profile_picture']; ?>" />
<br />
<b>User Name: <?php echo $response['data']['username']; ?></b>
<br />
<b>Posts: <?php echo $response['data']['counts']['media']; ?></b>
<br />
<b>Followers: <?php echo $response['data']['counts']['followed_by']; ?></b>
<br />
<b>Following: <?php echo $response['data']['counts']['follows']; ?></b>
<br />