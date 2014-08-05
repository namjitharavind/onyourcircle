<?php
namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form {
   public function __construct($name = null) {
       parent::__construct("Login");
       $this->setAttribute('method', 'post');
       $this->setAttribute('enctype', 'multipart/formdata');
       
             
       
       $this->add(array(
            'name' => 'user_email',
            'attributes' => array(
                'type' => 'email',
                'class'=>'form-control',
                'required' => 'required'
            ), 'options' => array(
                'label' => 'Email',
               
            ),
            
        ));
       
       
       
        $this->add(array(
            'name' => 'user_password',
            'attributes' => array(
                'type' => 'password',
                'class'=>'form-control'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));  
          
        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',			
            'options' => array(
                'label' => 'Remember Me?',
                            'checked_value' => true, 
                            'unchecked_value' => false, 
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class'=>'btn btn-primary',
                'value'=>'Login'
            ),
            
        ));
       
       
   }
}
?>
