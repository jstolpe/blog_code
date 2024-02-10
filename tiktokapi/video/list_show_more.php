<?php
	require_once '../defines.php';
	require_once '../vendor/autoload.php'; // composer
	//require_once '../tiktok-api-php-sdk/src/TikTok/autoload.php'; // not composer

	use TikTok\Video\Video;
	use TikTok\Request\Params;
	use TikTok\Request\Fields;

	$config = array( // instantiation config params
	    'access_token' => '<USER_ACCESS_TOKEN>'
	);

	// instantiate the video
	$video = new Video( $config );

	$params = array( // customize params for the request
	    'max_count' => 10 // customize how many videos we want in each request (max is 20)
	);

	if ( $_GET['cursor'] ) {
		$params['cursor'] = $_GET['cursor'];
	}

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

	ob_start();

	?>

	<?php foreach ( $videoList['data']['videos'] as $video ) : // loop over video from response ?>
		<div class="tiktok-card">
    		<img src="<?php echo $video['cover_image_url']; ?>" />
    		<div class="tiktok-card-title">
    			<?php echo $video['title']; ?>
    		</div>
    		<div class="tiktok-card-info">
	    		<div>
	    			<b><?php echo number_format( $video['view_count'] ); ?></b> views
	    		</div>
	    		<div>
	    			<b><?php echo number_format( $video['like_count'] ); ?></b> likes
	    		</div>
	    		<div>
	    			<b><?php echo number_format( $video['comment_count'] ); ?></b> comments
	    		</div>
	    		<div>
	    			<b><?php echo number_format( $video['share_count'] ); ?></b> shares
	    		</div>
	    	</div>
	    	<div class="tiktok-card-actions">
		    	<a href="<?php echo $video['share_url']; ?>" target="_blank">
			    	<div class="tiktok-button">
			    		Watch on TikTok
			    	</div>
			    </a>
			</div>
    	</div>
	<?php endforeach ; ?>
	
	<?php

	echo json_encode( array(
		'cursor' => $videoList['cursor_next'] ? $videoList['cursor_next'] : '',
		'html' => ob_get_clean()
	) );