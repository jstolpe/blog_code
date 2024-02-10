<?php
	require_once 'defines.php';
	require_once 'vendor/autoload.php'; // composer
	//require_once 'tiktok-api-php-sdk/src/TikTok/autoload.php'; // not composer

	use TikTok\Video\Video;
	use TikTok\Request\Params;
	use TikTok\Request\Fields;

	$config = array( // instantiation config params
	    'access_token' => USER_ACCESS_TOKEN
	);

	// instantiate the video
	$video = new Video( $config );

	$params = array( // customize params for the request
	    'max_count' => 5 // customize how many videos we want in each request (max is 20)
	);

	$fields = array( // customize fields for the videos
	    Fields::ID,
	    Fields::CREATE_TIME,
	    Fields::TITLE,
	    Fields::COVER_IMAGE_URL,
	    Fields::SHARE_URL,
	    Fields::VIDEO_DESCRIPTION,
	    Fields::DURATION,
	    Fields::HEIGHT,
	    Fields::WIDTH,
	    Fields::TITLE,
	    Fields::EMBED_HTML,
	    Fields::EMBED_LINK,
	    Fields::LIKE_COUNT,
	    Fields::COMMENT_COUNT,
	    Fields::SHARE_COUNT,
	    Fields::VIEW_COUNT
	);

	// get video list (params and fields can both be omitted for default functionality)
	$videoList = $video->getList( $params, $fields );

	echo '<pre>';
	print_r( $videoList );

	if ( $videoList['cursor_next'] ) { // we have more videos
	    // add on cursor for the next request
	    $params['cursor'] = $videoList['cursor_next'];

	    // get video list with new cursor (next page)
	    $videoList = $video->getList( $params, $fields );

	    print_r( '---------NEXT---------' );
	    print_r( $videoList );
	}
?>