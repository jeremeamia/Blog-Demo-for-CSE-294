<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

if ($_POST)
{
	$comment = Model::factory('comment');
	$comment->set('post_id', intval(array_get($_POST, 'post_id')));
	$comment->set('name', array_get($_POST, 'name'));
	$comment->set('email', array_get($_POST, 'email'));
	$comment->set('website', array_get($_POST, 'website'));
	$comment->set('content', array_get($_POST, 'content'));

	$array = $comment->as_array();
	if (empty($array['name']) OR empty($array['email']) OR empty($array['content']))
	{
		add_error('Please fill out all of the fields when submitting a comment.');
		redirect('read', $array['post_id']);
	}

	if ( ! $comment->save())
		add_error('Your comment could not be saved.');

	redirect('read', $array['post_id']);
}