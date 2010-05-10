<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

$template->set('title', 'Logout - CSE 294 PHP Blog Demo');

if (is_authenticated())
{
	session_destroy();
	redirect('logout');
}