<?php
	// require our config file
	require_once 'config.php';

	// require composer autoload so we can use sendgrid
	require 'vendor/autoload.php';

	// create new sendgrid mail
	$email = new \SendGrid\Mail\Mail(); 

	// specify the email/name of where the email is coming from
	$email->setFrom( FROM_EMAIL, FROM_NAME );

	// set the email subject line
	$email->setSubject( "Sending with SendGrid is Fun" );

	// specify the email/name we are sending the email to
	$email->addTo( TO_EMAIL, TO_NAME );

	// add our email body content
	$email->addContent( "text/plain", "and easy to do anywhere, even with PHP" );
	$email->addContent(
	    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
	);

	// create new sendgrid
	$sendgrid = new \SendGrid( SENDGRID_API_KEY );

	try {
		// try and send the email
	    $response = $sendgrid->send( $email );

	    // print out response data
	    print $response->statusCode() . "\n";
	    print_r( $response->headers() );
	    print $response->body() . "\n";
	} catch ( Exception $e ) {
		// something went wrong so display the error message
	    echo 'Caught exception: '. $e->getMessage() ."\n";
	}