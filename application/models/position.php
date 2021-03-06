<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends MY_Model {

	// Set the associate table
	protected $has_many = "groups";


	public function __construct()
	{
		parent::__construct();
	
		// Initialize Doctrine in the Parent Class.
		$this->init($this->doctrine->em);
	}


	public function submit($data)
	{
		$this->load->model("Group");

		// Check if we can see an entry from the database
		$item = $this->find_by( array("title" => $data["title"]), FALSE);

		if (!empty($item)) {
			// Merge is_group_dependent condition to the base array.
			$data["id"] = $item[0]->getId();

		} 
		
		$data["is_group_dependent"] =  (int) FALSE;

		if (! empty($data["groups"])) {
			
			foreach ($data["groups"] as $key => $value) {

				$groups[] = $this->Group->find_by( array("id" => $value));

			}

			$data["groups"] = $groups;

			$data["is_group_dependent"] =  TRUE;

		}

		$data["is_active"] = TRUE;

		$this->save($data);

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
		if( isset($data['id']) ) $position = $this->find_by(array("id" => $data['id']));

		// If user is editing, and input data is the same data found in dbase, set flag as FALSE.
		if( !empty($position) && $data['title'] == $position->getTitle())
			$use = FALSE;

		/**
		 * If flag is set to FALSE, don't run 'check_if_exists' method.
		 * If name already exists, set custom error.
		 */
		if(!$this->check_if_exists(array('title' => $data['title']), $use))
			$this->form_validation->set_error('title', $data['title'] .' already exists');
		

		/* -------------- End of Check if exists -------------- */


		// Run Form validation.
		if(! $this->form_validation->run('positions', TRUE) )
			return FALSE;


		return TRUE;

	}



	/**
	 * Used for bootstrapping / seeding database data
	 * @return [type] [description]
	 */
	public function bootstrap()
	{
		$bootstrap = array(

			array("title" => "President", "limitation" => 1),
			array("title" => "Vice President", "limitation" => 2),
			array("title" => "Senators", "limitation" => 13),
			array("title" => "Congressmen", "limitation" => 15),
			array("title" => "Board of Directors", "limitation" => 20)

		);

		foreach ($bootstrap as $key => $value) {

			$position = new $this->_ENTITY_MODEL;

			$position->setTitle($value["title"]);
			$position->setLimitation($value["limitation"]);

			$this->doctrine->em->persist($position);

		}

		try {

			$this->doctrine->em->flush();

			return TRUE;

		} catch (Exception $e) {

			return FALSE;

		}
	}

}

/* End of file position.php */
/* Location: ./application/models/position.php */