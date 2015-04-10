<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'Application\Controller\IndexController' => 'Application\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'application' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'Application\Controller\IndexController',
                        'action'        => 'index',
                    ),
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
            		'test' => array(
            			'type'		=> 'literal',
            			'options'	=> array(
            				'route' 	=> 'test',
            				'defaults'	=> array(
            					'controller'    => 'Application\Controller\IndexController',
            					'action'        => 'test',
            				)
            			)
            		),
            		'get-user-code' => array(
		        		'type'		=> 'literal',
			        	'options'	=> array(
			            	'route' 	=> 'get-user-code',
			        		'defaults'	=> array(
			        			'controller'    => 'Application\Controller\IndexController',
			        			'action'        => 'get-user-code',
			        		)
			            )
		        	)
            	)
            ),
        	
        ),
    ),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			'layout/layout'						=> __DIR__ . '/../view/layout/layout.phtml',
			'error/index'						=> __DIR__ . '/../view/error/index.phtml',
			'error/404'							=> __DIR__ . '/../view/error/404.phtml',
			'application/index/index'			=> __DIR__ . '/../view/index/index.phtml',
			'application/index/test'			=> __DIR__ . '/../view/index/test.phtml',
			'application/index/get-user-code'	=> __DIR__ . '/../view/index/get-user-code.phtml'
		)
	),
	'service_manager' => array(
		'factories' => array(
			'WxsDocumentManager' => 'Application\Service\Db\WxsDocumentManagerFactory',
		)
	)
);