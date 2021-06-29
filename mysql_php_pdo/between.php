<?php
	// include global things for use
	include 'global_data.php';

	$sql = array( // array keyed by the various sql statments we can run
		'BETWEEN' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				expiration_date BETWEEN 
					CAST(:start_date AS DATE) AND 
					CAST(:end_date AS DATE)
		',
		'NOTBETWEEN' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				expiration_date NOT BETWEEN 
					CAST(:start_date AS DATE) AND 
					CAST(:end_date AS DATE)
		'
	);

	// check url for sql statement to run
	$sql = isset( $_GET['filter'] ) && isset( $sql[$_GET['filter']] ) ? $sql[$_GET['filter']] : $sql['BETWEEN'];

	$params = array( // keys must match the variables in the sql so they can get replaced with the value
		':start_date' => '2021-11-01',
		':end_date' => '2021-12-01'
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