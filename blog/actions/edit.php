<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

if ( ! is_authenticated())
{
	add_error('You are not authorized to edit blog posts. Please login.');
	redirect('login');
}

$post = Model::factory('post')->load($id);
$template->set('title', 'Edit Post '.$id.' - CSE 294 PHP Blog Demo');
$page->set('post', $post);
$page->set('content', markdown($post->get('content'), 'markdown'));

if ($_POST)
{
	$post->set('author', array_get($_POST, 'author'));
	$post->set('title', array_get($_POST, 'title'));
	$post->set('content', trim(markdown(array_get($_POST, 'content'), 'html')));

	$array = $post->as_array();
	if (empty($array['author']) OR empty($array['title']) OR empty($array['content']))
	{
		add_error('All fields must be filled out.');
		redirect('edit', $id);
	}

	if ( ! $post->save())
	{
		add_error('The changes to your post could not be saved.');
		redirect('edit', $id);
	}

	redirect('browse');
}