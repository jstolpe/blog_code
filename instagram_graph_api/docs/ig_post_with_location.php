<?php
	include '../defines.php';

	function makeApiCall( $endpoint, $type, $params ) {
		$ch = curl_init();

		if ( 'POST' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
		} elseif ( 'GET' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		}

		// set other curl options
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );
	}

	// endpoint formats
	$imagesEnpointFormat = 'https://graph.facebook.com/v5.0/{ig-user-id}/media?image_url={image-url}&caption={caption}&access_token={access-token}';

	// create media object for image
	$imageMediaObjectEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media';
	$imageMediaObjectEndpointParams = array( // POST variables
		'image_url' => 'https://justinstolpe.com/sandbox/ig_pic_post_location_square.jpg',
		'caption' => 'Going 127.0.0.1 after work!
			.
			Youtube.com/justinstolpe
			.
			#developer #coding #code #learntocode #tutorial #codinglife #html #javascript #jquery #css #php #dev #webdev #tutorial #learntocode #tech #developerlife #programmerhumor #redbull #work',
		'location_id' => $pageId,
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

	// publish media
	$imageMediaObjectId = $imageMediaObjectResponseArray['id'];
	$publishImageEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media_publish';
	$publishEndpointParams = array(
		'creation_id' => $imageMediaObjectId,
		'access_token' => $accessToken
	);
	$publishImageResponseArray = makeApiCall( $publishImageEndpoint, 'POST', $publishEndpointParams );
?>