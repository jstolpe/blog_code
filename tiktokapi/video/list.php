<html>
	<head>
		<title>
			Bubbles | TikTok API PHP SDK Videos
		</title>

		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

		<link rel="shortcut icon" href="../assets/favicon.ico" />

		<style>
			body {
				font-family: 'Courier New';
				background: #f0f2f5;
			}

			a {
				text-decoration: none;
			}

			#show_more_container {
				display: grid;
				width: 100%;
				gap: 20px 16px;
				grid-template-columns: repeat( auto-fill, minmax( 200px, 1fr ) );
			}

			.tiktok-card {
				box-shadow: 0 2px 4px rgba( 0, 0, 0, .1 ), 0 8px 16px rgba( 0, 0, 0, .1 );
				border-radius: 5px;
			}

			.tiktok-card img {
				width: 100%;
				display: block;
				border-top-left-radius: 5px;
				border-top-right-radius: 5px;
			}

			.tiktok-card-title {
				width: 100%;
				height: 50px;
				overflow-y: scroll;
				padding: 5px;
				box-sizing: border-box;
				font-weight: bold;
				font-size: 14px;
			}

			.tiktok-card-info {
				font-size: 12px;
				padding: 5px;
				border-top: 1px solid #e3e3e3;
			}

			.tiktok-card-actions {
				font-size: 12px;
				padding: 5px;
				border-top: 1px solid #e3e3e3;
			}

			.tiktok-button {
				background: #eb4863;
				color: #fff;
				border-radius: 5px;
				font-size: 18px;
				cursor: pointer;
				text-align: center;
				font-weight: bold;
				padding: 5px;
			}

			.tiktok-button:hover {
				background: #E61A3C;
			}

			.tiktok-button:active {
				box-shadow: inset 0 0 20px #ffffff;
			}

			#show_more_button {
				width: 100%;
				padding: 20px;
				text-align: center;
				color: rgb( 0, 102, 204 );
				cursor: pointer;
				font-weight: bold;
				box-sizing: border-box;
			}
		</style>

		<script>
			var cursor = '';

			document.addEventListener( 'DOMContentLoaded', function() { // on page load
				document.getElementById( 'show_more_button' ).addEventListener( 'click', function() {
					showMore();
				} );
			} );

			showMore();

			function showMore() {
				const xmlhttp = new XMLHttpRequest();

				xmlhttp.onload = function() {
					var resp = JSON.parse( this.responseText );

					cursor = resp.cursor;

					document.getElementById( 'show_more_container' ).insertAdjacentHTML( 'beforeend', resp.html );
				}

				xmlhttp.open( 'GET', 'list_show_more.php?cursor=' + cursor );
				xmlhttp.send();
			}
		</script>
	</head>
	<body>
		<div id="show_more_container">

		</div>
		<div id="show_more_button">
			SHOW MORE
		</div>
	</body>
</html>