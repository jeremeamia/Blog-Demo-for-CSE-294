<h2>Edit Post #<?php echo $post->get('id'); ?></h2>
<form method="post" action="<?php echo site_url('edit', $post->get('id')) ?>">
	<label for="author">Author:</label>
	<input type="text" id="author" name="author" value="<?php echo $post->get('author'); ?>" />

	<label for="title">Title:</label>
	<input type="text" id="title" name="title" value="<?php echo $post->get('title'); ?>" />

	<label for="content">Post Content:</label>
	<textarea id="content" name="content" cols="80" rows="10"><?php echo $content; ?></textarea>

	<input type="submit" value="Save Changes" name="submit_post" />
</form>