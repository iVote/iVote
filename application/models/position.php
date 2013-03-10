<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends CI_Model {

	// Entity Used for this Model
	const ENTITY_MODEL   = "Entities\Position";

	// Default value for isActive field;
	const DEFAULT_STATUS = 1;

	// Private variable that holds the shortening of EntityManager call
	private $_em;

	// Default isActive status set in array() for querying.
	private $_DEFAULT_STATUS = array();





	public function __construct()
	{
		parent::__construct();

		// Shortening the EntityManager Call
		// Doctrine ORM Function
		$this->_em = $this->doctrine->em->getRepository(self::ENTITY_MODEL);
		
		// Setup default isActive status
		$this->_DEFAULT_STATUS = array('isActive' => self::DEFAULT_STATUS);
	}






	/**
	 * Save data to database. TOOOOOOOOOOOOOOOOOOOOO DRY.
	 * @param  array  $data [description]
	 * @return boolean       TRUE if successful, FALSE, if theres on error on given condition.
	 */
	public function save($data = array())
	{
		// Fail Early validation of array. 
		// Removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values.
		$data = array_filter($data, 'strlen');

		if(empty($data)){
			return FALSE;
		}

		// Set new Entities\Position object
		$position = new Entities\Position;

		// Check if id field is present. Meaning, this action is for updating fields.
		if (! empty($data["id"])) {

			$position = $this->find_by(array("id" => $data["id"]));

			// Return FALSE if found no item.
			if (is_null($position)) {
				return FALSE;
			}
		}

		// Update the isActive from the passed data.
		if(isset($data["isActive"])){
			$position->setIsActive($data["isActive"]);
		}

		// Set/Update the title from the passed data
		if (isset($data["title"])) {
			$position->setTitle($data["title"]);
		}

		// Set/Update the limitation from the passed data
		if (isset($data["limitation"])) {
			$position->setLimitation($data["limitation"]);
		}

		// Save to a new object
		$this->doctrine->em->persist($position);

		try {

			// Save to database
			$this->doctrine->em->flush();
			
		} catch (Exception $e) {
			
			echo "error in model/position/save";
			exit();

		}

		// Successful database operation
		return TRUE;

	}






	/**
	 * Get all items on this model
	 * @return obj [description]
	 */
	public function get_all()
	{
		return $this->_em->findBy($this->_DEFAULT_STATUS);
	}







	/**
	 * Find specific content by users condition
	 * @param  array  $data conditions via form of array
	 * @return collection       collection of data
	 */
	public function find_by($args = array())
	{
		// Removed null value array keys
		$args = array_filter($args);

		// Return all items if no condition found.
		if (empty($args)) {
			return $this->get_all();
		}

		// Merge isActive condition to the passed condition
		$condition = array_merge($this->_DEFAULT_STATUS, $args);

		// Return one row if id condition is present. Else, all items that satisfy the condition.
		return !empty($args["id"]) ? $this->_em->findOneBy($condition) : $this->_em->findBy($condition);
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

			$position = new Entities\Position;

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