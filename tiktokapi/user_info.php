<?php
	require_once 'defines.php'; // USER_ACCESS_TOKEN
	require_once 'vendor/autoload.php'; // composer
	//require_once 'tiktok-api-php-sdk/src/TikTok/autoload.php'; // not composer

	use TikTok\User\User;
	use TikTok\Request\Params;

	$config = array( // instantiation config params
	    'access_token' => USER_ACCESS_TOKEN
	);

	// instantiate the user
	$user = new User( $config );

	$params = Params::getFieldsParam( // params keys the field array and implodes array to string on comma
	    array( // user fields to request
	        'open_id', 			// scope user.info.basic
			'union_id', 		// scope user.info.basic
			'avatar_url', 		// scope user.info.basic
			'avatar_url_100',   // scope user.info.basic
			'avatar_large_url', // scope user.info.basic
			'display_name', 	// scope user.info.basic
			'bio_description', 	// scope user.info.profile
			'profile_deep_link',// scope user.info.profile
			'is_verified', 		// scope user.info.profile
			'follower_count', 	// scope user.info.stats
			'following_count', 	// scope user.info.stats
			'likes_count', 		// scope user.info.stats
			'video_count' 		// scope user.info.stats
	    )
	);

	// get user info
	$userInfo = $user->getSelf( $params );
?>
<html>
	<head>
		<title>
			Bubbles | TikTok API Get User Info
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

			textarea {
				width: 100%;
				padding: 10px;
				box-sizing: border-box;
				border: 1px solid #dedede;
				border-radius: 5px;
				height: 300px;
			}

			.main-container {
				max-width: 400px;
				background: #fff;
				padding: 20px;
				border-radius: 5px;
				box-shadow: 0 2px 4px rgba( 0, 0, 0, .1 ), 0 8px 16px rgba( 0, 0, 0, .1 );
				font-weight: bold;
				font-size: 30px;
				text-align: center;
				margin: 0 auto;
				box-sizing: border-box;
			}

			.app-icon {
				border-radius: 50px;
				height: 50px;
				width: 50px;
			}

			.sub-text {
				text-align: center;
				font-size: 12px;
				font-weight: normal;
				margin-top: 20px;
				margin-bottom: 20px;
			}

			.tiktok-button {
				margin-top: 20px;
				padding: 20px;
				background: #eb4863;
				color: #fff;
				border-radius: 5px;
				font-size: 18px;
				cursor: pointer;
				text-align: center;
			}

			.tiktok-button:hover {
				background: #E61A3C;
			}

			.tiktok-button:active {
				box-shadow: inset 0 0 20px #ffffff;
			}

			.divider {
				border-bottom: 1px solid #e3e3e3;
				margin-top: 20px;
				margin-bottom: 20px;
			}

			.top-container {
				text-align: center;
			}

			.user-display-name {
				font-weight: bold;
				font-size: 20px;
				margin-top: 10px;
			}

			.user-description {
				text-align: center;
				font-size: 14px;
				font-weight: normal;
				margin-top: 20px;
				margin-bottom: 20px;
			}

			.user-stats-container {
				display: flex;
				gap: 10px;
				margin-bottom: 10px;
			}

			.user-stats-col {
				flex: 1;
			}

			.user-stat-num {
				font-size: 24px;
				font-weight: bold;
				text-align: left;
			}

			.user-stat-title {
				font-size: 14px;
				text-align: left;
				font-weight: normal;
			}

			@media only screen and ( max-width: 1000px ) { /* mobile: do things when size is 1200px or less */
				.main-container {
					width: 100%;
				}
			}
		</style>
	</head>
	<body>
		<div class="main-container">
			<img class="app-icon" src="assets/app_icon.png" />
			<div>
				Get User Info With Access Token
			</div>
			<div class="sub-text">
				This is a site aimed at helping you learn how to easily integrate and use the TikTok API. Check out the <a href="https://www.youtube.com/watch?v=sdA4eCq21y8&list=PL0glhsZ01I-BWvKCRnZtkG4bBoOB3LivT" target="_blank">YouTube TikTok API PHP SDK Playlist</a> to learn more! You can also find the code and wiki on <a href="https://github.com/jstolpe/tiktok-api-php-sdk" target="_blank">Github</a>.
			</div>
			<?php if ( isset( $userInfo['data']['user'] ) ) : ?>
				<div class="divider">

				</div>
				<div>
					<div class="top-container">
						<img class="app-icon" src="<?php echo $userInfo['data']['user']['avatar_url']; ?>"/>
						<div class="user-display-name">
							<?php echo $userInfo['data']['user']['display_name']; ?>
						</div>
					</div>
					<div class="user-description">
						<?php echo $userInfo['data']['user']['bio_description']; ?>
					</div>
					<div class="user-stats-container">
						<div class="user-stats-col">
							<div class="user-stat-num">
								<?php echo $userInfo['data']['user']['follower_count']; ?>
							</div>
							<div class="user-stat-title">
								Followers
							</div>
						</div>
						<div class="user-stats-col">
							<div class="user-stat-num">
								<?php echo $userInfo['data']['user']['following_count']; ?>
							</div>
							<div class="user-stat-title">
								Following
							</div>
						</div>
						<div class="user-stats-col">
							<div class="user-stat-num">
								<?php echo number_format( $userInfo['data']['user']['likes_count'] ); ?>
							</div>
							<div class="user-stat-title">
								Likes
							</div>
						</div>
					</div>
					<a href="<?php echo $userInfo['data']['user']['profile_deep_link']; ?>" target="_blank">
						<div class="tiktok-button">
							Justin Stolpe
						</div>
					</a>
					<div class="divider">

					</div>
				</div>
			<?php endif; ?>
			<div>
				<?php echo isset( $userInfo['data']['user'] ) ? 'User Info Found!' : 'No User Info Found'; ?>
			</div>
		</div>
	</body>
</html>