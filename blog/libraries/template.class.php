<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');
/**
 * Template class
 *
 * @author	Jeremy Lindblom
 */
class Template {

	protected $_data = array();
	protected $_file = NULL;

	public function __construct($file)
	{
		$filepath = TEMPLATES_DIR.'/'.$file.'.php';
		$this->_file = $filepath;
	}

	public function set($key, $value)
	{
		$this->_data[$key] = $value;
		return $this;
	}

	public function render()
	{
		ob_start();
		extract($this->_data);
		if ( ! file_exists($this->_file))
			throw new Exception('The template file "'.$this->_file.'" does not exist.');
		include $this->_file;
		return ob_get_clean();
	}

	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

}