<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'Promotion\Controller\IndexController' => 'Promotion\Controller\IndexController',
        	'smashing' => 'Promotion\Controller\SmashingController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'promotion' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:websiteId/promotion/[:controller][/:action]',
                	'constraints' => array(
                		'websiteId' => '[a-z0-9]{24}',
                	),
                	'defaults' => array(
                		'action' => 'index'
                	)
                ),
            	'may_terminate' => true,
            	'child_routes' => array(
            	)
            ),
        	
        ),
    ),
	'view_manager' => array(
		'template_map' => array(
			'promotion/smashing/index'			=> __DIR__ . '/../view/smashing/index.phtml',
		)
	)
);