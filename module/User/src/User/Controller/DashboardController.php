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

class DashboardController extends AbstractActionController {
    public function indexAction() {
       
        $viewModel = new ViewModel();
        return $viewModel;
    }

   
}
