<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

if ( ! is_authenticated())
{
	add_error('You are not authorized to delete blog posts. Please login.');
	redirect('login');
}

$post = Model::factory('post')->load($id);
$template->set('title', 'Delete Post '.$id.' - CSE 294 PHP Blog Demo');
$page->set('post', $post);

if (isset($_POST['submit_delete']))
{
	if ( ! $post->delete())
	{
		add_error('The post could not be deleted.');
	}

	redirect('browse');
}
elseif (isset($_POST['submit_cancel']))
{
	redirect('browse');
}