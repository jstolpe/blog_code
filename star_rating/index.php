<!DOCTYPE html>
<html>
<head>
	<title>Star Rating System</title>
	<meta charset="utf-8" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
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
			var rating = new starRating( { // create first star rating system on page load
				containerId: 'star_rating', // element id in the dom for this star rating system to use
				starWidth: 100, // width of stars
				starHeight: 100, // height of stars
				ratingPercent: '50%', // percentage star system should start 
				canRate: true, // can the user rate this star system?
				onRate: function() { // this function runs when a star is clicked on
					console.log( rating );
					alert('You rated ' + rating.newRating + ' starts' );
				}
			} );

			var rating2 = new starRating( { // create second star rating system on page load
				containerId: 'star_rating2', // element id in the dom for this star rating system to use
				starWidth: 100, // width of stars
				starHeight: 100, // height of stars
				ratingPercent: '20%', // percentage star system should start 
				canRate: true, // can the user rate this star system?
				onRate: function() { // this function runs when a star is clicked on
					console.log( rating2 );
					alert('You rated ' + rating2.newRating + ' starts' );
				}
			} );
		} );
	</script>
</head>
<body>
	<!-- first continer element for the first star rating system-->
	<div id="star_rating">
	</div>

	<br />
	<br />

	<!-- second continer element for the first star rating system-->
	<div id="star_rating2">
	</div>
</body>
</html>
