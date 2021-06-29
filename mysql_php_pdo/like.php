<?php
	// include global things for use
	include 'global_data.php';

	$sql = array( // array keyed by the various sql statments we can run
		'LIKEANY' => array(
			'sql' => '
				SELECT
					*
				FROM
					drinks
				WHERE
					name LIKE CONCAT("%", :term, "%")
			',
			'term' => 'Sugar'
		),
		'LIKEEND' => array(
			'sql' => '
				SELECT
					*
				FROM
					drinks
				WHERE
					name LIKE CONCAT("%", :term)
			',
			'term' => 'l'
		),
		'LIKESTART' => array(
			'sql' => '
				SELECT
					*
				FROM
					drinks
				WHERE
					name LIKE CONCAT(:term, "%")
				',
			'term' => 'Red Bull - T'
		),
		'NOTLIKESTART' => array(
			'sql' => '
				SELECT
					*
				FROM
					drinks
				WHERE
					name NOT LIKE CONCAT(:term, "%")
			',
			'term' => 'Red Bull - T'
		)
	);

	// check url for sql statement to run
	$selectedSql = isset( $_GET['filter'] ) && isset( $sql[$_GET['filter']] ) ? $sql[$_GET['filter']] : $sql['LIKEANY'];

	$params = array( // keys must match the variables in the sql so they can get replaced with the value
		':term' => $selectedSql['term']
	);

	// prepare the sql
	$statement = $database->prepare( $selectedSql['sql'] );

	// execute the sql
	$statement->execute( $params );

	// get the query data
	$queryDrinks = $statement->fetchAll();

	// display the html
	displayViewHtml( $selectedSql['sql'], $allDrinks, $queryDrinks, $statement );
?>
