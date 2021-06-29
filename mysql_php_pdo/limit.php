<?php
	// include global things for use
	include 'global_data.php';
	
	$sql = array( // array keyed by the various sql statments we can run
		'LIMIT' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				size = :size
			ORDER BY
				expiration_date ASC
			LIMIT 1
		',
		'LIMITOFFSET' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				size = :size
			ORDER BY
				expiration_date ASC
			LIMIT 3, 3
		'
	);

	// check url for sql statement to run
	$sql = isset( $_GET['filter'] ) && isset( $sql[$_GET['filter']] ) ? $sql[$_GET['filter']] : $sql['LIMIT'];

	$params = array( // keys must match the variables in the sql so they can get replaced with the value
		':size' => '12oz'
	);
	
	// prepare the sql
	$statement = $database->prepare( $sql );

	// execute the sql
	$statement->execute( $params );

	// get the query data
	$queryDrinks = $statement->fetchAll();

	// display the html
	displayViewHtml( $sql, $allDrinks, $queryDrinks, $statement );
?>