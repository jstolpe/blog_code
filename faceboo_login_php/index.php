<?php
	// require our config file and load the php graph sdk
	require 'config.php';
	require_once 'vendor/graph-sdk/autoload.php';

	// start the session
	session_start();

	$appCreds = array( // array to hold app creds from fb app
		'app_id' => MY_FB_APP_ID,
		'app_secret' => MY_FB_APP_SECRET,
		'default_graph_version' => 'v3.2'
	);

	if ( isset( $_SESSION['fb_access_token'] ) && $_SESSION['fb_access_token'] ) { // if we have access token, add it to the app creds
		$appCreds['default_access_token'] = $_SESSION['fb_access_token'];
	}

	if ( isset( $_SESSION['fb_access_token'] ) && $_SESSION['fb_access_token'] ) { // we have an access token, use it to get user info from fb
		$isLoggedIn = true;
	} elseif ( isset( $_GET['code'] ) && !$_SESSION['fb_access_token'] ) { // user is coming from allowing our app
		// create new facebook object and helper for getting access token
		$fb = new \Facebook\Facebook( $appCreds );
		$helper = $fb->getRedirectLoginHelper();

		try { // get access token, save to session, and add to app creds
		 	$accessToken = $helper->getAccessToken();
		  	$_SESSION['fb_access_token'] = (string) $accessToken;
		  	$appCreds['default_access_token'] = $_SESSION['fb_access_token'];
		  	$isLoggedIn = true;
		} catch(Facebook\Exceptions\FacebookResponseException $e) { // When Graph returns an error
		    echo 'Graph returned an error: ' . $e->getMessage();
		    exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) { // When validation fails or other local issues
		    echo 'Facebook SDK returned an error: ' . $e->getMessage();
		    exit;
		}
	} else { // user is no logged in, display the login with facebook link
		// create new facebook object and helper for getting access token
		$fb = new \Facebook\Facebook( $appCreds );
		$helper = $fb->getRedirectLoginHelper();

		// user is not logged in
		$isLoggedIn = false;
	}

	if ( $isLoggedIn ) { // logged in
		// create new facebook object
		$fb = new \Facebook\Facebook( $appCreds );

		// call facebook and ask for name and picture
		$facebookResponse = $fb->get( '/me?fields=first_name,last_name,picture' );
		$facebookUser = $facebookResponse->getGraphUser();

		// Use handler to get access token info
		$oAuth2Client = $fb->getOAuth2Client();
		$accessToken = $oAuth2Client->debugToken( $_SESSION['fb_access_token'] );

		// display everything in the browser
		?>
		<div><b>Logged in as <?php echo $facebookUser['first_name']; ?> <?php echo $facebookUser['last_name']; ?></b></div>
		<div><b>FB User ID: <?php echo $facebookUser['id']; ?></b></div>
		<div><img src="<?php echo $facebookUser['picture']['url']; ?>" /></div>
		<br />
		<br />
		<hr />
		<br />
		<br />
		<b>User Info</b>
		<textarea style="height:200px;width:100%"><?php echo print_r( $facebookUser, true ); ?></textarea>
		<br />
		<br />
		<b>Access Token</b>
		<textarea style="height:200px;width:100%"><?php echo print_r( $accessToken, true ); ?></textarea>
		<br />
		<br />
		<b>Access Token Expires</b>
		<textarea style="height:100px;width:100%"><?php echo print_r( $accessToken->getExpiresAt(), true ); ?></textarea>
		<br />
		<br />
		<b>Access Token Is Valid</b>
		<textarea style="height:50px;width:100%"><?php echo print_r( $accessToken->getIsValid(), true ); ?></textarea>
		<br />
		<br />
		<?php
	} else { // not logged in
		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl( 'https://www.justinstolpe.com/blog_code/facebook_login_php/index.php', $permissions );

		?>
		<a href="<?php echo $loginUrl; ?>">Log in with Facebook</a>
		<?php
	}
?>