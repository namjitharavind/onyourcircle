<?php

/* * ****************************************************************************************************
  File						: 	layout.php
  Description						:       Layoutconfig module configuration

  Project 						:       newagesystem
  Date						:       18.10.2013
  Language 						: 	PHP 5
  Database 						: 	Mysql
  Author						:       Namjith Aravind
  Modified On (By)                                    :
  Development Center                                  :       Wiztelsys
  Last Modified On (By)                               :       31.10.2013
 * **************************************************************************************************** */
return array(
    'view_manager' => array(
            'template_path_stack' => array(
             'user' => 'module/User/view',
   
        ),
        'template_map' => array(
            'layout/user.login.layout' => 'module/Layoutconfig/view/layout/user.login.layout.phtml',
           
        ),
    ),
    'module_layouts' => array(
        'User' => array(
                'admin' => array(
                'default' => 'layout/user.login.layout',
                'login' => 'layout/user.login.layout',
            )
        ),
       
       
        
    ),
);
?>