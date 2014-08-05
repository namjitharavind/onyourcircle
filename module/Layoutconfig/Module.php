<?php

/* * ****************************************************************************************************
  File						: 	Module.php
  Description						:       Assign layout for particular module,controller,action
  We can configure at /config/autoload/layout.php
  Project 						:       newagesystem
  Date						:       18.10.2013
  Language 						: 	PHP 5
  Database 						: 	Mysql
  Author						:       Namjith Aravind
  Modified On (By)                                    :
  Development Center                                  :       Wiztelsys
  Last Modified On (By)                               :       18.10.2013
 * **************************************************************************************************** */

namespace Layoutconfig;

class Module {

    public function onBootstrap($e) {



        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $request = $sm->get('request');

        $headers = $request->getHeaders();

        if ($headers->has('Accept')) {
            $accept = $headers->get('Accept');
            $accept_type = explode(";", $accept->getFieldValue());
            $accept_types = explode(",", $accept_type[0]);

            $request_type = trim($accept_types[0]);
        }



        //check the call coming from web
        if ($request_type != "application/json") {
            $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {

                $controller = $e->getTarget();
                $controllerClass = get_class($controller);
                $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
                $config = $e->getApplication()->getServiceManager()->get('config');


                $routeMatch = $e->getRouteMatch();
                //echo '<pre>'; print_r($routeMatch); exit;
                $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name



                $controllerName = $routeMatch->getParam('controller', 'not-found');     #get the controller name 
                $controllerName = explode('\\', $controllerName);
                $controllerName = array_pop($controllerName);
                $controllerName = strtolower($controllerName);

//echo $moduleNamespace; exit;

                if (isset($config['module_layouts'][$moduleNamespace][$controllerName][$actionName])) {
       
                    //echo '<pre>'; print_r($config['module_layouts']); exit;
                    $controller->layout($config['module_layouts'][$moduleNamespace][$controllerName][$actionName]);
                } elseif (isset($config['module_layouts'][$moduleNamespace][$controllerName]['default'])) {

                    $controller->layout($config['module_layouts'][$moduleNamespace][$controllerName]['default']);
                }
            }, 100);
        }
    }

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
