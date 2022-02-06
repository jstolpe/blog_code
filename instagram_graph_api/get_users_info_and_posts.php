<?php
	include 'defines.php';

	// instagram endpoint structure
	$endpointFormat = 'https://graph.facebook.com/v12.0/{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{id,caption,like_count,comments_count,timestamp,username,media_product_type,media_type,owner,permalink,media_url,children{media_url}}}&access_token={access-token}';

	// instagram endpoint with actuall account id
	$endpoint =  'https://graph.facebook.com/v12.0/' . $instagramAccountId;

	// user to get
	$users = array();

	// get user info and posts
	$users[] = getUserInfoAndPosts( 'programmer.me', $endpoint, $accessToken );
	$users[] = getUserInfoAndPosts( 'justinstolpe', $endpoint, $accessToken );

	function getUserInfoAndPosts( $username, $endpoint, $accessToken ) {
		// endpoint params
		$igParams = array(
			'fields' => 'business_discovery.username(' . $username . '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{id,caption,like_count,comments_count,timestamp,username,media_product_type,media_type,owner,permalink,media_url,children{media_url}}}',
			'access_token' => $accessToken
		);

		// add params to endpoint
		$endpoint .= '?' . http_build_query( $igParams );

		// setup curl
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $endpoint );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		// make call and get response
		$response = curl_exec( $ch );

		// close curl call
		curl_close( $ch );

		// return nice array
		return json_decode( $response, true );
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Getting a Users Instagram Info and Posts
		</title>
		<meta charset="utf-8" />
		<style>
			body {
				font-family: 'Helvetica';
			}

			.pages-list {
				display: block;
			}

			.pages-list-item {
				display: inline-block;
				vertical-align: top;
				margin-top: 10px;
				width: 250px;
				border: 1px solid #333;
				margin-left: 10px;
				padding: 10px;
				font-size: 9px;
			}

			.pages-media {
				width: 100%;
			}

			.raw-response {
				width: 100%;
				height: 600px;
			}

			.nav-container {
				margin-top: 20px;
				font-size: 20px;
				display: inline-block;
				width: 100%;
			}

			.nav-next {
				float: right;
			}

			.profile-container {
				display: inline-block;
				width: 100%;
			}

			.profile-image-container {
				float: left;
			}

			.profile-image-container img {
				width: 50px;
				border-radius: 50%;
			}

			.child-media {
				width: 70px;
			}

			textarea {
				width: 100%;
				height: 500px;
			}
		</style>
	</head>
	<body>
		<h1>Getting a Users Instagram Info and Posts</h1>
		<hr />
		<h3>Endpoint: <?php echo $endpointFormat; ?></h3>
		<hr />
		<br />
		<?php foreach ( $users as $userInfo ) : ?>
			<div class="profile-container">
				<div class="profile-image-container">
					<img src="<?php echo $userInfo['business_discovery']['profile_picture_url']; ?>" />
				</div>
				<div style="float:left;margin-left:20px">
					<a target="_blank" href="https://www.instagram.com/<?php echo $userInfo['business_discovery']['username']; ?>">
						<h3><?php echo $userInfo['business_discovery']['username']; ?></h3>
					</a>
					<div style="display:inline-block">
						<b><?php echo $userInfo['business_discovery']['media_count']; ?></b> posts
					</div>
					<div style="display:inline-block;margin-left:20px">
						<b><?php echo $userInfo['business_discovery']['followers_count']; ?></b> followers
					</div>
					<div style="display:inline-block;margin-left:20px">
						<b><?php echo $userInfo['business_discovery']['follows_count']; ?></b> following
					</div>
				</div>
			</div>
			<div>
				<h4><?php echo $userInfo['business_discovery']['name']; ?></h4>
				<div>
					<?php echo nl2br( $userInfo['business_discovery']['biography'] ); ?>
				</div>
				<div>
					<a target="_blank" href="<?php echo $userInfo['business_discovery']['website']; ?>">
						<h3><?php echo $userInfo['business_discovery']['website']; ?></h3>
					</a>
				</div>
			</div>
			<ul class="pages-list">
				<?php foreach ( $userInfo['business_discovery']['media']['data'] as $media ) : ?>
					<li class="pages-list-item">
						<?php if ( 'IMAGE' == $media['media_type'] || 'CAROUSEL_ALBUM' == $media['media_type']) : ?>
							<img class="pages-media" src="<?php echo $media['media_url']; ?>" />
						<?php else : ?>
							<video class="pages-media" controls>
								<source src="<?php echo $media['media_url']; ?>">
							</video>
						<?php endif; ?>
						<div>
							Likes: <?php echo $media['like_count']; ?>
						</div>
						<div>
							Comments: <?php echo $media['comments_count']; ?>
						</div>
						<h4>
							<?php echo nl2br( $media['caption'] ); ?>
						</h4>
						<div>
							Link to Post: 
							<br />
							<a target="_blank" href="<?php echo $media['permalink']; ?>" />
								<?php echo $media['permalink']; ?>
							</a>
						</div>
						<br />
						Media Type: <?php echo $media['media_type']; ?>
						<?php if ( 'CAROUSEL_ALBUM' == $media['media_type'] ) : ?>
							<div>
								<?php foreach ( $media['children']['data'] as $child ) : ?>
									<img class="child-media" src="<?php echo $child['media_url']; ?>" />
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<br />
						<div>
							Posted at: <?php echo $media['timestamp']; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<br />
			<h3>Raw Response for <?php echo $userInfo['business_discovery']['username']; ?></h3>
			<textarea><?php print_r( $userInfo ); ?></textarea>
			<br />
			<hr />
			<br />
		<?php endforeach; ?>
	</body>
</html>