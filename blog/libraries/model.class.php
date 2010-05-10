<?php defined('CSEPHPBLOG') OR die('You cannot execute this script.');
/**
 * Model class
 *
 * @author	Jeremy Lindblom
 */
abstract class Model {

	protected $_properties = array();
	protected $_changed = array();

	protected $_table_name = NULL;
	protected $_fields = array();
	protected $_sorting = array();

	public function factory($class)
	{
		$class = ucfirst($class);
		return new $class;
	}

	protected function __construct()
	{
		foreach ($this->_fields as $field)
			$this->_properties[$field] = NULL;
	}

	public function is_loaded()
	{
		return (bool) count(array_diff($this->_properties, array(NULL)));
	}

	public function is_new()
	{
		return (bool) is_null($this->_properties['id']);
	}

	public function load($id)
	{
		$id = is_numeric($id) ? intval($id) : 0;
		$sql = 'SELECT * FROM '.$this->_table_name.' WHERE id = '.$id;
		$result = database()->query($sql)->fetch_assoc();
		$result = $result ? $result : array();
		return $this->set($result, TRUE);
	}

	public function count_all($where = '')
	{
		return count($this->load_all($where));
	}

	public function load_all($where = '', $limit = NULL, $offset = 0)
	{
		$class = get_class($this);
		$objects = array();

		// Begin building query
		$sql = 'SELECT * FROM '.$this->_table_name;
		
		// Add WHERE
		if ( ! empty($where))
		{
			$sql .= ' WHERE '.$where;
		}

		// Add ORDER BY
		if ( ! empty($this->_sorting))
		{
			$sql .= ' ORDER BY';
			foreach ($this->_sorting as $field => $direction)
			{
				$sql .= ' '.$field.' '.$direction.',';
			}
			$sql = rtrim($sql, ',');
		}

		// Add LIMIT
		if (is_numeric($limit) AND is_numeric($offset))
		{
			$sql .= ' LIMIT '.$offset.', '.$limit;
		}

		// Execute SELECT query and fetch results
		$results = database()->query($sql);
		if ($results->num_rows > 0)
		{
			while ($result = $results->fetch_assoc())
			{
				$object = new $class;
				$object->set($result, TRUE);
				$objects[] = $object;
			}
		}
		$results->close();
		return $objects;
	}

	public function set($key, $value)
	{
		if (is_array($key) AND $value === TRUE)
		{
			$this->_properties = array_merge($this->_properties, $key);
		}
		elseif (array_key_exists($key, $this->_properties) AND $key != 'id')
		{
			$this->_properties[$key] = $value;
			$this->_changed[] = $key;
		}
		else
			throw new Exception('The property "'.$key.'" does not exist in table "'.$this->_table_name.'".');

		return $this;
	}

	public function get($key)
	{
		if (array_key_exists($key, $this->_properties))
		{
			if (is_string($this->_properties[$key]))
				return stripslashes($this->_properties[$key]);
			else
				return $this->_properties[$key];
		}
		else
			throw new Exception('The property "'.$key.'" does not exist in table "'.$this->_table_name.'".');
	}

	public function save()
	{
		if ($this->is_new())
		{
			// If the record is new, insert the record

			// Prepare the properties array
			$properties = $this->_properties;
			array_walk($properties, 'db_value');

			// Build the INSERT query
			$sql = 'INSERT INTO '.$this->_table_name.' ('
			     .implode(', ', array_keys($properties)).') VALUES ('
			     .implode(', ', array_values($properties)).')';

			// Execute the query
			$result = database()->query($sql);

			if ($result)
			{
				$this->_properties['id'] = database()->insert_id;
			}

			// Return success/failure
			return (bool) $result;

		}
		elseif ( ! empty($this->_changed))
		{
			// If it is not new, but has been changed, update the record

			// Make sure items in changes array are unique
			$this->_changed = array_unique($this->_changed);

			// Build the UPDATE query
			$sql = 'UPDATE '.$this->_table_name.' SET';
			foreach ($this->_changed as $key)
			{
				$sql .= ' '.$key.' = '.db_value($this->_properties[$key]).',';
			}
			$sql = rtrim($sql, ', ').' WHERE id = '.$this->_properties['id'];

			// Clear the changes array
			$this->_changed = array();

			// Execute the query
			$result = database()->query($sql);

			// Return success/failure
			return (bool) $result;
		}
		else
		{
			return TRUE;
		}
	}

	public function delete()
	{
		$sql = 'DELETE FROM '.$this->_table_name.' WHERE id = '.$this->_properties['id'];
		return (bool) database()->query($sql);
	}

	public function as_array()
	{
		return $this->_properties;
	}

}