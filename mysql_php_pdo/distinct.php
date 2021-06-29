<?php
	// include global things for use
	include 'global_data.php';

	// sql string
	$sql = '
		SELECT DISTINCT
			name,
			flavor,
			size
		FROM
			drinks
		WHERE
			size = :size OR 
			flavor = :flavor
	';

	$params = array( // keys must match the variables in the sql so they can get replaced with the value
		':size' => '8oz',
		':flavor' => 'Tropical'
	);

	// prepare the sql
	$statement = $database->prepare( $sql );

	// execute the sql
	$statement->execute( $params );

	// get the query data
	$queryDrinks = $statement->fetchAll();

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
		<h1>
			<?php echo $pageTitle; // display page title ?>
		</h1>
		<hr />
		<?php displayDrinks( $allDrinks ); // display all drinks in a table ?>
		<hr />
		<div>
			<h2>
				<?php echo $sql; // display the sql statement we are running ?>
			</h2>
			<table border="1">
				<tr>
					<th>name</th>
					<th>flavor</th>
					<th>size</th>
				</tr>
				<?php foreach ( $queryDrinks as $drink ) : // loop over the data and display each row ?>
					<tr>
						<td><?php echo $drink['name']; ?></td>
						<td><?php echo $drink['flavor']; ?></td>
						<td><?php echo $drink['size']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<h2>
				PDO Debug
			</h2>
			<pre><?php $statement->debugDumpParams(); // dump out pdo params ?></pre>
			<h2>
				Results
			</h2>
			<pre><?php print_r( $drinks ); // print out the raw php result array ?></pre>
		</div>
	</body>
</html>