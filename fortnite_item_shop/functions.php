<?php
	// required creds
	require_once( 'config.php');

	// central time
	date_default_timezone_set( 'America/Chicago' );

	/**
	 * Get store data from the fortnite api and save it in a json file
	 *
	 * @param String $date of the store to save
	 *
	 * @return void
	 */
	function getStoreDataFromAPI( $date ) {
		// store api endpoint, we hit those endpoints!
		$apiUrlEndpointStore = 'https://api.fortnitetracker.com/v1/store';

		// curl setup
		$ch = curl_init();

		// specify the store endpoint
		curl_setopt( $ch, CURLOPT_URL, $apiUrlEndpointStore );

		// pass our api key along as the TRN-Api-Key header
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		    'TRN-Api-Key:' . FN_API_KEY
		) );

		// set a few other things to make curl happy
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $ch, CURLOPT_HEADER, FALSE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		
		// response from the store endpoint
		$response = curl_exec( $ch );

		// create a file titled 'YYYY-MM-DD' and save the json repsonse to the file
		$storeFile = fopen( 'store_json_files/' . $date . '.json', 'w' );
		fwrite( $storeFile, $response );
		fclose( $storeFile );
	}

	/**
	 * Get data from either the json file or hit the api for data.
	 *
	 * @param void
	 *
	 * @return void
	 */
	function getStoreData( $date ) {
		// make sure we have a json file with store data
		if ( !file_exists( 'store_json_files/' . $date . '.json' ) ) { // if no json file found for the current date hit the api
			getStoreDataFromAPI( $date );
		}

		// return store data as a php array
		return json_decode( file_get_contents( 'store_json_files/' . $date . '.json' ), true );
	}

	/**
	 * Get formatted store data.
	 *
	 * @param void
	 *
	 * @return Array $sortedItems
	 */
	function getStoreSortedData( $date ) {
		// get items
		$items = getStoreData( $date );

		// create sorted array with two sections weekly and daily
		$sortedItems = array(
			'BRWeeklyStorefront' => array(
				'info' => array(
					'title' => 'FEATURED ITEMS'
				),
				'items' => array()
			),
			'BRDailyStorefront' => array(
				'info' => array(
					'title' => 'DAILY ITEMS'
				),
				'items' => array()
			)
		);

		foreach ( $items as $item ) { // place each item in the correct section daily or weekly
			// create link to fortnite site with details on item
			$itemUrlName = strtolower( $item['name'] );
			$itemUrlName = str_replace( ' ', '-', $itemUrlName );
			$item['link_to_fn_item'] = 'https://fortnitetracker.com/locker/' . $item['manifestId'] . '/' . $itemUrlName;

			// add item to sorted items
			$sortedItems[$item['storeCategory']]['items'][] = $item;
		}

		// return our sorted items array
		return $sortedItems;
	}

	/**
	 * Get files in the store_json_files folder
	 *
	 * @param void
	 *
	 * @return Array $storeJsonFiles
	 */
	function getStoreJsonFiles() {
		// get files from our directory
		$allFiles = scandir( 'store_json_files' );

		// sort by newest day first
		rsort( $allFiles );

		// create our array of valid dates
		$validFiles = array();

		foreach ( $allFiles as $file ) { // loop over files in our directory
			// explode on the dot our files are always in the format of YYY-MM-DD.json
			$namePieces = explode( '.', $file );

			if ( isset( $namePieces[1] ) && 'json' == $namePieces[1] ) { // our files always have a date with a json extention
				$validFiles[] = array(
					'file' => $file,
					'date' => $namePieces[0],
					'link_json' => 'http://' . $_SERVER['HTTP_HOST'] . '/blog_code/fortnite_item_shop/store_json_files/' . $file,
					'link_store' => 'http://' . $_SERVER['HTTP_HOST'] . '/blog_code/fortnite_item_shop/?date=' . $namePieces[0],
				);
			}
		}

		// return valid files
		return $validFiles;
	}

	/**
	 * Get store date and validate GET var
	 *
	 * @param void
	 *
	 * @return String $date
	 */
	function getStoreDate() {
		// get todays date and tomorrows date in case item shop has refreshed
		$date = date( 'Y-m-d' );
		$tomorrowsDate = date( 'Y-m-d', strtotime(' +1 day') );

		if ( date( 'G' ) >= 18 ) { // if today, and greater than 18 hours utc, (6pm) new item shop is out so gen file for next day
			$date = $tomorrowsDate;
		}

		if ( isset( $_GET['date'] ) && $date != $_GET['date'] ) { // if user is requesting a date and it is not today try and override
			// get list of all json files we have
			$pastFiles = getStoreJsonFiles();

			foreach ( $pastFiles as $file ) { // loop over all past files
				if ( $file['date'] == $_GET['date'] ) { // if GET var date equals a file name we have a match!
					// set date and exit loop
					$date = $file['date'];
					break;
				}
			}
		}

		// return valid date
		return $date;
	}
?>