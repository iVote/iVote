<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation 
{
	private $ci;

	function MY_Form_validation( $config = array() )
	{
		$this->ci = & get_instance();

	    parent::__construct($config);
	}




    /**
	 * Check if item already exists.
	 * TO BE IMPROVED.
	 */
	public function check_if_exists($data, $arg)
	{ 
		
		// Get entity and field name.
		list($entity, $field) = explode('.', $arg);

		// Get items via name field
		$obj = $this->ci->$entity->find_by(array($field => $data), TRUE);


		// if item is found, return. [Fail Early Validation]
		if ( empty($obj) )
			return TRUE;	

/*
		// Get the data from database. This is to validate if user is editing and not adding new data.
		$name = call_user_func_array( array($obj[0], "get" . ucfirst(camelize($field))), array() );
		
		// If the user is editing(if the data from the dbase is the same with the input), return.
		if($data == $name)
			return TRUE;
*/

		//if item is not found, set error message
		$this->ci->form_validation->set_message('check_if_exists', $data . ' already exists');
		return FALSE;
	}

}