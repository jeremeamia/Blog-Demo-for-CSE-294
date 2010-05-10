<h2>Login</h2>
<form method="post" action="<?php echo site_url('login'); ?>">
	<label for="username">Username:</label>
	<input type="text" id="username" name="username" />

	<label for="password">Password:</label>
	<input type="password" id="password" name="password" />

	<input type="submit" value="Login" name="login_button" />
</form>