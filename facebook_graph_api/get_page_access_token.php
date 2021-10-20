<?php
	// include our defines file
	include 'defines.php';

	// include php functions
	include 'functions.php';

	$userInfoParams = array( // endpoint and params for getting a user
		'endpoint_path'=> 'me',
		'fields' => 'accounts,name',
		'access_token' => $userAccessToken,
		'request_type' => 'GET'
	);

	// get user info from the api
	$userInfo = getFacebookUserInfo( $userInfoParams );

	$pageInfoParams = array( // endpoint and params for getting page
		'endpoint_path'=> $pageId,
		'fields' => 'access_token',
		'access_token' => $userAccessToken,
		'request_type' => 'GET'
	);

	// get page info from api
	$pageInfo = getFacebookUserInfo( $pageInfoParams );

	// dump out results on page
	echo '<pre>';
	print_r($userInfo);
	print_r($pageInfo);
	die();