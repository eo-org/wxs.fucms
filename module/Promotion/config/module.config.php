<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'Promotion\Controller\IndexController' => 'Promotion\Controller\IndexController',
        	'smashing' => 'Promotion\Controller\SmashingController',
        	'assistance' => 'Promotion\Controller\AssistanceController',
        	'sn-info' => 'Promotion\Controller\SnInfoController',
        	
        	/*************rest**************************/
//         	'promotion-probability-check'=>'PromotionRest\Controller\ProbabilityCheckController',
        	'promotion-probability-check-smashing'	=> 'PromotionRest\Controller\ProbabilityCheck\SmashingController',
        	'promotion-assistance'	=> 'PromotionRest\Controller\AssistanceController',
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
        ),
    ),
	'service_manager' => array(
		'invokables' => array(
// 			'Promotion\Service\DrawCheck' => 'Promotion\Service\DrawCheck',
			'Promotion\Service\DrawCheck\Smashing' => 'Promotion\Service\DrawCheck\Smashing'
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'promotion/smashing/index'			=> __DIR__ . '/../view/smashing/index.phtml',
			'promotion/smashing/inactive'		=> __DIR__ . '/../view/smashing/inactive.phtml',
			'promotion/smashing/ending'			=> __DIR__ . '/../view/smashing/ending.phtml',
			'promotion/sn-info/index'			=> __DIR__ . '/../view/sn-info/index.phtml',
			
			'promotion/assistance/index'		=> __DIR__ . '/../view/assistance/index.phtml',
			'promotion/assistance/ending'		=> __DIR__ . '/../view/assistance/ending.phtml',
		)
	)
);