<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'Promotion\Controller\IndexController' => 'Promotion\Controller\IndexController',
        	'smashing' => 'Promotion\Controller\SmashingController',
        	
        	/*************rest**************************/
        	'promotion-probability-check'=>'PromotionRest\Controller\ProbabilityCheckController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'promotion' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:websiteId/promotion/[:controller][/:action][/:id]',
                	'constraints' => array(
                		'websiteId' => '[a-z0-9]{24}',
                		'id' => '[a-z0-9]{24}',
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