<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Model {


	public function __construct()
	{
		parent::__construct();
	
		// Initialize Doctrine in the Parent Class.
		$this->init($this->doctrine->em);

		// Defining that $this entity has associate entity
		$this->BASE_HAS_ASSOCIATE = TRUE;

		// Set the associate entity
		$this->BASE_ASSOCIATE_ENTITY = "groups";
	}


	public function submit($data)
	{
		$this->load->model("Group");

		// Check if we can see an entry from the database
		$item = $this->find_by( array("name" => $data["name"]), FALSE);

		if (!empty($item)) {
			// pass the existing id to $data array
			$data["id"] = $item[0]->getId();

		} 

		if (! empty($data["groups"])) {
			
			foreach ($data["groups"] as $key => $value) {

				$groups[] = $this->Group->find_by( array("id" => $value));

			}

			$data["groups"] = $groups;

		}

		$data["is_active"] = TRUE;

		$this->save($data);

	}



	/**
	 * Used for bootstrapping / seeding database data
	 * @return [type] [description]
	 */
	public function bootstrap()
	{
		$bootstrap = array();

		foreach ($bootstrap as $key => $value) {

			$member = new $this->_ENTITY_MODEL;

			$member->setName($value["name"]);
			$member->setShortDescription($value["limitation"]);

			$this->doctrine->em->persist($member);

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