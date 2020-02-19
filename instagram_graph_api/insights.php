<?php
	include 'defines.php';

	$mediaObject = array( // media post we are working with
		'id' => '17908649842399636',
		'caption' => "Can you spot me in the video?! 😆🤣 Coding tonight against the Instagram Graph API and getting a users metadata!
.
The metadata we can get from the Instagram Graph API for a user includes, profile image url, account I'd, username, website, name, biography, follow count, follower count, media count.
.
#coding #instagram #coder #tech #php #html #fullstackdeveloper #webdevelopment #webstagram #computers #frontenddeveloper #instagramgraphapi #instagramapi #api #backend #website #softwareengineer #code #programming #facebook",
		'media_url' => 'https://scontent.xx.fbcdn.net/v/t50.31694-16/82877274_168580704395389_6442072919343833857_n.mp4?_nc_cat=102&_nc_ohc=pfuRI1wD3twAX8AvCD6&_nc_ht=scontent.xx&oh=225a7ef08d9a72cf7f5b40580cb45923&oe=5ED484E7',
		'permalink' => 'https://www.instagram.com/p/B7pYqdPAezS/',
		'media_type' => "VIDEO"
	);

	function makeApiCall( $endpoint, $type, $params ) {
		$ch = curl_init();

		if ( 'POST' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
		} elseif ( 'GET' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );
	}

	$mediaInsightsEndpoingFormat = ENDPOINT_BASE . '{ig-media-id}/insights?metric=engagement,impressions,reach,saved,video_views&access_token={access-token}';
	$userInsightsEndpoingFormat = ENDPOINT_BASE . '{ig-user-id}/insights?metric=follower_count,impressions,profile_views,reach&period=day&access_token={access-token}';

	// get media insights
	$mediaInsightsEndpoint = ENDPOINT_BASE . $mediaObject['id'] . '/insights';
	$mediaInsightParams = array(
		'metric' => 'engagement,impressions,reach,saved,video_views',
		'access_token' => $accessToken
	);
	$mediaInsights = makeApiCall( $mediaInsightsEndpoint, 'GET', $mediaInsightParams );

	// get user insights
	$userInsightsEndpoint = ENDPOINT_BASE . $instagramAccountId . '/insights';
	$userInsightParams = array(
		'metric' => 'follower_count,impressions,profile_views,reach',
		'period' => 'day',
		'access_token' => $accessToken
	);
	$userInsights = makeApiCall( $userInsightsEndpoint, 'GET', $userInsightParams );

	// get instagram user metadata endpoint
	$userInfoEndpointFormat = ENDPOINT_BASE . '{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}&access_token={access-token}';
	$userInfoEndpoint = ENDPOINT_BASE . $instagramAccountId;
	$username = 'justinstolpe';
	// endpoint params
	$userInfoParams = array(
		'fields' => 'business_discovery.username(' . $username . '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}',
		'access_token' => $accessToken
	);
	$userInfo = makeApiCall( $userInfoEndpoint, 'GET', $userInfoParams );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Getting Insights on Instagram Posts and User Accounts with the Instagram Graph API</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>Getting Insights on Instagram Posts and User Accounts with the Instagram Graph API</h1>
		<hr />
		<br />
		<h2>User Info</h2>
		<div style="display:inline-block;width:100%">
			<div style="float:left">
				<img style="width:50px;border-radius:50%;" src="<?php echo $userInfo['business_discovery']['profile_picture_url']; ?>" />
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
		<h2>User Insights</h2>
		<ul>
			<?php foreach ( $userInsights['data'] as $insight ) : ?>
				<li>
					<div>
						<b><?php echo $insight['title']; ?></b>
					</div>
					<div>
						<?php foreach ( $insight['values'] as $value ) : ?>
							<div>Value: <?php echo $value['value']; ?> <?php echo $value['end_time']; ?>
						<?php endforeach; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<br />
		<hr />
		<br />
		<h2>Media Object<h2>
		<div style="width:100%;display:inline-block">
			<div style="float:left">
				<video height="390" width="310" controls="">
					<source src="<?php echo $mediaObject['media_url']; ?>">
				</video>
			</div>
			<div style="float:left;margin-left:20px;">
				<a target="_blank" href="<?php echo $mediaObject['permalink']; ?>">
					<h3>
						<?php echo $mediaObject['caption']; ?>
					</h3>
				</a>
			</div>
		</div>
		<h3>Media Object Insights</h3>
		<ul>
			<?php foreach ( $mediaInsights['data'] as $insight ) : ?>
				<li>
					<div>
						<b><?php echo $insight['title']; ?></b>
					</div>
					<div>
						<?php foreach ( $insight['values'] as $value ) : ?>
							<div>Value: <?php echo $value['value']; ?> <?php echo $value['end_time']; ?>
						<?php endforeach; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<h3>
			Get Media Insights Endpoint: <?php echo $mediaInsightsEndpoingFormat; ?>
		</h3>
		<h4>Response<h4>
		<textarea style="width:100%;height:300px"><?php print_r( $mediaInsights ); ?></textarea>
		<h3>
			Get User Insights Endpoint: <?php echo $userInsightsEndpoingFormat; ?>
		</h3>
		<h4>Response<h4>
		<textarea style="width:100%;height:300px"><?php print_r( $userInsights ); ?></textarea>
	</body>
</html>