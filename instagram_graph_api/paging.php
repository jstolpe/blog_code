<?php
	// include creds for api access
	include 'defines.php';

	// get limit/cursor/cursor_type from url vars if they exist
	$limit = isset( $_GET['limit'] ) ? $_GET['limit'] : '4';
	$cursor = isset( $_GET['cursor'] ) ? $_GET['cursor'] : '';
	$cursorType = isset( $_GET['cursor_type'] ) ? $_GET['cursor_type'] : '';

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

		// combine endpoint and params and set other curl options
		curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		// get response
		$response = curl_exec( $ch );

		// close curl
		curl_close( $ch );

		// json decode and return response
		return json_decode( $response, true );
	}

	/**
	 * Get a page of instagram posts for a user
	 *
	 * @param string $instagramAccountId id of the instagram account
	 * @param string $accessToken access token needed to validate the request
	 * @param string $limit number of results to return
	 * @param string $cursorType specify getting the previous or next page with (before|after)
	 * @param string $cursor token for accessing the requested pages data
	 *
	 * @return array with the page of data
	 */
	function getAPage( $instagramAccountId, $accessToken, $limit, $cursorType, $cursor ) {
		// endpoint structure for getting users media -> https://graph.facebook.com/v5.0/{ig-account-id}/media
		$usersMediaEndpoint = ENDPOINT_BASE . $instagramAccountId . '/media';
		
		// endpoint params required
		$usersMediaParams = array( 
			'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username',
			'limit' => $limit,
			'access_token' => $accessToken
		);

		if ( $cursorType && $cursor ) { // if cursor and cursor type exists the add them onto the params
			$usersMediaParams[$cursorType] = $cursor;
		}

		// make the api call
		$usersMedia = makeApiCall( $usersMediaEndpoint, 'GET', $usersMediaParams );

		// return the response
		return $usersMedia;
	}

	// get the page specifiec based on the limit, cursor type, and cursor
	$usersMedia = getAPage( $instagramAccountId, $accessToken, $limit, $cursorType, $cursor );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Instagram Graph API Pagination and Cursors
		</title>

		<!-- char set -->
		<meta charset="utf-8" />

		<!-- set viewport -->
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

		<!-- more meta data -->
		<meta name="title" content="Instagram Graph API Pagination and Cursors" />
		<meta name="description" content="Instagram Graph API Pagination and Cursors" />
		<meta name="keywords" content="Instagram Pagination, Instagram Cursors, Instagram Graph API, Instagram API, Graph API" />
		<meta name="author" content="Justin Stolpe" />
		<meta name="robots" content="index, follow" />

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
		</style>
	</head>
	<body>
		<h1>
			Instagram Graph API Pagination and Cursors
		</h1>
		<hr />
		<br />
		<div class="nav-container">
			<?php if ( isset( $usersMedia['paging']['previous'] ) ) : ?>
				<a href="<?php $_SERVER['PHP_SELF']; ?>?cursor_type=before&cursor=<?php echo $usersMedia['paging']['cursors']['before']; ?>&limit=<?php echo $limit; ?>">
					< PREVIOUS
				</a>
			<?php endif; ?>
			<?php if ( isset( $usersMedia['paging']['next'] ) ) : ?>
				<a class="nav-next" href="<?php $_SERVER['PHP_SELF']; ?>?cursor_type=after&cursor=<?php echo $usersMedia['paging']['cursors']['after']; ?>&limit=<?php echo $limit; ?>">
					NEXT >
				</a>
			<?php endif; ?>
		</div>
		<ul class="pages-list">
			<?php foreach ( $usersMedia['data'] as $media ) : // loop over posts returned for the page ?>
				<li class="pages-list-item">
					<?php if ( 'IMAGE' == $media['media_type'] || 'CAROUSEL_ALBUM' == $media['media_type'] ) : // media is an image ?>
						<img class="pages-media" src="<?php echo $media['media_url']; ?>" />
					<?php else : // media is a video ?>
						<video class="pages-media" controls>
							<source src="<?php echo $media['media_url']; ?>" >
						</video>
					<?php endif; ?>
					<h4>
						<?php echo nl2br( $media['caption'] ); // display the caption preserving spaces ?>
					</h4>
					<div>
						Link to Post:
						<br />
						<a target="_blank" href="<?php echo $media['permalink']; ?>">
							<?php echo $media['permalink']; // link to media on instagram ?>
						</a>
					</div>
					<br />
					<div>
						Post at: <?php echo $media['timestamp']; // time the media was posted ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<hr />
		<br />
		<textarea class="raw-response">
			<?php print_r( $usersMedia ); // dump out the actual respone from the api in a textarea ?>
		</textarea>
	</body>
</html>