<!DOCTYPE html>
<html>
	<head>
		<title>3D CSS Button with HTML, CSS, and JavaScript</title>
		<meta name="viewport" content="width=device-width,user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<style>
			html {
				-webkit-tap-highlight-color: transparent;
			}

			.no-highlight {
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}

			.the-button-container {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate( -50%, -50% );
			}

			.the-button-main {
				color: #fff;
				font-family: Helvetica, sans-serif;
				font-weight: bold;
				font-size: 36px;
				text-align: center;
				background-color: #f70d1a;
				position: relative;
				padding: 20px 20px;
				text-shadow: 0px 3px 0px #000;
				box-shadow: inset 0 1px 0 #f70d1a, 0 10px 0 #c90711;
				border-radius: 10px;
			}

			.the-button-base {
				height: 100%;
				width: 100%;
				padding: 5px;
				position: absolute;
				bottom: -16px;
				left: -5px;
				z-index: -1;
				background-color: #2B1800;
				border-radius: 10px;
				box-shadow: 0 0 15px #000;
			}

			/*.the-button-main:active {*/
			.the-button-main-active {
				text-shadow: 0px 1px 0px #000;
				top: 10px;
				box-shadow: inset 0 0 5px #FFE5C4;
				background-color: #f94c56;
			}

			.the-button:hover {
				cursor: pointer;
			}
		</style>
		<script>
			var onButtonDown = function( event ) {
				this.children[0].classList.add( 'the-button-main-active');
			};

			var onButtonUp = function( event ) {
				this.children[0].classList.remove( 'the-button-main-active');
			};

			document.addEventListener( 'DOMContentLoaded', function( event ) {
				var buttons = document.getElementsByClassName( 'the-button' );

				for ( var i = 0; i < buttons.length; i++ ) {
					buttons[i].addEventListener( 'mousedown', onButtonDown );

					buttons[i].addEventListener( 'touchstart', onButtonDown );

					buttons[i].addEventListener( 'mouseup', onButtonUp );

					buttons[i].addEventListener( 'touchend', onButtonUp );
				}
			} );
		</script>
	</head>
	<body>
		<div class="the-button-container no-highlight">
			<div class="the-button">
				<div class="the-button-main">
					PUSH
				</div>
			</div>
			<div class="the-button-base">

			</div>
		</div>
	</body>
</html>