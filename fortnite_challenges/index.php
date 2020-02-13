<?php
	include 'functions.php';

	$challenges = getChalleges();

	// echo '<pre>';
	// print_r( $challenges );
	// die();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Fortnite Current Active Challenges</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style>
			@font-face {
				font-family: 'Fortnite';
				src: url( 'BurbankBigCondensed-Bold.otf' );
			}

			body {
				font-family: 'Fortnite';
				background: #1e1e1e;
				color: #fff;
				padding: 10px;
			}
		</style>
	</head>
	<body>
		<div style="margin-bottom:20px;font-size:48px">
			<div style="text-transform: uppercase">Fortnite Current Active Challenges</div>
		</div>
		<div style="width:100%;color:#000;background:#f1ed62;font-size:26px;display:inline-block">
			<div style="padding:5px">
				<div style="float:left">CHALLEGES</div>
			</div>
		</div>
		<ul style="list-style: none;padding:0px;margin:0px;margin:0px;margin-bottom:20px">
			<?php foreach ( $challenges['items'] as $challenge ) : ?>
				<li style="border:3px solid #363636;padding:10px;margin-top:20px">
					<div style="display:inline-block;width:100%;">
						<?php foreach ( $challenge['metadata'] as $data ) : ?>
							<?php if ( 'rewardPictureUrl' == $data['key'] ) : ?>
								<div style="display:inline-block;float:left">
									<img style="display:block;width:50px" src="<?php echo $data['value']; ?>" />
								</div>
							<?php elseif ( 'name' == $data['key'] ) : ?>
								<div style="font-size:30px;display:inline-block;margin-left:20px;width:calc(100%-100px)">
									<?php echo $data['value']; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</body>
</html>