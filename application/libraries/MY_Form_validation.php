<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	protected $ci;

	function __construct()
	{
		parent::__construct();

		$this->ci =& get_instance();
	}

	// ------------------------------------------------------------------------

	/**
	 * PCI compliance password
	 *
	 * @param   $str
	 * @return  bool
	 */
	public function pci_password($str)
	{
		$special = '!@#$%*-_=+.';

		$this->ci->form_validation->set_message('pci_password', 'For PCI compliance, %s must be between 6 and 99 characters in length, must not contain two consecutively repeating characters, contain at least one upper-case letter, at least one lower-case letter, at least one number, and at least one special character ('.$special.')');

		return (preg_match('/^(?=^.{6,99}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*['.$special.'])(?!.*?(.)\1{1,})^.*$/', $str)) ? TRUE : FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Unique
	 *
	 * @access  public
	 * @param   string
	 * @param   field
	 * @return  bool
	 */
	public function unique($str, $field)
	{
		list($table, $column) = explode(',', $field, 2);

		$this->ci->form_validation->set_message('unique', 'The %s that you requested is already in use.');

		$query = $this->ci->db->query("SELECT COUNT(*) AS dupe FROM {$this->ci->db->dbprefix($table)} WHERE {$column} = '{$str}'");
		$row = $query->row();

		return ($row->dupe > 0) ? FALSE : TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Unique except id
	 *
	 * @param   string
	 * @param   field
	 * @return  bool
	 */
	public function unique_except($str, $field)
	{
		list($table, $column, $field, $id) = explode(',', $field, 4);

		$this->ci->form_validation->set_message('unique_except', 'The %s that you requested is already in use.');

		$query = $this->ci->db->query("SELECT COUNT(*) AS dupe FROM {$this->ci->db->dbprefix($table)} WHERE {$column} = '$str' AND {$field} <> {$id}");
		$row = $query->row();

		return ($row->dupe > 0) ? FALSE : TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Required if another field has a value
	 *
	 * @param   string  $str
	 * @param   string  $field
	 * @return  bool
	 */
	function required_if($str, $field)
	{
		list($fld, $val) = explode(',', $field, 2);

		$this->ci->form_validation->set_message('required_if', 'The %s field is required.');

		// $fld is filled out
		if (isset($_POST[$fld]))
		{
			// Must have specific value
			if ($val)
			{
				// Not the specific value we are looking for
				if ($_POST[$fld] == $val AND ! $str)
				{
					return FALSE;
				}
			}

			return TRUE;
		}

		return FALSE;
	}

}
