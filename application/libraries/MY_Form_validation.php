<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	protected $CI;

	function __construct()
	{
		parent::__construct();

		$this->CI =& get_instance();

		// Load validation model
		$this->CI->load->model('validation_model');
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

		$this->CI->form_validation->set_message('pci_password', 'For PCI compliance, %s must be between 6 and 99 characters in length, must not contain two consecutively repeating characters, contain at least one upper-case letter, at least one lower-case letter, at least one number, and at least one special character');

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

		$this->CI->form_validation->set_message('unique', 'The %s that you requested is already in use.');

		return $this->CI->validation_model->is_unique($table, $column, $str);
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

		$this->CI->form_validation->set_message('unique_except', 'The %s that you requested is already in use.');

		return $this->CI->validation_model->is_unique_except($table, $column, $str, $field, $id);
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

		$this->CI->form_validation->set_message('required_if', 'The %s field is required.');

		// $fld is filled out
		if ($this->CI->input->get_post($fld))
		{
			// Must have specific value
			if ($val)
			{
				// Not the specific value we are looking for
				if ($this->CI->input->get_post($fld) == $val AND ! $str)
				{
					return FALSE;
				}
			}

			return TRUE;
		}

		return FALSE;
	}

}
