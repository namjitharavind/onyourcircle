<?php
return array(
/******************************Begin:added for acl***********************************/
        'controller_plugins' => array(
            'invokables' => array(
               ' AuthorizationPlugin' => 'Authorization\Controller\Plugin\AuthorizationPlugin',
             )
         ),
/******************************Begin:added for acl***********************************/  
);