<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

$template->set('title', 'Search Posts - CSE 294 PHP Blog Demo');

$posts = array();
$terms = array();

if ($_POST)
{
	$terms = database()->real_escape_string(array_get($_POST, 'search', ''));
	$terms = array_diff(explode(' ', $terms), array(''));

	$where = '';
	foreach ($terms as $term)
	{
		$where .= 'title LIKE "%'.$term.'%" OR content LIKE "%'.$term.'%" OR ';
	}
	$where = rtrim($where, ' OR');

	$posts = Model::factory('post')->load_all($where);
}

$page->set('posts', $posts);
$page->set('terms', $terms);