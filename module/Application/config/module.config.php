<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'Application\Controller\IndexController' => 'Application\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
        	'surrogate' => array(
        		'type'    => 'literal',
        		'options' => array(
        			'route'    => '/',
        			'defaults' => array(
        				'controller'    => 'Application\Controller\IndexController',
        				'action'        => 'surrogate',
        			)
        		),
        		'may_terminate' => true,
        	),
            'application' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:websiteId',
                    'defaults' => array(
                        'controller'    => 'Application\Controller\IndexController',
                        'action'        => 'index',
                    ),
                	'constraints' => array(
                		'websiteId' => '[a-z0-9]{24}',
					)
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
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
			'application/index/surrogate'		=> __DIR__ . '/../view/index/surrogate.phtml',
		)
	),
	'service_manager' => array(
		'factories' => array(
			'WxsDocumentManager' => 'Application\Service\Db\WxsDocumentManagerFactory',
		)
	)
);