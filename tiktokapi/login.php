<?php
	require_once 'defines.php';
	require_once 'vendor/autoload.php'; // composer
	//require_once 'tiktok-api-php-sdk/src/TikTok/autoload.php'; // not composer

	use TikTok\Authentication\Authentication;

	// get authorization code
	$authorizationCode = isset( $_GET['code'] ) ? $_GET['code'] : '';

	$authentication = new Authentication( array( // instantiate authentication
		'client_key' => CLIENT_KEY,
		'client_secret' => CLIENT_SECRET
	) );

	if ( $authorizationCode ) { // try and get access token from code
		// get access token from code
		$userToken = $authentication->getAccessTokenFromCode( $authorizationCode, REDIRECT_URI );
	}
?>
<html>
	<head>
		<title>
			Bubbles | Rubber Duck Videos
		</title>

		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

		<link rel="shortcut icon" href="assets/favicon.ico" />

		<style>
			body {
				font-family: 'Courier New';
				background: #f0f2f5;
			}

			a {
				text-decoration: none;
			}

			input {
				width: 100%;
				padding: 10px;
				box-sizing: border-box;
				border: 1px solid #dedede;
				border-radius: 5px;
			}

			textarea {
				width: 100%;
				padding: 10px;
				box-sizing: border-box;
				border: 1px solid #dedede;
				border-radius: 5px;
				height: 300px;
			}

			.login-container {
				max-width: 400px;
				background: #fff;
				padding: 20px;
				border-radius: 5px;
				box-shadow: 0 2px 4px rgba( 0, 0, 0, .1 ), 0 8px 16px rgba( 0, 0, 0, .1 );
				font-weight: bold;
				font-size: 30px;
				text-align: center;
				margin: 0 auto;
				margin-top: 10px;
			}

			.app-icon {
				height: 50px;
			}

			.sub-text {
				text-align: center;
				font-size: 12px;
				font-weight: normal;
				margin-top: 20px;
				margin-bottom: 20px
			}

			@media only screen and ( max-width: 1000px ) { /* mobile: do things when size is 1200px or less */
				.login-container {
					transform: none;
					position: unset;
				}
			}
		</style>
	</head>
	<body>
		<div class="login-container">
			<img class="app-icon" src="assets/app_icon.png" />
			<div>
				Bubbles Log In
			</div>
			<div class="sub-text">
				This is a site aimed at helping you learn how to easily integrate and use the TikTok API. Check out the <a href="https://www.youtube.com/watch?v=sdA4eCq21y8&list=PL0glhsZ01I-BWvKCRnZtkG4bBoOB3LivT" target="_blank">YouTube TikTok API PHP SDK Playlist</a> to learn more! You can also find the code and wiki on <a href="https://github.com/jstolpe/tiktok-api-php-sdk" target="_blank">Github</a>.
			</div>
			<div>
				Code From TikTok
			</div>
			<div>
				<input type="text" value="<?php echo isset( $_GET['code'] ) ? $_GET['code'] : ''; ?>" placeholder="code from TikTok to exchange for access token" />
			</div>
			<?php if ( $authorizationCode ) : ?>
				<div class="sub-text">
					Exchangin code for access token...
				</div>
				<div>
					User Access Token Response
				</div>
				<div class="sub-text">
					<?php echo !empty( $userToken['error'] ) ? $userToken['error_description'] : 'Access Token Found.'; ?>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>