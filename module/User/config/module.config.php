<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Admin' => 'User\Controller\AdminController',
            'User\Controller\Dashboard' => 'User\Controller\DashboardController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller' => 'Application',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' =>
                            '[:controller[/:action][/:id]]',
                            'constraints' => array(
                                'controller' =>
                                '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' =>
                                '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Admin',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
     'view_manager' => array(
       'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    
);
