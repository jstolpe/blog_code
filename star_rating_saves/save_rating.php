<?php
	define( 'DB_HOST', 'localhost' );
	define( 'DB_NAME', 'star_rating_saves' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASS', '' );

	try {
		$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS );
		$message = 'You rated ' . $_POST['stars'] . ' stars';
	} catch ( PDOException $e ) {
		$message = $e->getMessage();
	}

	$statement = $conn->prepare( '
		UPDATE
			ratings
		SET
			rating_percent = :rating_percent
		WHERE
			id = :id
	' );

	$params = array(
		'rating_percent' => $_POST['stars'] * 20,
		'id' => $_POST['id']
	);

	$statement->execute( $params );

	echo json_encode( 
		array(
			'message' => $message
		)
	);