<?php
 /******************************************************************************************************
    File						: 	Module.php
    Description						:       Module for Common functions and varaibles
    Project 						:       newagesystem
    Date						:       18.10.2013
    Language 						: 	PHP 5
    Database 						: 	Mysql
    Author						:       Namjith Aravind
    Modified On (By)                                    :
    Development Center                                  :       Wiztelsys
    Last Modified On (By)                               :       18.10.2013
 ******************************************************************************************************/
namespace Common;


class Module{
    
     public function getAutoloaderConfig()
    {
         
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
             'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getConfig(){
        
      return include __DIR__ . '/config/module.config.php';
    }
    
    
  
    
    
}
?>


