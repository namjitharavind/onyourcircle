<?php

namespace Authorization\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role;

class AuthorizationPlugin extends AbstractPlugin {

    public $authservice;

    public function fncGetUserIdSession() {

        if ($this->getUserAuthService()->hasIdentity()) {
            $user_info = $this->getUserAuthService()->getIdentity();
            return $user_info['id'];
        }
    }

    public function getUserAuthService() {

        if (!$this->authservice) {


            $sm = $this->getController()->getServiceLocator();
            $this->authservice = $sm->get('UserAuthService');
        }

        return $this->authservice;
    }

    public function doAuthorization($e) {

        #set ACL
        $acl = new Acl();
        $acl->deny();  # on by default
        #$acl->allow(); # this will allow every route by default so then you have
        # to explicitly deny all routes that you want to protect.  
        #Begin:ROLES
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('SSADM'));
        $acl->addRole(new Role('SADM'));
        $acl->addRole(new Role('MSADM'));
        $acl->addRole(new Role('MADM'));
        $acl->addRole(new Role('NRMUSR'));
        #End:ROLES
        #Begin:RESOURCES
        $acl->addResource('application'); # Application module
        $acl->addResource('user'); # User module
        #End:RESOURCES 
        #Begin:PERMISSIONS
        #$acl->allow('role', 'resource', 'controller:action');
        #Apllication
        #user
        $acl->allow('SSADM', 'user');
        $acl->allow('anonymous', 'user');

        #End:PERMISSIONS
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleName = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
        // $role               = (!$user->hasIdentity()) ? 'anonymous' :$identity['user_type'];
        $routeMatch = $e->getRouteMatch();


        $actionName = strtolower($routeMatch->getParam('action', 'not-found'));  #get the action name 

        $controllerName = $routeMatch->getParam('controller', 'not-found');     #get the controller name 

        $controllerName = explode('\\', $controllerName);
        $controllerName = array_pop($controllerName);
        $controllerName = strtolower($controllerName);
 //$this->getUserAuthService()->clearIdentity();
        //Check user session 
        if ($moduleName == "user" && $controllerName == "admin") {
            if ($this->getUserAuthService()->hasIdentity()) {

                $user_info = $this->getUserAuthService()->getIdentity();
                print_r($user_info); exit;
                $role = $user_info['user_type'];
            } else {

                $role = 'anonymous';
            }
        } else {

            $role = 'anonymous';
        }


//        echo $role;
//        exit;
        // echo $role; exit;
//        print '<br>moduleName: ' . $moduleName . '<br>';
//        print '<br>controllerClass: ' . $controllerClass . '<br>';
//        print 'controllerName: ' . $controllerName . '<br>';
//        print 'action: ' . $actionName . '<br>';
//        exit;

        #Check Access
        if (!$acl->isAllowed($role, $moduleName, $controllerName . ':' . $actionName)) {


            $router = $e->getRouter();
            $matches = $e->getRouteMatch();
            //echo '<pre>'; print_r($matches); exit;
            // $url    = $router->assemble(array(), array('name' => 'Login/auth')); // assemble a login route
            if ($moduleName != "user") {
                $url = $router->assemble(array(), array('name' => 'user'));
            } else {
               // echo "poy"; exit;
                $url = $router->assemble(array(), array('name' => 'admin'));
            }
       
            $response = $e->getResponse();
            $response->setStatusCode(302);
            // redirect to login page or other page.
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();
        }
    }

}
