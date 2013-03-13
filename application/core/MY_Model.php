<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	/*
	| -------------------------------------------------------------------
	|  Default Dependencies
	| -------------------------------------------------------------------
	|
	*/
	// // Default query field name.
	// const DEFAULT_CONDITION_KEY   = "isActive"; 

	// // Default directory of Entities.
	// const DEFAULT_ENTITY_DIR      = "Entities"; 

	// // Default condition value for querying the default field name.
	// const DEFAULT_CONDITION_VALUE = TRUE; 

	// //
	// const DEFAULT_SOFT_DELETE_KEY = "isActive";

	private $_DEFAULTS = array(

						"CONDITION_KEY"     => "isActive",
						
						"CONDITION_VALUE"   => TRUE,
						
						"ENTITY_DIR"        => "Entities",
						
						"SOFT_DELETE_KEY"   => "isActive",
						
						"SOFT_DELETE_VALUE" => FALSE

				);

	/*
	| ----- End Default Dependencies ------------------------------------
	*/


	//
	//
	private $_EM;

	// 
	// 
	private $_DOCTRINE;

	//
	//
	protected $ENTITY_OBJECT;

	//
	//
	protected $BASE_ENTITY_DIR = $this->_DEFAULTS["ENTITY_DIR"];

	/**
	 * Override the BASE_QUERY by passing an array.
	 * Ex: $this->BASE_QUERY = array("isGroupDependent" => FALSE)
	 * @var array
	 */
	protected $BASE_QUERY = array( $this->_DEFAULTS["CONDITION_KEY"] => $this->_DEFAULTS["CONDITION_VALUE"] );


	protected $BASE_SOFT_DELETE_KEY = $this->_DEFAULTS["SOFT_DELETE_KEY"];

	protected $BASE_SOFT_DELETE_VALUE = $this->_DEFAULTS["SOFT_DELETE_VALUE"];


	//
	//
	public function __construct()
	{
		parent::__construct();
		
		// Load this helper to allow the use of humanize() method.
		$this->load->helper("inflector");
	}

	/**
	 * Initialize MY_Model
	 * @param  [type] $doctrine [description]
	 * @return [type]           [description]
	 */
	protected function init($doctrine)
	{
		$this->_set_entity_object();

		// Set Entity Object to variable _EM for shorter Entity Manager Call.
		$this->_EM       = $doctrine->getRepository($this->ENTITY_OBJECT);

		// Save $doctrine to _DOCTRINE;
		$this->_DOCTRINE = $doctrine;
	}


	/**
	 * Find all items in the database using only the base query requirement.
	 * @return [type] [description]
	 */
	public function find_all()
	{
		return $this->_EM->findBy($this->BASE_QUERY);
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
			return $this->find_all();
		}

		// Merge isActive condition to the passed condition
		$condition = array_merge($this->BASE_QUERY, $args);

		// Return one row if id condition is present. Else, all items that satisfy the condition.
		return !empty($args["id"]) ? $this->_EM->findOneBy($condition) : $this->_EM->findBy($condition);
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

		if (empty($data)) {
			return FALSE;
		}


		if (! empty($data["id"])) {
			return $this->_update($data);
		}



		// Set new Entities\Position object
		// $entry = new $this->ENTITY_OBJECT;

		// // Check if id field is present. Meaning, this action is for updating fields.
		// if (! empty($data["id"])) {

		// 	$entry = $this->find_by(array("id" => $data["id"]));

		// 	// Return FALSE if found no item.
		// 	if (is_null($entry)) {
		// 		return FALSE;
		// 	}
		// }

		// // Update the isActive from the passed data.
		// if(isset($data["isActive"])){
		// 	$entry->setIsActive($data["isActive"]);
		// }

		// // Set/Update the title from the passed data
		// if (isset($data["title"])) {
		// 	$entry->setTitle($data["title"]);
		// }

		// // Set/Update the limitation from the passed data
		// if (isset($data["limitation"])) {
		// 	$entry->setLimitation($data["limitation"]);
		// }

		// // Save to a new object
		// $this->_DOCTRINE->persist($entry);

		// try {

		// 	// Save to database
		// 	$this->_DOCTRINE->flush();
			
		// } catch (Exception $e) {
			
		// 	echo "error in model/entry/save";
		// 	exit();

		// }

		// // Successful database operation
		// return TRUE;

	}


	public function soft_delete(int $id = NULL )
	{

		if (is_null($id)) {
			return FALSE;
		}

		$item = $this->find_by(array("id" => $id));

		$_method = "set" . humanize($this->BASE_SOFT_DELETE_KEY);

		if (! method_exists($item, $_method)) {
			return FALSE;
		}

		$item->$_method($this->BASE_SOFT_DELETE_VALUE);

		return $this->_transact($item);

	}


	private function _transact($obj){

		try {
			
			$this->_DOCTRINE->persist($obj);

			$this->_DOCTRINE->flush();

			return TRUE;

		} catch (Exception $e) {
			
			

		}

	}


	private function _insert()
	{
		# code...
	}


	private function _update()
	{
		# code...
	}


	public function _remove()
	{
		# code...
	}






	/**
	* Guess the Entity via Model name
	*/
  private function _set_entity_object()
  {
  	if (! isset($this->ENTITY_OBJECT)) {

  		// Set the name of the Entity to be used through out the model.
    	$this->ENTITY_OBJECT = $this->BASE_ENTITY_DIR . "\\" . humanize(get_class($this));

  	}

  	// return $this->ENTITY_OBJECT;

  }


}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */