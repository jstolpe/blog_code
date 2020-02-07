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

	// endpoint formats
	$commentsEndpointFormat = ENDPOINT_BASE . '{ig-media-id}/comments?fields=like_count,replies,username,text';
	$repliesEndpointFormat = ENDPOINT_BASE . '{ig-comment-id}/replies?fields=username,text,like_count';
	$postCommentEndpointFormat = ENDPOINT_BASE . '{ig-media-id}/comments?message={message}';
	$postReplyEndpointFormat = ENDPOINT_BASE . '{ig-comment-id}/replies?message={message}';

	// post comment to IG
	// $postCommentEndpoint = ENDPOINT_BASE . $mediaObject['id'] . '/comments';
	// $postCommentIgParams = array(
	// 	'message' => 'Commenting from IG Graph API!! :)',
	// 	'access_token' => $accessToken
	// );
	// $postCommentResponseArray = makeApiCall( $postCommentEndpoint, 'POST', $postCommentIgParams );
	// echo '<pre>';
	// print_r($postCommentResponseArray);
	// die();

	// post reply to comment
	// $commentId = '17982899548288082';
	// $postReplyEndpoint = ENDPOINT_BASE . $commentId . '/replies';
	// $postReplyIgParams = array(
	// 	'message' => 'Reply coming from IG Graph API!! :)',
	// 	'access_token' => $accessToken
	// );
	// $postReplyResponseArray = makeApiCall( $postReplyEndpoint, 'POST', $postReplyIgParams );
	// echo '<pre>';
	// print_r($postReplyResponseArray);
	// die();


	// get comments from IG
	$commentsEndpoint = ENDPOINT_BASE . $mediaObject['id'] . '/comments';
	$igParams = array(
		'fields' => 'like_count,replies,username,text',
		'access_token' => $accessToken
	);
	$responseArray = makeApiCall( $commentsEndpoint, 'GET', $igParams );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Getting and Replying to Comments on Instagram with the Instagram Graph API</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>Getting and Replying to Comments on Instagram with the Instagram Graph API</h1>
		<hr />
		<br />
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
		<br />
		<h4>
			Comments
		</h4>
		<ul style="list-style: none">
			<?php foreach ( $responseArray['data'] as $comment ) : ?>
				<?php
					// get comment replies from instagram
					$repliesEndpoint = ENDPOINT_BASE . $comment['id'] . '/replies';
					$repliesIgParams = array(
						'fields' => 'username,text,like_count',
						'access_token' => $accessToken
					);
					$repliesResponseArray = makeApiCall( $repliesEndpoint, 'GET', $repliesIgParams );
				?>
				<li style="margin-top:20px;margin-bottom:20px">
					<div>
						<a href="https://instagram.com/<?php echo $comment['username']; ?>" target="_blank">
							<b><?php echo $comment['username']; ?></b>
						</a>
					</div>
					<div>
						<?php echo $comment['text']; ?>
					</div>
					<div style="font-size:10px">
						Likes <?php echo $comment['like_count']; ?>
					</div>
					<div>
						<h5>
							Replies (<?php echo count( $repliesResponseArray['data'] ); ?>)
						</h5>
					</div>
					<div style="margin-left:20px">
						<ul style="list-style: none">
							<?php foreach ( $repliesResponseArray['data'] as $reply ) : ?>
								<div>
									<a href="https://instagram.com/<?php echo $reply['username']; ?>" target="_blank">
										<b><?php echo $reply['username']; ?></b>
									</a>
								</div>
								<div>
									<?php echo $reply['text']; ?>
								</div>
								<div style="font-size:10px">
									Likes <?php echo $reply['like_count']; ?>
								</div>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<br />
		<hr />
		<h3>
			Get Comments Endpoint: <?php echo $commentsEndpointFormat; ?>
		</h3>
		<hr />
		<h3>
			Get Replies Endpoint: <?php echo $repliesEndpointFormat; ?>
		</h3>
		<hr />
		<h3>
			Post Comments Endpoint: <?php echo $postCommentEndpointFormat; ?>
		</h3>
		<hr />
		<h3>
			Post Replies Endpoint: <?php echo $postReplyEndpointFormat; ?>
		</h3>
		<hr />
		<h3>
			Get Comments Raw Response
		</h3>
		<textarea style="width:100%;height:300px"><?php print_r( $responseArray ); ?></textarea>
	</body>
</html>