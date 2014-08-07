<?php

namespace User\Service;

use User\Form\LoginForm;
use User\Form\LoginFormFilter;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
class userService {

    public function process($authservice,$post,$userDAO,$sessionStorage) {

        $form = new LoginForm();
        $inputFilter = new LoginFormFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);

        if ($form->isValid()) {
            $authservice->getAdapter()
                    ->setIdentity($post['email'])
                    ->setCredential($post['password'])
                    ->getDbSelect();
            $result = $authservice->authenticate();

            switch ($result->getCode()) {

                case Result::FAILURE_IDENTITY_NOT_FOUND:
echo "failer identity"; exit;
                    $form->get('email')->setMessages(array('Wrong user email'));
                    $viewModel = new ViewModel(array('form' => $form));
                    $viewModel->setTemplate('user/admin/login');
                    return $viewModel;

                    break;

                case Result::FAILURE_CREDENTIAL_INVALID:
echo "failed"; exit;
                    $form->get('password')->setMessages(array('Wrong user password'));
                    $viewModel = new ViewModel(array('form' => $form));
                    $viewModel->setTemplate('user/admin/login');
                    return $viewModel;

                    break;

                case Result::SUCCESS:
echo "success"; exit;
                    $user = $userDAO->getUserByEmail($post['email']);

                    if ($post['rememberme']) {
                        $sessionStorage->setRememberMe(1);
                        //set storage again
                        $this->getUserAuthService()->setStorage($sessionStorage);
                    }
                    //print_r($user); exit;
                    //echo $this->CommonPlugin()->resourse[$user->user_type]; exit;
                    $authservice->setStorage($sessionStorage);
                    $authservice->getStorage()->write(array(
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
        }else{
            echo "not valid"; exit;
        }
    }
    
    public function logout($authservice,$sessionStorage){
        if ($authservice>hasIdentity()) {
            $sessionStorage->forgetMe();
            $sessionStorage->clearIdentity();
        }
    }

}
