<?php

/* * ****************************************************************************************************
  File						: 	Module.php
  Description						:       Module for users authorization and session management
  Project 						:       newagesystem
  Date						:       18.10.2013
  Language 						: 	PHP 5
  Database 						: 	Mysql
  Author						:       Namjith Aravind
  Modified On (By)                                    :
  Development Center                                  :       Wiztelsys
  Last Modified On (By)                               :       18.10.2013
 * **************************************************************************************************** */

namespace Authorization;

use Zend\ModuleManager\ModuleManager; // added for module specific layouts

/* * ****************************Begin:added for acl********************************** */
use Zend\Mvc\MvcEvent,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface;

/* * ****************************End:added for acl********************************** */

class Module {

    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
        'Zend\View\Model\ViewModel' => array(
            'text/html',
        ),
    );

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /*     * ****************************Begin:added for acl********************************** */

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array($this, 'loadConfiguration'), 2);

        //you can attach other function need here...
    }

    public function loadConfiguration(MvcEvent $e) {

        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();

        $router = $sm->get('router');
        $request = $sm->get('request');

        $matchedRoute = $router->match($request);
        //echo '<pre>'; print_r($post); exit;
        if (null !== $matchedRoute) {

            $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) use ($sm) {
                $sm->get('ControllerPluginManager')->get('AuthorizationPlugin')
                        ->doAuthorization($e); #pass to the plugin...    
            }, 2);
        }
    }

    /*     * ****************************End:added for acl********************************** */

    public function getAutoloaderConfig() {
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

}
