<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'file-index'	=> 'File\Controller\IndexController',
        	'fr-file'		=> 'FileRest\Controller\FileController',
        	'fr-qs-token'	=> 'FileRest\Controller\QsTokenController'
        ),
    ),
	'router' => array(
		'routes' => array(
			'file' => array(
				'type'    => 'segment',
				'options' => array(
					'route'    => '/:websiteId/:resourceType/:resourceId/:openId',
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
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'file/index/index'		=> __DIR__ . '/../view/index/index.phtml'
		)
	)
);