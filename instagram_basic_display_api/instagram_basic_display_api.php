<?php
	require_once( 'defines.php' );

	Class instagram_basic_display_api {
		private $_appId = INSTAGRAM_APP_ID;
		private $_appSecret = INSTAGRAM_APP_SECRET;
		private $_redirectUrl = INSTAGRAM_APP_REDIRECT_URI;
		private $_getCode = '';
		private $_apiBaseUrl = 'https://api.instagram.com/';
		private $_userAccessToken = '';

		public $authorizationUrl = '';
		public $hasUserAccessToken = false;

		function __construct( $params ) {
			// save instagram code
			$this->_getCode = $params['get_code'];

			// get an access token
			$this->_setUserInstagramAccessToken( $params );

			// get authorization url
			$this->_setAuthorizationUrl();
		}

		public function getUserAccessToken() {
			return $this->_userAccessToken;
		}

		private function _setAuthorizationUrl() {
			$getVars = array( 
				'app_id' => $this->_appId,
				'redirect_uri' => $this->_redirectUrl,
				'scope' => 'user_profile,user_media',
				'response_type' => 'code'
			);

			// create url
			$this->authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );
		}

		private function _setUserInstagramAccessToken( $params ) {
			if ( $params['get_code'] ) { // try and get an access token
				$userAccessTokenResponse = $this->_getUserAccessToken();
				$this->_userAccessToken = $userAccessTokenResponse['access_token'];
				$this->hasUserAccessToken = true;
			}
		}

		private function _getUserAccessToken() {
			$params = array(
				'endpoint_url' => $this->_apiBaseUrl . 'oauth/access_token',
				'type' => 'POST',
				'url_params' => array(
					'app_id' => $this->_appId,
					'app_secret' => $this->_appSecret,
					'grant_type' => 'authorization_code',
					'redirect_uri' => $this->_redirectUrl,
					'code' => $this->_getCode
				)
			);

			$response = $this->_makeApiCall( $params );
			return $response;
		}

		private function _makeApiCall( $params ) {
			$ch = curl_init();

			$endpoint = $params['endpoint_url'];

			if ( 'POST' == $params['type'] ) { // post request
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params['url_params'] ) );
				curl_setopt( $ch, CURLOPT_POST, 1 );
			}

			// general curl options
			curl_setopt( $ch, CURLOPT_URL, $endpoint );

			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

			$response = curl_exec( $ch );

			curl_close( $ch );

			$responseArray = json_decode( $response, true );

			if ( isset( $responseArray['error_type'] ) ) {
				var_dump( $responseArray );
				die();
			} else {
				return $responseArray;
			}
		}
	}
