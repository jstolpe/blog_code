<?php
	include 'functions.php';

	$accessToken = generateAccessToken();

	echo '<pre>';
	print_r( $accessToken );
	die();