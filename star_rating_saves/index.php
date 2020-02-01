<?php
	define( 'DB_HOST', 'localhost' );
	define( 'DB_NAME', 'star_rating_saves' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASS', '' );

	try {
		$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS );
	} catch ( PDOException $e ) {
		die( $e->getMessage() );
	}

	$statement = $conn->prepare( '
		SELECT
			*
		FROM
			ratings
	' );

	$statement->setFetchMode( PDO::FETCH_ASSOC );
	$statement->execute();

	$allRatings = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Star Rating System</title>
	<meta charset="utf-8" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		var allRatings = <?php echo json_encode( $allRatings ); ?>

		// create object
		var starRating = ( function() {

			/**
			 * Constructor function
			 *
			 * @param Object args
			 *
			 * @return Object
			 */
			var starRating = function( args ) {
				// give us our self
				var self = this;

				// set global vars for our object
				self.id = args.id;
				self.container = jQuery( '#' + args.containerId );
				self.containerId = args.containerId;
				self.starClass = 'sr-star' + args.containerId;
				self.starWidth = args.starWidth;
				self.starHeight = args.starHeight;
				self.containerWidth = args.starWidth * 5;
				self.ratingPercent = args.ratingPercent;
				self.newRating = 0;
				self.canRate = args.canRate;

				// draw the 5 star rating system out to the dom
				self.draw();

				if ( self.canRate ) { // do other things if user can rate
					if ( typeof args.onRate !== 'undefined' ) { // bind custom function
						self.onRate = args.onRate;
				    }

					jQuery( '.' + self.starClass ).on( 'mouseover', function() { // mouseover a star
						// determine the percent width on mouseover of any star
						var percentWidth = 20 * jQuery( this ).data( 'stars' );

						// set the percent width  of the star bar to the new mouseover width
						$( '.sr-star-bar' + self.containerId ).css( 'width', percentWidth + '%' );
					});

					jQuery( '.' + self.starClass ).on( 'mouseout', function() { // mouseout of a star
						// return the star rating system percent to its previous percent on mouse out of any star
						jQuery( '.sr-star-bar' + self.containerId ).css( 'width', self.ratingPercent );
					});

					jQuery( '.' + self.starClass ).on( 'click', function() { // click on a star
						// ner rating set to the number of stars the user clicked on
						self.newRating = jQuery( this ).data( 'stars' );

						// determine the percent width based on the stars clicked on
						var percentWidth = 20 * jQuery( this ).data( 'stars' );

						// new rating percent is the number of stars clicked on
						self.ratingPercent = percentWidth + '%';

						// set new star bar percent width
						$( '.sr-star-bar' + self.containerId ).css( 'width', percentWidth + '%' );

						// run the on rate function passed in when the object was created
						self.onRate();
					} );	
				}
			};

			/**
			 * Draw html out to the page
			 *
			 * @param void
			 *
			 * @return void
			 */
			starRating.prototype.draw = function() {
				var self = this;
				var pointerStyle = ( self.canRate ? 'cursor:pointer' : '' );
				var starImg = '<img src="staroutline.png" style="width:' + self.starWidth + 'px" />';
				var html = '<div style="width:' + self.containerWidth + 'px;height:' + self.starHeight + 'px;position:relative;' + pointerStyle + '">';

				// create the progress bar that sits behinde the png star outlines
				html += '<div class="sr-star-bar' + self.containerId + '" style="width:' + self.ratingPercent + ';background:#FFD700;height:100%;position:absolute"></div>';

				for ( var i = 0; i < 5; i++ ) { // add each star to the page
					var currStarStyle = 'position:absolute;margin-left:' + self.starWidth * i + 'px';
					html += '<div class="' + self.starClass + '" data-stars="' + ( i + 1 ) + '" style="' + currStarStyle + '">' + 
						starImg + 
					'</div>';
				}

				html += '</div>';

				// write out to the dom
				self.container.html( html );
			};

			// return it all!
			return starRating;
		} )();

		$( function() {
			for ( var i = 0; i < allRatings.length; i++ ) {
				new starRating( { // create first star rating system on page load
					id: allRatings[i].id,
					containerId: 'star_rating' + i, // element id in the dom for this star rating system to use
					starWidth: 100, // width of stars
					starHeight: 100, // height of stars
					ratingPercent: allRatings[i].rating_percent + '%', // percentage star system should start 
					canRate: true, // can the user rate this star system?
					onRate: function() { // this function runs when a star is clicked on
						$.ajax( {
							url: 'save_rating.php',
							data: {
								id: this.id,
								stars: this.newRating
							},
							type: 'post',
							dataType: 'json',
							success: function( data ) {
								alert( data.message )
							}
						} );
					}
				} );
			}
		} );
	</script>
</head>
<body>
	<?php foreach ( $allRatings as $key => $rating ) : ?>
		<h1><?php echo $rating['name']; ?></h1>
		<div id="star_rating<?php echo $key; ?>"></div>
	<?php endforeach; ?>
</body>
</html>
