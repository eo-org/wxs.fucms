<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'User\Controller\IndexController' => 'User\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:websiteId/user',
                    'defaults' => array(
                        'controller'    => 'User\Controller\IndexController',
                        'action'        => 'index',
                    ),
                	'constraints' => array(
                		'websiteId' => '[a-z0-9]{24}',
                	)
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
//             		'actionroutes' => array(
//             			'type'		=> 'segment',
//             			'options'	=> array(
//             				'route' 	=> '[:controller][/:action]',
//             				'defaults'	=> array(
//             					'controller'    => 'Application\Controller\IndexController',
//             					'action'        => 'test',
//             				)
//             			)
//             		),
            	)
            ),
        	
        ),
    ),
	'view_manager' => array(
		'template_map' => array(
			'user/index/index'			=> __DIR__ . '/../view/index/index.phtml',
		)
	),
	'service_manager' => array(
		'invokables' => array(
			'User\Service\SessionAuth' => 'User\Service\SessionAuth',
		)
	)
);