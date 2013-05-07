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


	/**
	 * Validation method.
	 * Put all customize validation method here.
	 * @param  [type] $data [description] post data
	 */
	public function validate($data)
	{
		/* -------------- Start of Check if exists -------------- */
			/* -------------- TO BE IMPROVED!! -------------- */

		// Variable to be use as flag if 'check_if_exists' validation will run.
		$use = TRUE;

		/**
		 * if Id is found, meaning the user is editing.
		 * Get the data via id field.
		 */
		if( isset($data['id']) ) $group = $this->find_by(array("id" => $data['id']));

		// If user is editing, and input data is the same data found in dbase, set flag as FALSE.
		if(! empty($group) && $data['name'] == $group->getName())
			$use = FALSE;

		/**
		 * If flag is set to FALSE, don't run 'check_if_exists' method.
		 * If name already exists, set custom error.
		 */
		if(!$this->check_if_exists(array('name' => $data['name']), $use))
			$this->form_validation->set_error('name', $data['name'] .' already exists');
		

		/* -------------- End of Check if exists -------------- */


		// Run Form validation.
		if(! $this->form_validation->run('groups', TRUE) )
			return FALSE;


		return TRUE;

	}

}

/* End of file group.php */
/* Location: ./application/models/group.php */