<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation_model extends CI_Model {

	/**
	 * Unique value
	 *
	 * @param   string  $table
	 * @param   string  $field
	 * @param   string  $value
	 * @return  bool
	 */
	public function is_unique($table, $field, $value)
	{
		$this->db->select('*')
			->from($table)
			->where($field, $value);

		$count = $this->db->count_all_results();

		return ($count) ? FALSE : TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Check if a specific value is in use except when the value is attached to a specific row ID
	 *
	 * @param   string  $table
	 * @param   string  $field
	 * @param   string  $value
	 * @param   string  $key
	 * @param   int|string  $id
	 * @return  bool
	 */
	public function is_unique_except($table, $field, $value, $key, $id)
	{
		$this->db->select('*')
			->from($table)
			->where($field, $value)
			->where($key.' !=', $id);

		$count = $this->db->count_all_results();

		return ($count) ? FALSE : TRUE;
	}

}
// END Validation_model class

/* End of file validation_model.php */
/* Location: ./application/models/validation_model.php */