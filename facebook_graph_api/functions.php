<?php
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

	/**
	 * Get facebook api login url that will take the user to facebook and present them with login dialog.
	 *
	 * Endpoint: https://www.facebook.com/{fb-graph-api-version}/dialog/oauth?client_id={app-id}&redirect_uri={redirect-uri}&state={state}&scope={scope}&auth_type={auth-type}
	 *
	 * @param string $scope comma separated list of permissions being requested from the user..
	 * @param string $state random generated to verify request is from facebook.
	 * @return string
	 */
	function getFacebookLoginUrl( $permissions, $state ) {
		// endpoint for facebook login dialog
		$endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';

		$params = array( // login url params required to direct user to facebook and promt them with a login dialog
			'client_id' => FB_APP_ID,
			'redirect_uri' => FB_REDIRECT_URI,
			'state' => $state,
			'scope' => $permissions,
			'auth_type' => 'rerequest'
		);

		// return login url
		return $endpoint . '?' . http_build_query( $params );
	}

	/**
	 * Get an access token with the code from facebook.
	 *
	 * Endpoint https://graph.facebook.com/{fb-graph-version}/oauth/access_token?client_id{app-id}&client_secret={app-secret}&redirect_uri={redirect_uri}&code={code}
	 *
	 * @param string $code code returned from facebook, exchange for access token
	 * @return array $response
	 */
	function getAccessTokenWithCode( $code ) {
		// endpoint for getting an access token with code
		$endpoint = FB_GRAPH_DOMAIN . FB_GRAPH_VERSION . '/oauth/access_token';

		$params = array( // params for the endpoint
			'client_id' => FB_APP_ID,
			'client_secret' => FB_APP_SECRET,
			'redirect_uri' => FB_REDIRECT_URI,
			'code' => $code
		);

		// make the api call
		return makeApiCall( $endpoint, 'GET', $params );
	}