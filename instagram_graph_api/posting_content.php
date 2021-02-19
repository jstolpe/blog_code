<?php
	include 'defines.php';

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

	// endpoint formats
	$imagesEndpointFormat = 'https://graph.facebook.com/v5.0/{ig-user-id}/media?image_url={image-url}&caption={caption}&access_token={access-token}';
	$videoEndpointFormat = 'https://graph.facebook.com/v5.0/{ig-user-id}/media?video_url={video-url}&media_type&caption={caption}&access_token={access-token}';
	$publishMediaEndpointFormat = 'https://graph.facebook.com/v5.0/{ig-user-id}/media_publish?creation_id={creation-id}&access_token={access-token}';
	$userApiLimitEndpointFormat = 'https://graph.facebook.com/v5.0/{ig-user-id}/content_publishing_limit';
	$mediaObejctStatusEndpointFormat = 'https://graph.facebook.com/v5.0/{ig-container-id}?fields=status_code';

	/***
	 * IMAGE
	 */
	$imageMediaObjectEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media';
	$imageMediaObjectEndpointParams = array( // POST 
		'image_url' => 'http://justinstolpe.com/sandbox/ig_publish_content_img.png',
		'caption' => 'This image was posted through the Instagram Graph API with a script I wrote! Go check out the video tutorial on my YouTube channel.
			.
			youtube.com/justinstolpe
			.
			#instagram #graphapi #instagramgraphapi #code #coding #programming #php #api #webdeveloper #codinglife #developer #coder #tech #developerlife #webdev #youtube #instgramgraphapi
		',
		'access_token' => $accessToken
	);
	$imageMediaObjectResponseArray = makeApiCall( $imageMediaObjectEndpoint, 'POST', $imageMediaObjectEndpointParams );

	// set status to in progress
	$imageMediaObjectStatusCode = 'IN_PROGRESS';

	while( $imageMediaObjectStatusCode != 'FINISHED' ) { // keep checking media object until it is ready for publishing
		$imageMediaObjectStatusEndpoint = ENDPOINT_BASE . $imageMediaObjectResponseArray['id'];
		$imageMediaObjectStatusEndpointParams = array( // endpoint params
			'fields' => 'status_code',
			'access_token' => $accessToken
		);
		$imageMediaObjectResponseArray = makeApiCall( $imageMediaObjectStatusEndpoint, 'GET', $imageMediaObjectStatusEndpointParams );
		$imageMediaObjectStatusCode = $imageMediaObjectResponseArray['status_code'];
		sleep( 5 );
	}

	// publish image
	$imageMediaObjectId = $imageMediaObjectResponseArray['id'];
	$publishImageEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media_publish';
	$publishEndpointParams = array(
		'creation_id' => $imageMediaObjectId,
		'access_token' => $accessToken
	);
	$publishImageResponseArray = makeApiCall( $publishImageEndpoint, 'POST', $publishEndpointParams );

	/***
	 * VIDEO
	 */
	// create media object for video
	$videoMediaObjectEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media';
	$videoMediaObjectEndpointParams = array( // POST variables
		'media_type' => 'VIDEO',
		'video_url' => 'https://justinstolpe.com/sandbox/ig_publish_content_vid.mp4',
		'caption' => 'This video was posted through the Instagram Graph API with a script I wrote! Go check out the video tutorial on my YouTube channel.
	 		.
	 		youtube.com/justinstolpe
	 		.
	 	#instagram #graphapi #instagramgraphapi #code #coding #programming #php #api #webdeveloper #codinglife #developer #coder #tech #developerlife #webdev #youtube #instgramgraphapi',
		'access_token' => $accessToken
	);
	$videoMediaObjectResponseArray = makeApiCall( $videoMediaObjectEndpoint, 'POST', $videoMediaObjectEndpointParams );

	// set status to in progress
	$videoMediaObjectStatusCode = 'IN_PROGRESS';

	while( $videoMediaObjectStatusCode != 'FINISHED' ) { // keep checking media object until it is ready for publishing
		$videoMediaObjectStatusEndpoint = ENDPOINT_BASE . $videoMediaObjectResponseArray['id'];
		$videoMediaObjectStatusEndpointParams = array( // endpoint params
			'fields' => 'status_code',
			'access_token' => $accessToken
		);
		$videoMediaObjectResponseArray = makeApiCall( $videoMediaObjectStatusEndpoint, 'GET', $videoMediaObjectStatusEndpointParams );
		$videoMediaObjectStatusCode = $videoMediaObjectResponseArray['status_code'];
		sleep( 5 );
	}

	// publish video
	$videoMediaObjectId = $videoMediaObjectResponseArray['id'];
	$publishVideoEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media_publish';
	$publishVideoEndpointParams = array(
		'creation_id' => $videoMediaObjectId,
		'access_token' => $accessToken
	);
	$publishVideoResponseArray = makeApiCall( $publishVideoEndpoint, 'POST', $publishVideoEndpointParams );

	/***
	 * API LIMIT
	 */
	// check user api limit
	$limitEndpoint = ENDPOINT_BASE . $instagramAccountId . '/content_publishing_limit';
	$limitEndpointParams = array( // get params
		'fields' => 'config,quota_usage',
		'access_token' => $accessToken
	);
	$limitResponseArray = makeApiCall( $limitEndpoint, 'GET', $limitEndpointParams );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Instagram Graph API Content Publishing
		</title>
		<style>
			body {
				font-family: 'Helvetica';
			}

			.raw-response {
				width: 100%;
				height: 100px;
			}
		</style>
	</head>
	<body>
		<h1>Instagram Graph API Content Publishing</h1>
		<hr />
		<h3>Media Object Image Endpoint: <?php echo $imagesEndpointFormat; ?></h3>
		<h3>Raw Response</h3>
		<textarea class="raw-response">
			<?php print_r( $imageMediaObjectResponseArray ); ?>
		</textarea>
		<hr />
		<h3>Publish Image Endpoint: <?php echo $publishMediaEndpointFormat; ?></h3>
		<h3>Raw Response</h3>
		<textarea class="raw-response">
			<?php print_r( $publishImageResponseArray ) ; ?>
		</textarea>
		<hr />
		<h3>Media Object Video Endpoint: <?php echo $videoEndpointFormat; ?></h3>
		<h3>Raw Response</h3>
		<textarea class="raw-response">
			<?php print_r( $videoMediaObjectResponseArray ) ; ?>
		</textarea>
		<hr />
		<h3>Publish Video Endpoint: <?php echo $publishMediaEndpointFormat; ?></h3>
		<h3>Raw Response</h3>
		<textarea class="raw-response">
			<?php print_r($publishVideoResponseArray ) ; ?>
		</textarea>
		<hr />
		<h3>User API Limit Endpoint: <?php echo $userApiLimitEndpointFormat; ?></h3>
		<h3>Raw Response</h3>
		<textarea class="raw-response">
			<?php print_r( $limitResponseArray ) ; ?>
		</textarea>
		<hr />
		<h3>Media Status Endpoint: <?php echo $mediaObejctStatusEndpointFormat; ?></h3>
	</body>
</html>