<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');

// Prepare info
$info = array(
	'title'			=> 'CSE 294 PHP Blog Demo',
	'link'			=> BASE_URL,
	'description'	=> 'Test blog articles demonstrating a basic blog built from scratch in PHP.',
);

// Prepare items
$items = array();
$posts = Model::factory('post')->load_all();
foreach ($posts as $post)
{
	$items[] = array(
		'title'			=> $post->get('title'),
		'link'			=> BASE_URL.'index.php?action=read&amp;id='.$post->get('id'),
		'description'	=> $post->get('content'),
		'author'		=> $post->get('author'),
		'pubDate'		=> date(DATE_RFC822, strtotime($post->get('date_created'))),
	);
}

// Create feed stub
$feed = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel></channel></rss>';
$feed = simplexml_load_string($feed);

foreach ($info as $name => $value)
{
	// Add the info to the channel
	$feed->channel->addChild($name, $value);
}

foreach ($items as $item)
{
	// Add the item to the channel
	$row = $feed->channel->addChild('item');

	foreach ($item as $name => $value)
	{
		// Add the info to the row
		$row->addChild($name, $value);
	}
}

// Render XML
echo $feed->asXML();
exit;