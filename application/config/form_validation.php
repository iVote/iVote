<?php

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
                                            'rules' => 'trim|required|xss_clean|check_if_exists[Group.name]'
                                         ),
                                    array(
                                            'field' => 'shortDescription',
                                            'label' => 'Short Description',
                                            'rules' => 'trim|xss_clean'
                                         )
                                    )
               );
?>