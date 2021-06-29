<?php
	// include global things for use
	include 'global_data.php';

	$sql = array( // array keyed by the various sql statments we can run
		'IN' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				name IN (:name1, :name2)
		',
		'NOTIN' => '
			SELECT
				*
			FROM
				drinks
			WHERE
				name NOT IN (:name1, :name2)
		'
	);

	// check url for sql statement to run
	$sql = isset( $_GET['filter'] ) && isset( $sql[$_GET['filter']] ) ? $sql[$_GET['filter']] : $sql['IN'];

	$params = array( // keys must match the variables in the sql so they can get replaced with the value
		':name1' => 'Red Bull - Sugar Free',
		':name2' => 'Red Bull - Tropical'
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