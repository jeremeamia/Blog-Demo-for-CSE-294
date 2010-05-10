<?php if (is_null($post->get('id'))): ?>
	<p>Sorry, the post requested does not exist.</p>
<?php else: ?>
	<div class="post">
		<h2><?php echo html_link($post->get('title'), 'read', $post->get('id')); ?></h2>
		<p class="meta">Posted by <?php echo $post->get('author'); ?> on <?php echo format_date($post->get('date_created')); ?>.</p>
		<div class="content"><?php echo $post->get('content'); ?></div>
		<?php if (is_authenticated()): ?>
			<p>
				<?php echo html_link('Edit Post', 'edit', $post->get('id')); ?>
				&ensp;&middot;&ensp;
				<?php echo html_link('Delete Post', 'delete', $post->get('id')); ?>
			</p>
		<?php endif; ?>
		<?php if (count($comments) > 0): ?>
			<hr />
			<h3 id="comments">Comments (<?php echo count($comments); ?>):</h3>
			<?php foreach ($comments as $comment): ?>
				<div class="comment">
					<?php echo gravatar($comment->get('email')); ?>
					<?php $commentor = (strlen($comment->get('website')) AND @parse_url($comment->get('website'))) ? html_link($comment->get('name'), $comment->get('website')) : $comment->get('name'); ?>
					<p class="meta">Posted by <?php echo $commentor; ?> on <?php echo format_date($comment->get('date_created')); ?>.</p>
					<p><?php echo $comment->get('content'); ?></p>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<hr />
		<h3>Leave a Comment:</h3>
		<form method="post" action="<?php echo site_url('comment') ?>">
			<label for="name">Full Name:</label>
			<input type="text" id="name" name="name" />

			<label for="email">Email Address (not displayed publicly):</label>
			<input type="text" id="email" name="email" />

			<label for="website">Website (optional):</label>
			<input type="text" id="website" name="website" />

			<label for="content">Message:</label>
			<textarea id="content" name="content" cols="80" rows="4"></textarea>

			<input type="hidden" value="<?php echo $post->get('id'); ?>" name="post_id" />
			<input type="submit" value="Submit Comment" name="submit_comment" />
		</form>
	</div>
<?php endif; ?>