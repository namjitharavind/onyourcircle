<?php

/* * ****************************************************************************************************
  File						: 	CommonPlugin.php
  Description						:       All common functions and variables
  Project 						:       newagesystem
  Date						:       18.10.2013
  Language 						: 	PHP 5
  Database 						: 	Mysql
  Author						:       Namjith Aravind
  Modified On (By)                                    :
  Development Center                                  :       Wiztelsys
  Last Modified On (By)                               :       18.10.2013
 * **************************************************************************************************** */

namespace Common\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

class CommonPlugin extends AbstractPlugin {

    public $user_type_map = array();
    public $user_status = array();
    public $resourse = array();
    public $acceptCriteria = array();
    public $auth_type = array();
    public $servicetype = array();
    public $food_content_munit = array();
    public $food_timings = array();
    public $path_app_logo;
    public $path_app_logo_temp;
    public $path_user_image;
    public $path_swift;
    public $goal_type = array();
    public $food_graph_types=array();
    public $food_goal_graph_types=array();
    
    #MAIL CONFIGURATION

    const SMTP_FROM = "namjith@wiztelsys.com";
    const SMTP_FROM_NAME = "nuagesystems";

    #SMTP AUTH SETTTINGS
    const SMTP_SERVER = "smtp.gmail.com";
    const SMTP_PORT = 465;
    const SMTP_SECURITY = 'ssl';
    const SMTP_USER_NAME = "namjith@wiztelsys.com";
    const SMTP_PASSWORD = "namjithwiztelsys";

    public function __construct() {

        $this->user_type_map = array("ADM" => "1", "SP" => "2", "NRM" => "3");
        $this->user_status = array("ACTIVE" => "1", "DEACTIVE" => "0");
      
        
        
    }

   

    /*
     * Turn off the layout, i.e. only render the view script.
     */

    public function fncdisableLayout($data = array()) {

        $viewModel = new ViewModel($data);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    

}
