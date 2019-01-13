<?php
	// access token
	$accessToken = 'ACCESS-TOKEN';

	// access token type
	$accessTokenType = 'ACCESS-TOKEN-TYPE';

	// reddit username
	$username = 'YOUR-REDDIT-USERNAME';

	// subreddit name (no spaces)
	$subredditName = 'SUBREDDIT-NAME';

	// subreddit display name (can have spaces)
	$subredditDisplayName = 'SUBREDDIT-DISPLAY-NAME';

	// subreddit post title
	$subredditPostTitle = 'SUBREDDIT-POST-TITLE';

	//subreddit post url
	$subredditUrl = 'SUBREDDIT-POST-URL';

	// api call endpoint
	$apiCallEndpoint = 'https://oauth.reddit.com/api/submit';

	// post data: posting a link to a subreddit
	$postData = array(
        'url' => $subredditUrl,
        'title' => $subredditPostTitle,
        'sr' => $subredditName,
        'kind' => 'link'
    );

    // curl settings and call to post to the subreddit
    $ch = curl_init( $apiCallEndpoint );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_USERAGENT, $subredditDisplayName . ' by /u/' . $username . ' (Phapper 1.0)' );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Authorization: " . $accessTokenType . " " . $accessToken ) );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );

	// curl response from our post call
    $response_raw = curl_exec( $ch );
    $response = json_decode( $response_raw );
    curl_close( $ch );
?>