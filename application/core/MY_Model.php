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

						"SELECTOR_KEY"			=> "id"

						// "SELECTOR_KEY_TYPE" => "integer"

				);

	/* ----- End Default Dependencies ------------------------------------ */


	// Doctrine Entity Manager
	private $_EM;

	// Doctrine
	private $_DOCTRINE;

	// Entity Object to be used
	protected $ENTITY_OBJECT;

	//
	protected $BASE_ENTITY_DIR;

	/**
	 * Override the BASE_QUERY by passing an array.
	 * Ex: $this->BASE_QUERY = array("isGroupDependent" => FALSE)
	 * @var array
	 */
	protected $BASE_QUERY;


	// Table field to be changed for masking deletion of data
	protected $BASE_SOFT_DELETE_KEY;
	
	// Value to consider for a mask deletion.
	protected $BASE_SOFT_DELETE_VALUE;

	// Base selector key  to be used for querying
	protected $BASE_SELECTOR_KEY;

	// Type of the base selector key for validation purposes.
	// protected $BASE_SELECTOR_KEY_TYPE;



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
		$this->load->helper(array("inflector", "string"));

		
		$this->BASE_QUERY             = array( camelize($this->_DEFAULTS["CONDITION_KEY"]) => $this->_DEFAULTS["CONDITION_VALUE"] );
		
		$this->BASE_ENTITY_DIR        = $this->_DEFAULTS["ENTITY_DIR"];
		
		$this->BASE_SOFT_DELETE_KEY   = $this->_DEFAULTS["SOFT_DELETE_KEY"];
		
		$this->BASE_SOFT_DELETE_VALUE = $this->_DEFAULTS["SOFT_DELETE_VALUE"];
		
		$this->BASE_SELECTOR_KEY      = $this->_DEFAULTS["SELECTOR_KEY"];

		// $this->BASE_SELECTOR_KEY_TYPE = $this->_DEFAULTS["SELECTOR_KEY_TYPE"];

	}




	/*
	| -------------------------------------------------------------------
	| Public :: Find All
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
	| Public :: Find By
	| -------------------------------------------------------------------
	| Find specific content by users condition
	|
	*/
	public function find_by($args = array(), $with_base = FALSE)
	{
		// Removed null value array keys
		$args = array_filter($args);

		// Return all items if no condition found.
		if ( empty($args) ) {
			return NULL;
		}

		// Merge isActive condition to the passed condition
		$condition = $with_base ? array_merge($this->BASE_QUERY, $this->_clean_entry($args)) : $this->_clean_entry($args);
		
		// Return one row if id condition is present. Else, all items that satisfy the condition.
		return !empty($args[$this->BASE_SELECTOR_KEY]) ? $this->_EM->findOneBy($condition) : $this->_EM->findBy($condition);
	}



	/*
	| -------------------------------------------------------------------
	| Public :: save
	| -------------------------------------------------------------------
	| Save data to database. TOOOOOOOOOOOOOOOOOOOOO DRY.
	|
	*/
	public function save($data = array(), $is_multiple = FALSE)
	{
		// Fail Early validation of array. 
		// Removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values.
		$data = array_filter($data, 'strlen');

		// Throw exception if the parameter is empty.
		if ( empty($data) ) {
			throw new Exception("Passed parameter is NULL");
		}

		if (! empty($data[$this->BASE_SELECTOR_KEY])) {
			
			$this->_update($data);

		} else {

			$this->_insert($data);

		}

		//If $is_multiple is set to TRUE, use the flush() method manually
		if (! $is_multiple) {
			$this->flush();
		}

	}


	/*
	| -------------------------------------------------------------------
	| Public :: soft_delete
	| -------------------------------------------------------------------
	|
	*/
	public function soft_delete( $key = NULL, $is_multiple = FALSE )
	{
		// TODO: To be improved.
		$this->_check_var($key);

		// 
		$item = $this->find_by(array($this->BASE_SELECTOR_KEY => $key));

		// Check the no record is found.
		if ( is_null($item)) { throw new Exception("No entry found"); }

		// Call the dynamic Entity method.
		call_user_func_array( array($item, "set" . ucfirst(camelize($this->BASE_SOFT_DELETE_KEY))), array($this->BASE_SOFT_DELETE_VALUE));

		$this->_DOCTRINE->persist($item);

		if (! $is_multiple) {
			$this->flush();
		}

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
	| Protected ::  flush
	| -------------------------------------------------------------------
	| Save the persistent data to the Database.
	|
	*/
	protected function flush() 
	{
		try {	

			$this->_DOCTRINE->flush();

		} catch (Exception $e) { throw $e; }

		return TRUE;

	}









	/*
	| -------------------------------------------------------------------
	| Private ::  _check_var
	| -------------------------------------------------------------------
	| Check the parameter value that will be used for database processes.
	|
	*/
	private function _check_var($var = NULL)
	{
		if ( is_null($var) ) {
			throw new Exception("NULL reference pointer");	
		}

		// if ( $this->BASE_SELECTOR_KEY_TYPE != gettype($var) ) {
		// 	throw new Exception ("Expected type is \"" . $this->BASE_SELECTOR_KEY_TYPE . "\" but \"" . gettype($var) . "\" is given. ");
		// }
	}



	/*
	| -------------------------------------------------------------------
	| Private ::  _insert
	| -------------------------------------------------------------------
	| Prepare New Object.
	|
	*/
	private function _insert($obj)
	{

		// Initialize new instance of the Entity Object
		$entry = new $this->ENTITY_OBJECT;


		foreach ($obj as $key => $value) {
		
			// Call the dynamic Entity methods.
			call_user_func_array( array($entry, "set" . ucfirst(camelize($key))), array($value) );
			
		}

		$this->_DOCTRINE->persist($entry);

	}


	/*
	| -------------------------------------------------------------------
	| Private ::  _update
	| -------------------------------------------------------------------
	| Prepare Update Object.
	|
	*/
	private function _update($obj)
	{

		$item = $this->find_by( array($this->BASE_SELECTOR_KEY => $obj[$this->BASE_SELECTOR_KEY] ));
	
		$this->_check_var($item);

		// Loop through parameters
		foreach ($obj as $key => $value) {

			// Skip if the current parameter is ID 
			// Because, there is no setId() method.
			// TODO: To be improve. 
			// CASE: What if the primary key is not Id?
			if ($this->_DEFAULTS["SELECTOR_KEY"] == $key) {
				continue;
			}

			// Call the dynamic Entity methods.
			call_user_func_array( array($item, "set" . ucfirst(camelize($key))), array($value) );

		}

		$this->_DOCTRINE->persist($item);
	}


	/*
	| -------------------------------------------------------------------
	| Private ::  _set_entity_object
	| -------------------------------------------------------------------
	| Guess the Entity via Model name and use it as Doctrine Entity Object
	|
	*/
  private function _set_entity_object()
  {
  	if (! isset($this->ENTITY_OBJECT)) {

  		// Set the name of the Entity to be used through out the model.
    	$this->ENTITY_OBJECT = $this->BASE_ENTITY_DIR . "\\" . humanize(get_class($this));

  	}

  }


	/*
	| -------------------------------------------------------------------
	| Private ::  _clean_entry
	| -------------------------------------------------------------------
	|
	*/
	private function _clean_entry($data)
	{
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = reduce_multiples($value, " ", TRUE);
			}

			return $data;
		}

		return reduce_multiples($data, " ", TRUE);

	}

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */