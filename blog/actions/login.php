<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

$template->set('title', 'Login - CSE 294 PHP Blog Demo');

if (is_authenticated())
{
	redirect('browse');
}

if ($_POST)
{
	$username = array_get($_POST, 'username');
	$password = array_get($_POST, 'password');

	if (login($username, $password))
	{
		redirect('browse');
	}
	else
	{
		add_error('The username or password you entered is incorrect.');
		redirect('login');
	}
}