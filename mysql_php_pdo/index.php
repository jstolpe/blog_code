<?php
	// include global things for use
	include 'global_data.php';

	// sql string
	$sql = '
		SELECT
			*
		FROM
			drinks
	';

	// prepare the sql
	$statement = $database->prepare( $sql );

	// execute the sql
	$statement->execute();

	// get the query data
	$queryDrinks = $statement->fetchAll();

	// display the html
	displayViewHtml( $sql, $allDrinks, $queryDrinks, $statement );
?>