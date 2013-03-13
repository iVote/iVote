<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	/*
	| -------------------------------------------------------------------
	|  Default Dependencies
	| -------------------------------------------------------------------
	|
	*/

	private $_DEFAULTS = array(

						"CONDITION_KEY"     => "is_active",
						
						"CONDITION_VALUE"   => TRUE,
						
						"ENTITY_DIR"        => "Entities",
						
						"SOFT_DELETE_KEY"   => "is_active",
						
						"SOFT_DELETE_VALUE" => FALSE,

						"SELECTOR_KEY"			=> "id",

						"SELECTOR_KEY_TYPE" => "integer"

				);

	/* ----- End Default Dependencies ------------------------------------ */


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
	protected $BASE_ENTITY_DIR;

	/**
	 * Override the BASE_QUERY by passing an array.
	 * Ex: $this->BASE_QUERY = array("isGroupDependent" => FALSE)
	 * @var array
	 */
	protected $BASE_QUERY;


	//
	//
	protected $BASE_SOFT_DELETE_KEY;
	
	//
	//
	protected $BASE_SOFT_DELETE_VALUE;

	//
	//
	protected $BASE_SELECTOR_KEY;

	//
	//
	protected $BASE_SELECTOR_KEY_TYPE;



	/*
	| -------------------------------------------------------------------
	|  Construct
	| -------------------------------------------------------------------
	|
	*/
	public function __construct()
	{
		parent::__construct();
		
		// Load this helper to allow the use of humanize() method.
		$this->load->helper("inflector");

		
		$this->BASE_QUERY             = array( camelize($this->_DEFAULTS["CONDITION_KEY"]) => $this->_DEFAULTS["CONDITION_VALUE"] );
		
		$this->BASE_ENTITY_DIR        = $this->_DEFAULTS["ENTITY_DIR"];
		
		$this->BASE_SOFT_DELETE_KEY   = $this->_DEFAULTS["SOFT_DELETE_KEY"];
		
		$this->BASE_SOFT_DELETE_VALUE = $this->_DEFAULTS["SOFT_DELETE_VALUE"];
		
		$this->BASE_SELECTOR_KEY      = $this->_DEFAULTS["SELECTOR_KEY"];

		$this->BASE_SELECTOR_KEY_TYPE = $this->_DEFAULTS["SELECTOR_KEY_TYPE"];

	}





	/*
	| -------------------------------------------------------------------
	| Init
	| -------------------------------------------------------------------
	|	Initialize Doctrine. 
	| This is a necessary method.
	|
	*/
	protected function init($doctrine)
	{
		$this->_set_entity_object();

		// Set Entity Object to variable _EM for shorter Entity Manager Call.
		$this->_EM       = $doctrine->getRepository($this->ENTITY_OBJECT);

		// Save $doctrine to _DOCTRINE;
		$this->_DOCTRINE = $doctrine;
	}






	/*
	| -------------------------------------------------------------------
	| Find All
	| -------------------------------------------------------------------
	|	Find all items in the database using only the base query requirement. 
	|
	*/
	public function find_all()
	{
		return $this->_EM->findBy($this->BASE_QUERY);
	}





	/*
	| -------------------------------------------------------------------
	| Find By
	| -------------------------------------------------------------------
	| Find specific content by users condition
	|
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
		return !empty($args[$this->BASE_SELECTOR_KEY]) ? $this->_EM->findOneBy($condition) : $this->_EM->findBy($condition);
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

		if ( empty($data) ) {
			return FALSE;
		}


		if (! empty($data[$this->BASE_SELECTOR_KEY])) {
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


	public function soft_delete( $key = NULL )
	{
		// TODO: To be improved.
		$this->_check_var($key);

		
		$item = $this->find_by(array($this->BASE_SELECTOR_KEY => $key));

		try {

			if ( is_null($item)) {
				throw new Exception("No entry found");
			}

			call_user_func_array( array($item, "set" . ucfirst(camelize($this->BASE_SOFT_DELETE_KEY))), array($this->BASE_SOFT_DELETE_VALUE));

		} catch (Exception $e) { throw $e; }

		return $this->_transact($item);

	}





	private function _transact($obj) {

		$this->_DOCTRINE->persist($obj);
		
		try {	

			$this->_DOCTRINE->flush();

		} catch (Exception $e) {
			
			throw $e;

		}

		return TRUE;

	}










	private function _check_var($var = NULL)
	{
		if ( is_null($var) ) {
			throw new Exception("NULL reference pointer");	
		}

		if ( $this->BASE_SELECTOR_KEY_TYPE != gettype($var) ) {
			throw new Exception ("Expected type is \"" . $this->BASE_SELECTOR_KEY_TYPE . "\" but \"" . gettype($var) . "\" is given. ");
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