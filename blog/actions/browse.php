<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

$offset = intval(array_get($_GET, 'page', 1));
$template->set('title', 'View all posts - CSE 294 PHP Blog Demo');
$page->set('posts', Model::factory('post')->load_all('', PAGE_LIMIT, ($offset-1)*PAGE_LIMIT));

$pagination = new Template('pagination');
$pagination->set('offset', $offset);
$pagination->set('total', Model::factory('post')->count_all());

$page->set('pagination', $pagination);