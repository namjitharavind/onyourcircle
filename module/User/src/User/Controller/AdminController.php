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
use User\Form\LoginForm;
use User\Form\LoginFormFilter;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController {


     public function indexAction() {

            $form = new LoginForm();
            $viewModel = new ViewModel(array('form' => $form));
            return $viewModel;
        
    }
    
    public function loginAction(){
   
          $form = new LoginForm();
            $viewModel = new ViewModel(array('form' => $form));
            return $viewModel;
    }

   

}
