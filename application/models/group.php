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

	public function submit($data)
	{

		$this->form_validation->set_rules('name', 'Name', 'check_if_exists[Group.name]');
		if(! $this->form_validation->run('groups', TRUE) )
			return FALSE;

		// Check if we can see an entry from the database
		$item = $this->find_by( array("name" => $data["name"]), FALSE);

		if (!empty($item)) {
			// Add id / primary key to the array
			$data["id"] = $item[0]->getId();

		} 

		$data["is_active"] = TRUE;

		$this->save($data);

		return TRUE;
	}

}

/* End of file group.php */
/* Location: ./application/models/group.php */