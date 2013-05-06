<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
  *  Added validation methods:
  *     
  *     check_if_exists() // REQUIRED params: [entity, field name].
  *
  *
  */

$config = array(
           'groups' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'shortDescription',
                                            'label' => 'Short Description',
                                            'rules' => 'trim'
                                         )
                                    )
               );
?>