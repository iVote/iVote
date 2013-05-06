<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation 
{
	function MY_Form_validation( $config = array() )
	{
	    parent::__construct($config);
	}



	/**
     * Run the Validator
     *
     * This function does all the work.
     *
     * Modified by Brett Millett:
     *  Provided option to remove the config or inline only restriction on
     *  rules. This version will process config rules first and then any
     *  inline rules that exist after. This has the benefit of allowing
     *  inline rules to overwite config rules by the same key.
     *
     * @access	public
     * @return	bool
     */
    function run($group = '', $combine_conf_inline = FALSE) {
        if ($combine_conf_inline) {
            //only perform if we have both field and config rules.
            if (count($this->_field_data) > 0 && count($this->_config_rules) > 0) {
                // Is there a validation rule for the particular URI being accessed?
                $uri = ($group == '') ? trim($this->CI->uri->ruri_string(), '/') : $group;
 
                if ($uri != '' AND isset($this->_config_rules[$uri])) {
                    $config_rules = $this->_config_rules[$uri];
                } else {
                    $config_rules = $this->_config_rules;
                }
 
                // only set the rule if it has not already been set inline.
                foreach ($config_rules as $row) {
                    if (!isset($this->_field_data[$row['field']]))
                        $this->set_rules($row['field'], $row['label'], $row['rules']);
                }
            }
        }
        //run parent version last, so field rules will  override config ones and update
        return parent::run($group);
    }




    /**
	 * Check if item already exists.
	 * TO BE IMPROVED.
	 */
	public function check_if_exists($data, $arg)
	{ 
		
		// Get entity and field name.
		list($entity, $field) = explode('.', $arg);

		// Get items via name field
		$obj = $this->CI->$entity->find_by(array($field => $data), TRUE);

		// if item is found, return. [Fail Early Validation]
		if ( empty($obj) )
			return TRUE;	

		//if item is not found, set error message
		$this->CI->form_validation->set_message('check_if_exists', $data . ' already exists');
		return FALSE;
	}

}