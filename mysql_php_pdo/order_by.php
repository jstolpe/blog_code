<?php
	// include global things for use
	include 'global_data.php';

	$sql = array( // array keyed by the various sql statments we can run
		'ORDERBYASC' => '
			SELECT
				*
			FROM
				drinks
			ORDER BY
				expiration_date ASC
		',
		'ORDERBYDESC' => '
			SELECT
				*
			FROM
				drinks
			ORDER BY
				expiration_date DESC
		'
	);

	// check url for sql statement to run
	$sql = isset( $_GET['filter'] ) && isset( $sql[$_GET['filter']] ) ? $sql[$_GET['filter']] : $sql['ORDERBYASC'];

	// prepare the sql
	$statement = $database->prepare( $sql );

	// execute the sql
	$statement->execute();

	// get the query data
	$queryDrinks = $statement->fetchAll();

	// display the html
	displayViewHtml( $sql, $allDrinks, $queryDrinks, $statement );
?>