<h2>Search Posts</h2>
<form method="post" action="<?php echo site_url('search'); ?>">
	<label for="search">Search Terms:</label>
	<input type="text" id="search" name="search" />
	<input type="submit" value="Search" name="search_submit" />
</form>


<?php if (count($posts)): ?>
	<h2>Search Results:</h2>
	<?php foreach ($posts as $post): ?>
		<div class="post">
			<h3><?php echo html_link($post->get('title'), 'read', $post->get('id')); ?></h3>
			<p class="meta">Posted by <?php echo $post->get('author'); ?> on <?php echo format_date($post->get('date_created')); ?>.</p>
			<?php $content = highlight($post->get('content'), $terms); ?>
			<p><?php echo strlen($content) > 250 ? substr($content, 0, strpos($content, ' ', 250)).'&hellip;' : $content; ?></p>
			<p>
				<?php echo html_link('comments', 'read', $post->get('id'), '#comments').' ('.count($post->get('comments')).')'; ?>
				<?php if (is_authenticated()): ?>
					&emsp;
					<?php echo '&#9998; '.html_link('edit post', 'edit', $post->get('id')); ?>
					&emsp;
					<?php echo '&#10008; '.html_link('delete post', 'delete', $post->get('id')); ?>
				<?php endif; ?>
			</p>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p>Sorry, there were no results for your search.</p>
<?php endif; ?>