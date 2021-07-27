<?php
	// include defines for access to global variables
	include '../defines.php';

	// syntax for api call endpoint
	$endpointSyntax = 'GET https://graph.facebook.com/v11.0/{ig-user-id}/stories';

	/**
	 * Get a users stories
	 *
	 * @param string $instagramAccountId
	 * @param string $accessToken
	 *
	 * @return array with the api response
	 */
	function getUserStories( $instagramAccountId, $accessToken ) {
		// actual endpoint with a media
		$endpoint = 'https://graph.facebook.com/v11.0/' . $instagramAccountId . '/stories';

		$params = array( // parameters for the endpoint
			'access_token' => $accessToken
		);

		// make the api call and get a response
		$response = makeApiCall( $endpoint, 'GET', $params );

		// return data from the response
		return $response['data']['data'];
	}

	/**
	 * Get media info
	 *
	 * @param array $media
	 * @param string $accessToken
	 *
	 * @return array with the api response
	 */
	function getMediaInfo( $media, $accessToken ) {
		// actual endpoint with a media
		$endpoint = 'https://graph.facebook.com/v11.0/' . $media['id'];

		$params = array( // parameters for the endpoint
			'fields' => 'caption,id,ig_id,media_product_type,media_type,media_url,owner,permalink,shortcode,thumbnail_url,timestamp,username',
			'access_token' => $accessToken
		);

		// make the api call and get a response
		$response = makeApiCall( $endpoint, 'GET', $params );
		
		// return data from the response
		return $response['data'];
	}

	/**
	 * Make a a curl call to an endpoint with params
	 *
	 * @param string $endpoint we are hitting
	 * @param string $type of request
	 * @param array $params to send along with the request
	 *
	 * @return array with the api response
	 */
	function makeApiCall( $endpoint, $type, $params ) {
		// initialize curl
		$ch = curl_init();

		// create endpoint with params
		$apiEndpoint = $endpoint . '?' . http_build_query( $params );
		
		// set other curl options
		curl_setopt( $ch, CURLOPT_URL, $apiEndpoint );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		// get response
		$response = curl_exec( $ch );

		// close curl
		curl_close( $ch );

		return array( // return data
			'type' => $type,
			'endpoint' => $endpoint,
			'params' => $params,
			'api_endpoint' => $apiEndpoint,
			'data' => json_decode( $response, true )
		);
	}

	// get the users stories
	$stories = getUserStories( $instagramAccountId, $accessToken );

	foreach ( $stories as &$story ) { // loop over the each story element
		// add the story media info to the story
		$story['media_info'] = getMediaInfo( $story, $accessToken );
	}

	unset( $story );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Instgram Graph API | IG User | Stories
		</title>
	</head>
	<body>
		<h1>
			Instgram Graph API | IG User | Stories
		</h1>
		<h2>
			<!-- display syntax for reference -->
			<?php echo $endpointSyntax; ?>
		</h2>
		<h3>
			User Stories Response
		</h3>
		<div>
			<!-- dump out the entire response -->
			<pre><?php print_r( $stories ); ?></pre>
		</div>
		<hr />
		<?php foreach ( $stories as $story ) : // loop over each story element ?>
			<?php if ( 'VIDEO' == $story['media_info']['media_type'] ) : // story media is a video ?>
				<div>
					<video controls poster="<?php echo $story['media_info']['thumbnail_url']; ?>" style="max-width:300px">
						<source src="<?php echo $story['media_info']['media_url']; ?>" />
					</video>
				</div>
			<?php elseif ( 'IMAGE' == $story['media_info']['media_type'] ) : // story media is an image ?>
				<div>
					<img src="<?php echo $story['media_info']['media_url']; ?>" style="max-width:300px" />
				</div>
			<?php endif; ?>
			<div>
				<b>
					<?php echo $story['media_info']['username']; ?>
				</b>
			</div>
			<a href="<?php echo $story['media_info']['permalink']; ?>" target="_blank">
				View on Instagram
			</a>
		<?php endforeach; ?>
	</body>
</html>