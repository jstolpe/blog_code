// store current file name and split it on period
var fileName = document.location.href.match(/[^\/]+$/)[0];

$( function() { // document is ready
	$( '.sidebar-container' ).load( 'sidebar.html', function() { // load the sidebar snippet html
		// update selected nav
		$( 'a[href="' + fileName + '"] div').addClass( 'nav-selected' );

		$( '.mobile-menu' ).on( 'click', function() { // on click for mobile menu bars icon
			// toggle the navigation
			$( '.sidebar-nav-container' ).toggle();
		} );
	} );
} );