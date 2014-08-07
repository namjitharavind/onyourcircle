<?php
return array(
      'controller_plugins' => array(
        'invokables' => array(
            'CommonPlugin' => 'Common\Controller\Plugin\CommonPlugin',
            'MailtemplatePlugin' => 'Common\Controller\Plugin\MailtemplatePlugin',
            'UnitConvertingTable'=> 'Common\Controller\Plugin\UnitConvertingTable',
        )
    ),
 
 );