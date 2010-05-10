<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title ?></title>
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
	</head>
	<body>
		<div class="blog">
			
			<!-- Header -->
			<h1>CSE 294 PHP Blog Demo</h1>
			
			<hr />

			<!-- Navigation -->
			<p>
				<?php if (is_authenticated()): ?>
					<?php echo html_link('view all posts', 'browse'); ?>
					&ensp;&middot;&ensp;
					<?php echo html_link('search posts', 'search'); ?>
					&ensp;&middot;&ensp;
					<?php echo html_link('write new post', 'write'); ?>
					&ensp;&middot;&ensp;
					<?php echo html_link('logout', 'logout'); ?>
				<?php else: ?>
					<?php echo html_link('view all posts', 'browse'); ?>
					&ensp;&middot;&ensp;
					<?php echo html_link('search posts', 'search'); ?>
					&ensp;&middot;&ensp;
					<?php echo html_link('login', 'login'); ?>
				<?php endif; ?>
				&ensp;&middot;&ensp;
				<?php echo html_link('<img src="rss.png" alt="RSS Feed" />', 'rss'); ?>
			</p>
			
			<hr />

			<!-- Error messages -->
			<?php if (count($errors) > 0): ?>
				<ul class="errors">
					<?php foreach ($errors as $error): ?>
						<li><?php echo $error ?></li>
					<?php endforeach; ?>
				</ul>

				<hr />
			<?php endif; ?>

			<!-- Body -->
			<?php echo $page ?>
			
			<hr />
			
			<!-- Footer -->
			<p>&copy;2010 Jeremy Lindblom. A demo project for the ASU CSE 294 class.</p>

		</div>
	</body>
</html>