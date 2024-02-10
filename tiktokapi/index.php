<?php
	require_once 'defines.php';
	require_once 'vendor/autoload.php'; // composer
	//require_once 'tiktok-api-php-sdk/src/TikTok/autoload.php'; // not composer

	use TikTok\Authentication\Authentication;

	$authentication = new Authentication( array( // instantiate authentication
	    'client_key' => CLIENT_KEY, // client key from your app
	    'client_secret' => CLIENT_SECRET // client secret from your app
	) );

	// uri TikTok will send the user to after they login that must match what you have in your app dashboard
	$redirectUri = REDIRECT_URI;

	$scopes = array( // a list of approved scopes by tiktok for your app
	    'user.info.basic',
	    'user.info.profile',
	    'user.info.stats',
	    'video.list'
	);

	// get TikTok login url
	$authenticationUrl = $authentication->getAuthenticationUrl( $redirectUri, $scopes );
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

			.login-container {
				max-width: 400px;
				background: #fff;
				padding: 20px;
				border-radius: 5px;
				box-shadow: 0 2px 4px rgba( 0, 0, 0, .1 ), 0 8px 16px rgba( 0, 0, 0, .1 );
				font-weight: bold;
				font-size: 30px;
				text-align: center;
				left: 50%;
				top: 50%;
				transform: translate( -50%, -50% );
				position: fixed;
			}

			.app-icon {
				height: 50px;
			}

			.tiktok-button {
				margin-top: 20px;
				padding: 20px;
				background: #000;
				color: #fff;
				border-radius: 5px;
				font-size: 18px;
				cursor: pointer;
			}

			.tiktok-button:hover {
				background: #181818;
			}

			.tiktok-button:active {
				box-shadow: inset 0 0 20px #ffffff;
			}

			.tiktok-button img {
				height: 15px;
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
			<a href="<?php echo $authenticationUrl; ?>">
				<div class="tiktok-button">
					<img src="assets/tiktok_logo.png" /> Continue with TikTok
				</div>
			</a>
		</div>
	</body>
</html>