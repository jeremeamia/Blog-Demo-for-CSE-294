<?php if (count($posts)): ?>
	<?php echo $pagination; ?>
	<hr />
	<?php foreach ($posts as $post): ?>
		<div class="post">
			<h2><?php echo html_link($post->get('title'), 'read', $post->get('id')); ?></h2>
			<p class="meta">Posted by <?php echo $post->get('author'); ?> on <?php echo format_date($post->get('date_created')); ?>.</p>
			<div class="content"><?php echo $post->get('content'); ?></div>
			<p>
				<?php echo html_link('comments', 'read', $post->get('id'), '#comments').' ('.count($post->get('comments')).')'; ?>
				<?php if (is_authenticated()): ?>
					&emsp;
					<?php echo html_link('edit post', 'edit', $post->get('id')); ?>
					&emsp;
					<?php echo html_link('delete post', 'delete', $post->get('id')); ?>
				<?php endif; ?>
			</p>
		</div>
		<hr />
	<?php endforeach; ?>
	<?php echo $pagination; ?>
<?php else: ?>
	<p>Sorry, there are no posts in this blog.</p>
<?php endif; ?>