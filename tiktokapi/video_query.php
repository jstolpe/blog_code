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

	$videoIds = array( // videos ids we want info (max 20 ids)
	    '<TIKTOK_VIDEO_ID>',
	    '<TIKTOK_VIDEO_ID>',
	    '<TIKTOK_VIDEO_ID>',
	    // ...
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

	// get video list (fields can be omitted for default functionality)
	$videoQuery = $video->query( $videoIds, $fields );

	echo '<pre>';
	print_r( $videoQuery );
?>