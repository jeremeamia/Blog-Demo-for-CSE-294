<h2>Delete Post #<?php echo $post->get('id'); ?></h2>
<p>Are you sure you want to delete this post?</p>
<form method="post" action="<?php echo site_url('delete', $post->get('id')) ?>">
	<input type="submit" value="Delete the Post" name="submit_delete" />
	<input type="submit" value="Cancel the Deletion" name="submit_cancel" />
</form>