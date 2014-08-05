<?php
namespace User\Form;

use Zend\InputFilter\InputFilter;

class LoginFormFilter extends InputFilter{
    
    
    public function __construct() {
          
       
                
        $this->add(array(
            'name' => 'user_email',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                           'messages' => array(
                            \Zend\Validator\
                            EmailAddress::INVALID_FORMAT => 'Email address format is invalid'
                        )
                    )
                )
            )
        )
        );
        
       $this->add(array(
            'name' => 'user_password',
            'required' => true,
        ));
        
         $this->add(array(
            'name' => 'rememberme',
              'required' => false,
                    ));
        
    }
}