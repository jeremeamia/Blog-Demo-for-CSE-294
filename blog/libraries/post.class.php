<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');
/**
 * Post Model
 *
 * @author	Jeremy Lindblom
 */
class Post extends Model {

	protected $_table_name = 'posts';
	protected $_fields = array(
		'id',
		'author',
		'title',
		'content',
		'date_created',
	);
	protected $_sorting = array('date_created' => 'DESC');

	public function save()
	{
		if ($this->is_new())
		{
			$this->set('date_created', date('Y-m-d H:i:s'));
		}

		return parent::save();
	}
	
	public function get($key)
	{
		if ($key == 'comments')
			return Model::factory('comment')->load_all('post_id = '.$this->get('id'));
		else
			return parent::get($key);
	}

}