<?php

$benchmark_start = microtime(TRUE);

require 'markdownify/markdownify.php';
require 'markdown/markdown.php';

$user = NULL;
$valid_users = array(
	'jeremy.lindblom@asu.edu' => md5('jeremy.lindblom@asu.edu')
);

$response = array(
	'status'	=> 'success',
	'message'	=> '',
	'result'	=> ''
);

try
{
	if ( ! $_POST)
		throw new Exception('This service only accepts post requests.');

	$user = (isset($_POST['user']) AND ! empty($_POST['user'])) ? trim($_POST['user']) : NULL;
	if ( ! in_array($user, $valid_users))
		throw new Exception('You do not have access to use this web service.');

	$operation = (isset($_POST['operation']) AND ! empty($_POST['operation'])) ? trim($_POST['operation']) : NULL;
	if ( ! in_array($operation, array('markdown', 'markdownify')))
		throw new Exception('An invalid operation was requested of this service.');

	$content = (isset($_POST['content']) AND ! empty($_POST['content'])) ? stripslashes(trim($_POST['content'])) : NULL;
	if (empty($content))
		throw new Exception('There was no content provided in which to apply this service.');

	if ($operation == 'markdown')
	{
		$response['result'] = Markdown($content);
	}
	elseif ($operation == 'markdownify')
	{
		$markdownify = new Markdownify;
		$response['result'] = $markdownify->parseString($content);
	}
	else
	{
		throw new Exception('An unknown error occured while trying to use this service.');
	}
}
catch (Exception $e)
{
	$response['status'] = 'error';
	$response['message'] = $e->getMessage(); 
}

$benchmark_finish = microtime(TRUE);
$response['benchmark'] = number_format(($benchmark_finish - $benchmark_start) * 1000, 2).' ms';
$response['timestamp'] = date('Y-m-d H:i:s');

$output = json_encode($response);

if ($fp = @fopen('markdown_service.log', 'a'))
{
	$response['user'] = array_search($user, $valid_users);
	$log = json_encode($response);
	fwrite($fp, $log."\n");
	fclose($fp);
}

echo $output;