<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Model {

	public function __construct()
	{
		parent::__construct();

		$this->init($this->doctrine->em);
	}

	public function get_group_ids($obj)
	{
		$items = array();
		
		foreach ($obj->getGroups() as $key => $value) {
			$items[] = $value->getId();
		}	

		return $items;
	}

}

/* End of file group.php */
/* Location: ./application/models/group.php */