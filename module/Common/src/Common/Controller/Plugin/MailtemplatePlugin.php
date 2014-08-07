<?php
 /******************************************************************************************************
    File						: 	CommonPlugin.php
    Description						:       All mail related  
    Project 						:       newagesystem
    Date						:       18.10.2013
    Language 						: 	PHP 5
    Database 						: 	Mysql
    Author						:       Namjith Aravind
    Modified On (By)                                    :
    Development Center                                  :       Wiztelsys
    Last Modified On (By)                               :       18.10.2013
 ******************************************************************************************************/
namespace Common\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

 class  MailtemplatePlugin extends AbstractPlugin{
    
    public $mailContent;
    public $path_email_template;
    public function __construct() {
     
         $this->mailContent="";                                
         $this->path_email_template= getcwd().DIRECTORY_SEPARATOR.'email'.
                                              DIRECTORY_SEPARATOR;
    }
    
    public function fncLoadServiceProviderConfirmMail($sp_key,$username,$password,$link,$user_email){        
    ob_start();
    include($this->path_email_template . "ServiceProviderConfirmation.phtml");
    $this->mailContent = ob_get_contents();     
    ob_end_clean();
    return $this->mailContent;
    }
    
    public function fncLoadNormalUserConfirmMail($username,$password,$link,$user_email){        
    ob_start();
    include($this->path_email_template . "NormalUserConfirmation.phtml");
    $this->mailContent = ob_get_contents();     
    ob_end_clean();
    return $this->mailContent;
    }
  
    
    
    public function fncLoadNormalUserForgotPwdMail($password){        
    ob_start();
    include($this->path_email_template . "NormalUserForgotPassword.phtml");
    $this->mailContent = ob_get_contents();     
    ob_end_clean();
    return $this->mailContent;
    }
    public function fncLoadNormalFriendRequest($username,$friendname,$link){        
    ob_start();
    include($this->path_email_template . "FriendRequestMail.phtml");
    $this->mailContent = ob_get_contents();     
    ob_end_clean();
    return $this->mailContent;
    }
    
}
