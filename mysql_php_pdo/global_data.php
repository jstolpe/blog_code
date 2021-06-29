<?php
	// global defines
	define( 'DB_HOST', '<DATABASE-HOST>' );
	define( 'DB_USERNAME', '<DATABASE-USERNAME>' );
	define( 'DB_PASSWORD', '<DATABASE-PASSWORD>' );
	define( 'DB_NAME', '<DATABASE-NAME>' );

	// get connection to database
	$database = getDatabase();

	// get all table data
	$allDrinks = getAllDrinks( $database );

	/**
	 * Get PDO database connection.
	 *
	 * @return object
	 */
	function getDatabase() {
		// PDO data source name
		$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

		$options = array( // PDO options we want to return a nice associative array where the keys are the column names
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		);

		try { // try hard
			// return the database connection
			return new PDO( $dsn, DB_USERNAME, DB_PASSWORD, $options );
		} catch ( PDOException $e ) { // yikes
			// die and print out the error
			die( $e->getMessage() );
		}
	}

	/**
	 * Select all data from the drinks table.
	 *
	 * @param object $database
	 * @return array
	 */
	function getAllDrinks( $database ) {
		// SELECT ALL from drinks table
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

		// return the query data
		return $statement->fetchAll();
	}

	/**
	 * Display view html.
	 *
	 * @param string $sql         sql string with values replaced with variables
	 * @param string $pageTitle   title for the page
	 * @param string $allDrinks   all the data in the drinks table
	 * @param string $queryDrinks drinks retured from the query to the database
	 * @param string $statement   pdo object
	 * @return void
	 */
	function displayViewHtml( $sql, $allDrinks, $queryDrinks, $statement ) {
		// generate page title
		$pageTitle = 'MySQL SELECT ' . strtoupper( pathinfo( $_SERVER['SCRIPT_FILENAME'], PATHINFO_FILENAME ) ) . ' | PHP Tutorial | PDO Tutorial';
		?>
			<!DOCTYPE html>
			<html>
				<head>
					<title>
						<?php echo $pageTitle; // display page title ?>
					</title>
				</head>
				<body>
					<?php displayNavBar(); // display the navigation bar ?>
					<h2>
						<?php echo $pageTitle; // display page title ?>
					</h2>
					<hr />
					<?php displayDrinks( $allDrinks ); // display all drinks in a table ?>
					<hr />
					<div>
						<h2>
							<?php echo $sql; // display the sql statement we are running ?>
						</h2>
						<?php displayDrinks( $queryDrinks ); // display query drinks in a table ?>
						<h2>
							PDO Debug
						</h2>
						<pre><?php $statement->debugDumpParams(); // dump out pdo params ?></pre>
						<h2>
							Results
						</h2>
						<pre><?php print_r( $queryDrinks ); // print out the raw php result array ?></pre>
					</div>
				</body>
			</html>
		<?php
	}

	/**
	 * Display table data in an html table.
	 *
	 * @param array drinks for display in the table
	 * @return object
	 */
	function displayDrinks( $drinks ) {
		?>
			<table border="1">
				<tr>
					<th>id</th>
					<th>name</th>
					<th>type</th>
					<th>flavor</th>
					<th>sugar_free</th>
					<th>size</th>
					<th>expiration_date</th>
				</tr>
				<?php foreach ( $drinks as $drink ) : // loop over the data and display each row ?>
					<tr>
						<td><?php echo $drink['id']; ?></td>
						<td><?php echo $drink['name']; ?></td>
						<td><?php echo $drink['type']; ?></td>
						<td><?php echo $drink['flavor']; ?></td>
						<td><?php echo $drink['sugar_free']; ?></td>
						<td><?php echo $drink['size']; ?></td>
						<td><?php echo $drink['expiration_date']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<br />
		<?php 
	}

	/**
	 * Display html nav bar
	 *
	 * @return void
	 */
	function displayNavBar() {
		?>
			<table>
				<tr>
					<td>
						<a href="index.php">
							SELECT ALL
						</a>	
					</td>
					<td>
						<a href="where.php">
							WHERE
						</a>	
					</td>
					<td>
						<a href="and.php">
							AND
						</a>	
					</td>
					<td>
						<a href="or.php">
							OR
						</a>	
					</td>
					<td>
						<a href="in.php">
							IN
						</a>	
					</td>
				</tr>
				<tr>
					<td>
						<a href="in.php?filter=NOTIN">
							NOT IN
						</a>	
					</td>
					<td>
						<a href="distinct.php">
							DISTINCT
						</a>	
					</td>
					<td>
						<a href="between.php">
							BETWEEN
						</a>	
					</td>
					<td>
						<a href="between.php?filter=NOTBETWEEN">
							NOT BETWEEN
						</a>	
					</td>
					<td>
						<a href="like.php">
							LIKE
						</a>	
					</td>
				</tr>
				<tr>
					<td>
						<a href="like.php?filter=LIKEEND">
							LIKE END
						</a>	
					</td>
					<td>
						<a href="like.php?filter=LIKESTART">
							LIKE START
						</a>	
					</td>
					<td>
						<a href="like.php?filter=NOTLIKESTART">
							NOT LIKE START
						</a>	
					</td>
					<td>
						<a href="order_by.php">
							ORDER BY ASC
						</a>	
					</td>
					<td>
						<a href="order_by.php?filter=ORDERBYDESC">
							ORDER BY DESC
						</a>	
					</td>
				</tr>
				<tr>
					<td>
						<a href="limit.php">
							LIMIT
						</a>	
					</td>
					<td>
						<a href="limit.php?filter=LIMITOFFSET">
							LIMIT OFFSET
						</a>	
					</td>
				</tr>
			</table>
			<hr />
		<?php
	}
?>