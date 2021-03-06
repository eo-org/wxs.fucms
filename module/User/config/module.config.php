<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'user-index'	=> 'User\Controller\IndexController',
        	'user-sn'		=> 'User\Controller\SnController',
        	'fc-user-bind'	=> 'User\Controller\FcUserBindController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:websiteId/user',
                    'defaults' => array(
                        'controller'    => 'user-index',
                        'action'        => 'index',
                    ),
                	'constraints' => array(
                		'websiteId' => '[a-z0-9]{24}',
                	)
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
            		'actionroutes' => array(
            			'type' => 'segment',
						'options' => array(
							'route' => '/:controller[/:action]',
							'constraints' => array(
								'controller' => '[a-z-]*',
								'action' => '[a-z-]*'
							),
							'defaults' => array(
								'action' => 'index'
							)
						),
						'may_terminate' => true,
						'child_routes' => array(
							'wildcard' => array(
								'type' => 'wildcard'
							)
						)
            		)	
            	)
            ),
        	
        ),
    ),
	'view_manager' => array(
		'template_map' => array(
			'user/index/index'			=> __DIR__ . '/../view/user/index/index.phtml',
			'user/sn/index'				=> __DIR__ . '/../view/user/sn/index.phtml',
			'user/fc-user-bind/index'	=> __DIR__ . '/../view/user/fc-user-bind/index.phtml'
		)
	),
	'service_manager' => array(
		'invokables' => array(
			'User\Service\SessionAuth' => 'User\Service\SessionAuth',
		)
	)
);