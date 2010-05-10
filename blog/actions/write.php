<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

if ( ! is_authenticated())
{
	add_error('You are not authorized to write blog posts. Please login.');
	redirect('login');
}

if ($_POST)
{
	$post = Model::factory('post');
	$post->set('author', array_get($_POST, 'author'));
	$post->set('title', array_get($_POST, 'title'));
	$post->set('content', trim(markdown(array_get($_POST, 'content'), 'html')));

	$array = $post->as_array();
	if (empty($array['author']) OR empty($array['title']) OR empty($array['content']))
	{
		add_error('Please fill out all of the fields when writing a new post.');
		redirect('write');
	}

	if ( ! $post->save())
	{
		add_error('Your post could not be saved.');
		redirect('write');
	}

	redirect('browse');
}