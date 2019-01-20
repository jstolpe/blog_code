<?php
	// get our functions so we can use them!
	require_once( 'functions.php' );

	// validate and get date
	$date = getStoreDate();

	// get the items sorted
	$storeData = getStoreSortedData( $date );

	// get all shop files
	$shopFiles = getStoreJsonFiles();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Fortnite Item Shop</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style>
			@font-face {
			  	font-family: 'Fortnite';
			  	src: url( 'BurbankBigCondensed-Bold.otf' );
			}

			.rarity-fine {
				background: #fb9625;
			}

			.rarity-quality {
				background: #7907a5;
			}

			.rarity-sturdy {
				background: #3dc7ff;
			}

			.rarity-handmade {
				background: #5bad03;
			}

			a {
				color: #e3e3e3;
			}
		</style>
	</head>
	<body style="font-family:'Fortnite';background: #1e1e1e;color:#fff;padding:10px;">
		<div style="margin-bottom:20px;font-size:48px">
			<div>FORTNITE ITEM SHOP</div>
			<div style="font-size:28px;">Items Refresh on <?php echo date( 'M, jS', strtotime( $date ) ); ?> at 6pm CST</div>
		</div>
		<?php foreach ( $storeData as $section ) : ?>
			<div style="width:100%;color:#000;background:#f1ed62;font-size:26px;display:inline-block">
				<div style="padding:5px">
					<div style="float:left"><?php echo $section['info']['title']; ?></div>
				</div>
			</div>
			<div style="margin-bottom: 20px">
				<ul style="list-style: none;margin: 0;text-align:center">
					<?php foreach ( $section['items'] as $item ) : ?>
						<li class="rarity-<?php echo strtolower( $item['rarity'] ); ?>" style="border:3px solid #ffffff;display:inline-block;max-width:200px;margin-top:20px;margin-right:20px">
							<a target="_blank" href="<?php echo $item['link_to_fn_item']; ?>">
								<div style="position:relative">
									<div style="position:absolute;background: rgba(0,0,0,0.5);bottom:0;width:100%">
										<div style="padding:5px">
											<div style="float:left;font-size:20px;width:100%">
												<div><?php echo $item['name']; ?></div>
												<div style="font-size:16px"><?php echo number_format( $item['vBucks'] ); ?> v-bucks</div>
											</div>
										</div>
									</div>
									<img style="width:100%;display:block" src="<?php echo $item['imageUrl']; ?>" />
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endforeach; ?>
		<div style="border-bottom: 3px solid #ffffff"></div>
		<div style="margin-bottom:20px;font-size:48px;margin-top: 20px">
			PAST ITEM SHOPS
		</div>
		<?php foreach ( $shopFiles as $file ) : ?>
			<div>
				<div style="width:100%;color:#000;background:#f1ed62;font-size:26px;display:inline-block">
					<div style="padding:5px">
						<div style="float:left">ITEM SHOP <?php echo $file['date']; ?></div>
					</div>
				</div>
				<ul>
					<li><div style="font-size:20px"><a target="_blank" href="<?php echo $file['link_store']; ?>">FORTNITE STORE</a></div></li>
					<li><div style="font-size:20px"><a target="_blank" href="<?php echo $file['link_json']; ?>">RAW JSON</a></div></li>
				</ul>
			</div>
		<?php endforeach; ?>
	</body>
</html>