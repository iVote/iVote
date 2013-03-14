<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends MY_Model {


	public function __construct()
	{
		parent::__construct();
	
		// Initialize Doctrine in the Parent Class.
		$this->init($this->doctrine->em);

	}


	public function submit($data)
	{
		// Check if we can see an entry from the database
		$item = $this->find_by( array("title" => $data["title"]), FALSE);

		if (! empty($item)) {

			$this->save( array("id" => $item[0]->getId(), "limitation" => $data["limitation"], "is_active" => TRUE) );

		} 

		else {

			$this->save($data);

		}

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