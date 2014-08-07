<?php

/* * ****************************************************************************************************
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
 * **************************************************************************************************** */

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use User\Entity\User;
use User\Dao\UserDAO;

class Module implements AutoloaderProviderInterface {

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

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {

        return array(
            'factories' => array(
                'User\Service\UserService' => function($sm) {
            return new \User\Service\UserService();
        },
                'User\Storage\UserAuthStorage' => function($sm) {
            return new \User\Storage\UserAuthStorage('SSADM');
        },
                'UserAuthService' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'system_login_master', 'email', 'password', 'MD5(?) AND user_status = 1');
            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $authService->setStorage($sm->get('User\Storage\UserAuthStorage'));
            return $authService;
        },
                'User\Dao\UserDAO' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $tableGateway = $sm->get('UserTableGateway');
            $table = new UserDAO($tableGateway, $dbAdapter);
            return $table;
        },
                'UserTableGateway' => function ($sm) {

            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new User()); // Notice what is set here
            return new TableGateway('system_login_master', $dbAdapter, null, $resultSetPrototype);
        },
            ),
        );
    }

}
