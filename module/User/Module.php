<?php
 /******************************************************************************************************
    File						: 	Module.php
    Description						:       User Login and Registration
                                                               
    Project 						:       newagesystem
    Date						:       18.10.2013
    Language 						: 	PHP 5
    Database 						: 	Mysql
    Author						:       Namjith Aravind
    Modified On (By)                                    :
    Development Center                                  :       Wiztelsys
    Last Modified On (By)                               :       18.10.2013
 ******************************************************************************************************/
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface
{
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


   
}
