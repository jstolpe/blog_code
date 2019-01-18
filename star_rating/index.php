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

				// set global vars
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
						var percentWidth = 20 * jQuery( this ).data( 'stars' );
						$( '.sr-star-bar' + self.containerId ).css( 'width', percentWidth + '%' );
					});

					jQuery( '.' + self.starClass ).on( 'mouseout', function() { // mouseout of a star
						jQuery( '.sr-star-bar' + self.containerId ).css( 'width', self.ratingPercent );
					});

					jQuery( '.' + self.starClass ).on( 'click', function() { // click on a star
						self.newRating = jQuery( this ).data( 'stars' );
						var percentWidth = 20 * jQuery( this ).data( 'stars' );
						self.ratingPercent = percentWidth + '%';
						$( '.sr-star-bar' + self.containerId ).css( 'width', percentWidth + '%' );
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
			var rating = new starRating( {
				containerId: 'star_rating',
				starWidth: 100,
				starHeight: 100,
				ratingPercent: '50%',
				canRate: true,
				onRate: function() {
					console.log( rating );
					alert('You rated ' + rating.newRating + ' starts' );
				}
			} );

			var rating2 = new starRating( {
				containerId: 'star_rating2',
				starWidth: 100,
				starHeight: 100,
				ratingPercent: '20%',
				canRate: true,
				onRate: function() {
					console.log( rating2 );
					alert('You rated ' + rating2.newRating + ' starts' );
				}
			} );
		} );
	</script>
</head>
<body>
	<div id="star_rating">
	</div>

	<br />
	<br />

	<div id="star_rating2">
	</div>
</body>
</html>
