<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');
/**
 * Site functions
 *
 * @author	Jeremy Lindblom
 */

/**
 * Gets a value from an array corresponding to a key. Returns the default value
 * if the key does not exist.
 *
 * @param	array	$array
 * @param	string	$key
 * @param	mixed	$default
 * @return	mixed
 */
function array_get(array $array, $key, $default = NULL)
{
	if (isset($array[$key]))
		return $array[$key];
	else
		return $default;
}


/**
 * Construct an absolute url pointing to an internal resource
 *
 * @param	string	$action
 * @param	string	$id
 * @return	string
 */
function site_url($action = NULL, $id = NULL)
{
	$args = array_diff(compact('action', 'id'), array(NULL));
	if (strpos($action, '://') === FALSE)
		$url = BASE_URL.(empty($args) ? '' : 'index.php?'.http_build_query($args));
	else
		$url = $action;
	return $url;
}


/**
 * Redirect the request to a different url
 *
 * @param	string	$action
 * @param	string	$id
 */
function redirect($action = NULL, $id = NULL)
{
	$url = site_url($action, $id);
	header('Location: '.$url);
	exit;
}


/**
 * Create a html <a href> to another page in the site
 *
 * @param	string	$text
 * @param	string	$action
 * @param	string	$id
 * @param	string	$extra
 * @return	string
 */
function html_link($text = '#', $action = NULL, $id = NULL, $extra = '')
{
	$url = site_url($action, $id).$extra;
	return '<a href="'.$url.'">'.$text.'</a>';
}


/**
 * Format a date string into another date string
 *
 * @param	string $date
 * @param	string $format
 * @return	string
 */
function format_date($date, $format = 'l, F jS, Y')
{
	return date($format, strtotime($date));
}


/**
 * A singleton function for fetching the database connection
 *
 * @staticvar	object	$db
 * @return		object
 */
function database()
{
	// Use a static variable to store database connection as a singleton
	static $db = NULL;

	// Create database connection if it doesn't already exist
	if (is_null($db))
	{
		$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($db->connect_error)
			throw new Exception('Connect Error ('.$db->connect_errno.') '.$db->connect_error);
	}
	
	return $db;
}


/**
 * Prepares a value for inserting into the database
 *
 * @param	mixed	$value
 * @return	mixed
 */
function db_value(& $value)
{
	if (is_null($value))
		$value = 'NULL';
	elseif ( ! is_numeric($value))
		$value = '"'.database()->real_escape_string($value).'"';

	return $value;
}


/**
 * Logs a user into the system
 *
 * @param	string	$username
 * @param	string	$password
 * @return	bool
 */
function login($username, $password)
{
	if (is_authenticated())
		return TRUE;

	if ($username == AUTH_USERNAME AND sha1($password) == AUTH_PASSWORD)
	{
		return $_SESSION['logged_in'] = TRUE;
	}

	return FALSE;
}


/**
 * Tells whether or not the user is logged in
 *
 * @return	bool
 */
function is_authenticated()
{
	return (bool) (isset($_SESSION['logged_in']) AND $_SESSION['logged_in']);
}


/**
 * Returns an array of any errors in the SESSION
 *
 * @return	array
 */
function get_saved_errors()
{
	$errors = isset($_SESSION['saved_errors']) ? $_SESSION['saved_errors'] : array();
	$_SESSION['saved_errors'] = array();
	return $errors;
}


/**
 * Adds an error to the SESSION
 *
 * @param	string	$message
 */
function add_error($message)
{
	if ( ! isset($_SESSION['saved_errors']) OR ! is_array($_SESSION['saved_errors']))
		$_SESSION['saved_errors'] = array();

	$_SESSION['saved_errors'][] = 'ERROR: '.$message;
}


/**
 * Fetches a gravatar url and return the html for the image
 *
 * @param	string	$email
 * @return	string
 */
function gravatar($email)
{
	$url = 'http://www.gravatar.com/avatar/'.md5(strtolower($email)).'.jpg';
	return '<img src="'.$url.'" class="gravatar" />';
}


/**
 * Uses the Markdown web service to either convert markdown to HTML and ther reverse.
 *
 * @param	string	$text
 * @param	string	$format
 * @return	string
 */
function markdown($text, $format = 'html')
{
	if (empty($text))
		return '';

	$args = array(
		'user' => MARKDOWN_API_USER,
		'operation' => ($format == 'markdown' ? 'markdownify' : 'markdown'),
		'content' => $text
	);

	$curl = curl_init(MARKDOWN_API_URL);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_POST, TRUE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($args));
	$result = json_decode(curl_exec($curl), TRUE);

	if (curl_errno($curl) OR $result['status'] == 'error' OR empty($result['result']))
	{
		var_dump($result);die();
		$content = '';
	}
	else
		$content = $result['result'];

	curl_close($curl);

	return $content;
}

function highlight($content, $terms)
{
	$replace = array();
	foreach ($terms as $term)
		$replace[$term] = '<b>'.$term.'</b>';
	return strtr($content, $replace);
}