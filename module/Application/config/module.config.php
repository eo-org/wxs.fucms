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
        	'wxs' => array(
        		'type'    => 'segment',
        		'options' => array(
        			'route'    => '/:websiteId/[:controller][/:action][/:id]',
       				'constraints' => array(
        				'websiteId' => '[a-z0-9]{24}',
        				'id' => '[a-z0-9]+',
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
        	),
        	'wxsrs' => array (
				'type' => 'literal',
				'options' => array (
					'route' => '/wxsrs'
				),
				'may_terminate' => true,
				'child_routes' => array (
					'restroutes' => array (
						'type' => 'segment',
						'options' => array (
							'route' => '[/:websiteId][/:controller].json[/:id]',
							'constraints' => array (
								'websiteId' => '[a-z0-9]{24}',
								'controller' => '[a-z-]*',
								'id' => '[A-Za-z0-9-_]*'
							),
							'defaults' => array(
								'format' => 'json'
							)
						)
					)
				)
			),        	
        ),
    ),
	'controller_plugins' => array(
		'invokables' => array(
			'formatData' => 'Core\Controller\Plugin\FormatData',
			'formatData2' => 'Core\Controller\Plugin\FormatData2'
		)
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
		),
		'strategies' => array(
			'ViewJsonStrategy',
		)
	),
	'service_manager' => array(
		'invokables' => array(
			'Application\Service\CmsSiteService' => 'Application\Service\CmsSiteService',
			'Application\Service\JsSignatureService' => 'Application\Service\JsSignatureService',
			'Promotion\Service\DrawCheck' => 'Promotion\Service\DrawCheck'
		),
		'factories' => array(
			'DocumentManager' => 'Application\Service\Db\DocumentManagerFactory',
			'WxsDocumentManager' => 'Application\Service\Db\WxsDocumentManagerFactory',
		)
	),
	'view_helpers' => array(
		'invokables' => array(
			'path' => 'Application\View\Helper\Path',
		)
	),
);