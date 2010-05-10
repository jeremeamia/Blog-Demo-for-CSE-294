<?php
/**
 * @author	Jeremy Lindblom
 */

// Define a constant signifying this script is being executed
define('CSEPHPBLOG', TRUE);

// Include config.php and all libraries
require 'config.php';
require LIBRARIES_DIR.'/functions.php';
require LIBRARIES_DIR.'/model.class.php';
require LIBRARIES_DIR.'/template.class.php';
require LIBRARIES_DIR.'/post.class.php';
require LIBRARIES_DIR.'/comment.class.php';

// Start the session and database
session_start();
$database = database();

// Look into the the actions directory to see what actions are available 
$valid_actions = array();
foreach (glob(ACTIONS_DIR.'/*.php') as $valid_action)
	$valid_actions[] = substr($valid_action, strpos($valid_action, '/') + 1, -4);

// Get variables from $_GET and sanitize them
$action = array_get($_GET, 'action', 'browse');
$action = in_array($action, $valid_actions) ? $action : 'browse';
$id = array_get($_GET, 'id', 0);
$id = ctype_digit($id) ? intval($id) : 0;

// Setup site template
$template = new Template('template');
$template->set('title', 'CSE 294 PHP Blog Demo'); // Should be overridden in action

// Setup page template
$page = new Template($action);

// Execute page action
require ACTIONS_DIR.'/'.$action.'.php';

// Render page
$template->set('errors', get_saved_errors());
$template->set('page', $page);
echo $template->render();

// Close database
$database->close();