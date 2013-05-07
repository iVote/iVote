<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



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
                            ),
           'positions' => array(
                                    array(
                                            'field' => 'title',
                                            'label' => 'Title',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'limitation',
                                            'label' => 'Limitation',
                                            'rules' => 'required|numeric|trim'
                                         ),
                                    array(
                                            'field' => 'groups',
                                            'label' => 'Groups',
                                            'rules' => ''
                                         )
                            ),
           'members' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'shortDescription',
                                            'label' => 'Short Description',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'groups',
                                            'label' => 'Groups',
                                            'rules' => ''
                                         )
                            )
               );


?>