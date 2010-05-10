<h2>Write a New Post</h2>
<form method="post" action="<?php echo site_url('write') ?>">
	<label for="author">Author:</label>
	<input type="text" id="author" name="author" />

	<label for="title">Title:</label>
	<input type="text" id="title" name="title" />

	<label for="content">Post Content:</label>
	<textarea id="content" name="content" cols="80" rows="10"></textarea>

	<input type="submit" value="Submit Post" name="submit_post" />
</form>