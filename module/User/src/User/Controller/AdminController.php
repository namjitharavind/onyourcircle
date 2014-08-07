<?php

/* * ****************************************************************************************************
  File						: 	Login Controller
  Description					:       Controller login related actions for both api & web
  Project 					:       onyourcircle
  Date						:       04.08.2014
  Language 					: 	PHP 5
  Database 					: 	Mysql
  Author					:       Namjith Aravind
  Modified On (By)                              :
  Development Center                            :       Wiztelsys
  Last Modified On (By)                         :       04.08.2014
 * **************************************************************************************************** */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use User\Form\LoginForm;
use User\Form\LoginFormFilter;
use Zend\Authentication\Result;

class AdminController extends AbstractActionController {

    protected $userservice = "";
    protected $authservice = "";
    protected $storage = "";
    protected $userDao = "";
    private $return = array();

    public function __construct() {

        $this->return['status'] = false;
        $this->return['message'] = "NO RESULT";
    }

    public function indexAction() {

        $form = new LoginForm();
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function loginAction() {

        $form = new LoginForm();
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function processAction() {


        if ($this->request->isPost()) {
            $post = $this->request->getPost();
          
            $form = new LoginForm();
            $inputFilter = new LoginFormFilter();
            $form->setInputFilter($inputFilter);
            $form->setData($post);

            if ($form->isValid()) {
                $this->getUserAuthService()->getAdapter()
                        ->setIdentity($post['email'])
                        ->setCredential($post['password'])
                        ->getDbSelect();
                $result = $this->getUserAuthService()->authenticate();

                switch ($result->getCode()) {

                    case Result::FAILURE_IDENTITY_NOT_FOUND:

                        $this->return['status'] = false;
                        $this->return['email'] = false;
                        $this->return['password'] = true;
                        $this->return['message'] = "Wrong user email";
                        return new JsonModel($this->return);
                        break;

                    case Result::FAILURE_CREDENTIAL_INVALID:

                        $this->return['status'] = false;
                        $this->return['password'] = false;
                        $this->return['true'] = false;
                        $this->return['message'] = "Wrong user password";
                        return new JsonModel($this->return);
                        break;

                    case Result::SUCCESS:
                        echo "success";
                        exit;
                        $user = $this->getUserDAO()->getUserByEmail($post['email']);

                        if ($post['rememberme']) {
                            $this->getSessionStorage()->setRememberMe(1);
                            //set storage again
                            $this->getUserAuthService()->setStorage($this->getSessionStorage());
                        }
                        //print_r($user); exit;
                        //echo $this->CommonPlugin()->resourse[$user->user_type]; exit;
                        $this->getUserAuthService()->setStorage($this->getSessionStorage());
                        $this->getUserAuthService()->getStorage()->write(array(
                            'id' => $user->id,
                            'email' => $user->email,
                            'user_type' => $user->user_type_id,
                        ));


                        return $this->redirect()->toRoute('user/default', array(
                                    'controller' => 'dashboard',
                                    'action' => 'index'
                        ));

                        break;

                    default:
                        // do stuff for other failure
                        break;
                }
            } else {
                print_r($form->getMessages());
                //echo "not valid";
                exit;
            }
        } else {
            echo "not post";
            exit;
        }
    }

    public function logoutAction() {
        $this->getUserService()->logout($this->getUserAuthService(), $this->getSessionStorage());
        return $this->redirect()->toRoute('user/default', array('controller' => 'login', 'action' => 'index'));
    }

    public function getUserDAO() {
        if (!$this->userDao) {
            $sm = $this->getServiceLocator();

            $this->userDao = $sm->get('User\Dao\UserDAO');
        }
        return $this->userDao;
    }

    public function getUserAuthService() {

        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()
                    ->get('UserAuthService');
        }

        return $this->authservice;
    }

    public function getUserService() {

        if (!$this->userservice) {
            $this->userservice = $this->getServiceLocator()
                    ->get('User\Service\UserService');
        }

        return $this->userservice;
    }

    public function getSessionStorage() {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()
                    ->get('User\Storage\UserAuthStorage');
        }

        return $this->storage;
    }

}
