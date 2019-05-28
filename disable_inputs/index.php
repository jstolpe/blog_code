<!DOCTYPE html>
<html>
	<head>
		<title>Disable Inputs</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			$( function() { // jquery document ready function
				$( '#first_jquery_checkbox' ).on( 'click', function() { // do things when the checkbox gets clicked
					if ( this.checked ) { // check box is checked so disable input and select
						$( '#first_jquery_select' ).prop( 'disabled', 'disabled' );
						$( '#first_jquery_input' ).prop( 'disabled', 'disabled' );
					} else { // checkbox is not checked, make input and select editable
						$( '#first_jquery_select' ).prop( 'disabled', '' );
						$( '#first_jquery_input' ).prop( 'disabled', '' );
					}
				} )	
			} );
		</script>
	</head>
	<body>
		<h1>Disable Inputs</h1>
		<hr />

		<h3>Using HTML</h3>
		<input type="checkbox" id="first_checkbox" disabled="disabled" checked="checked"/> <label for="first_checkbox">Disable section</label>
		<br />
		<br />
		<input type="text" placeholder="first input value" value="one" disabled="disabled" />
		<br />
		<br />
		<select disabled="disabled">
			<option>Option 1</option>
			<option>Option 2</option>
		</select>

		<h3>Using JavaScript</h3>
		<input type="checkbox" id="first_javascript_checkbox" /> <label for="first_javascript_checkbox">Disable section</label>
		<br />
		<br />
		<input type="text" id="first_javascript_input" placeholder="javascript input value" value="javascript" />
		<br />
		<br />
		<select id="first_javascript_select">
			<option>Option 1</option>
			<option>Option 2</option>
		</select>

		<h3>Using jQuery</h3>
		<input type="checkbox" id="first_jquery_checkbox" /> <label for="first_jquery_checkbox">Disable section</label>
		<br />
		<br />
		<input type="text" id="first_jquery_input" placeholder="jquery input value" value="jquery" />
		<br />
		<br />
		<select id="first_jquery_select">
			<option>Option 1</option>
			<option>Option 2</option>
		</select>

		<script type="text/javascript">
			( function() { // javascript document ready function
				var firstJavaScriptInput = document.getElementById( 'first_javascript_input' );
				var firstJavaScriptCheckbox = document.getElementById( 'first_javascript_checkbox' );
				var firstJavaScriptSelect = document.getElementById( 'first_javascript_select' );
				
				firstJavaScriptCheckbox.addEventListener( 'click', function() { // do things when the checkbox gets clicked
					if ( this.checked ) { // check box is checked so disable input and select
						firstJavaScriptSelect.disabled = 'disabled';
						firstJavaScriptInput.disabled = 'disabled';
					} else { // checkbox is not checked, make input and select editable
						firstJavaScriptSelect.disabled = '';
						firstJavaScriptInput.disabled = '';
					}
 				} );
			} )();
		</script>
	</body>
</html>