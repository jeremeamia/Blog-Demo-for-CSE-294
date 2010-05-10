<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');
/**
 * Comment Model
 *
 * @author	Jeremy Lindblom
 */
class Comment extends Model {

	protected $_table_name = 'comments';
	protected $_fields = array(
		'id',
		'post_id',
		'name',
		'email',
		'website',
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
		if ($key == 'post')
			return Model::factory('post')->load($this->get('post_id'));
		else
			return parent::get($key);
	}

}