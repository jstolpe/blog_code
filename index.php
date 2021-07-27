<?php
	// get files in the current directory
	$files = scandir( getcwd() );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Justin Stolpe's YouTube and Blog Code
		</title>

		<meta charset="utf-8">
		<meta name="title" content="Justin Stolpe's YouTube and Blog Code" />
		<meta name="description" content="This site contains the code from my YouTube and Blog tutorials." />
		<meta name="keywords" content="Programming, Coding, Developer" />
		<meta name="author" content="Justin Stolpe" />
		<meta name="robots" content="index, follow" />
	</head>
	<body>
		<h1>
			Justin Stolpe's YouTube and Blog Code
		</h1>
		<h2>
			Programming | Coding | Developer
		</h2>
		<hr />
		<h3>
			Tutorial Code
		</h3>
		<ul>
			<?php foreach ( $files as $file ) : ?>
				<?php if ( '.' != $file && '..' != $file && '.git' != $file && 'README.md' != $file && '.htaccess' != $file ) : ?>
					<li>
						<a href="<?php echo $file; ?>">
							<?php echo $file; ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<hr />
		<h3>
			Links
		</h3>
		<ul>
			<li>
				<a href="https://youtube.com/justinstolpe" target="_blank">
					YouTube
				</a>
			</li>
			<li>
				<a href="https://justinstolpe.com/blog/" target="_blank">
					Blog
				</a>
			</li>
			<li>
				<a href="https://justinstolpe.com" target="_blank">
					Justin's Website
				</a>
			</li>
			<li>
				<a href="https://github.com/jstolpe/" target="_blank">
					GitHub
				</a>
			</li>
		</ul>
	</body>
</html>