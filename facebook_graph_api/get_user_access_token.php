<?php
	// include our defines file
	include 'defines.php';

	// include php functions
	include 'functions.php';

	// allow us to user php session
	session_start();

	if ( isset( $_GET['logout'] ) ) { // log user out
		// clea session
		unset( $_SESSION );

		// refresh page
		header( 'get_user_access_token.php' );
	}

	if ( !isset( $_SESSION['fb_access_token'] ) && isset( $_GET['code'] ) && isset( $_GET['state'] ) && $_GET['state'] == $_SESSION['fb_state'] ) { // we have get vars from facebook
		// get access token and setit in the session
		$accessToken = getAccessTokenWithCode( $_GET['code'] );
		$_SESSION['fb_access_token'] = $accessToken['data'];
	} elseif ( !isset( $_SESSION['fb_access_token'] ) ) {
		// create state for fb
		$_SESSION['fb_state'] = mt_rand( 1, 1000000 );

		// get fb login url
		$fbLoginUrl = getFacebookLoginUrl( 'email,public_profile', $_SESSION['fb_state'] );
	}
?>
<h1>Facebook Graph API Get User Access Token</h1>
<hr />
<h3>$_SESSION</h3>
<pre><?php print_r( $_SESSION ); ?></pre>
<hr />
<?php if ( isset( $fbLoginUrl ) ) : // need to display login with facebook to user ?>
	<a href="<?php echo $fbLoginUrl; ?>">
		Login With Facebook
	</a>
	<br />
	<br />
	href: <?php echo $fbLoginUrl; ?>
<?php else : // user is logged so show logout ?>
	<a href="get_user_access_token.php?logout=1">
		Logout
	</a>
<?php endif; ?>
