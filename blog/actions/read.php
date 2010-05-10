<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

$post = Model::factory('post')->load($id);
$page->set('post', $post);
if ( ! $post->is_loaded())
{
	add_error('Could not find blog post '.$id.'.');
	redirect('browse');
}
$page->set('comments', $post->get('comments'));
$template->set('title', $post->get('title').' - CSE 294 PHP Blog Demo');