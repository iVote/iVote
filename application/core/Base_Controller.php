<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->_check_session();
	}
	
	private function _check_session()
	{
		// User Authentication Here.
	}

}

/* End of file Base_Controller.php */
/* Location: ./application/core/Base_Controller.php */