<?php
	require_once 'config.php';
	require 'vendor/autoload.php';

	$email = new \SendGrid\Mail\Mail(); 
	$email->setFrom( FROM_EMAIL, FROM_NAME );
	$email->setSubject( "Sending with SendGrid is Fun" );
	$email->addTo( TO_EMAIL, TO_NAME );
	$email->addContent( "text/plain", "and easy to do anywhere, even with PHP" );
	$email->addContent(
	    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
	);
	$sendgrid = new \SendGrid( SENDGRID_API_KEY );

	try {
	    $response = $sendgrid->send( $email );
	    print $response->statusCode() . "\n";
	    print_r( $response->headers() );
	    print $response->body() . "\n";
	} catch ( Exception $e ) {
	    echo 'Caught exception: '. $e->getMessage() ."\n";
	}