<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'live-event-index'	=> 'LiveEvent\Controller\IndexController',
        	'lers-applicant'	=> 'LiveEventRest\Controller\ApplicantController'
        ),
    ),
//     'router' => array(
//         'routes' => array(
//             'live-event' => array(
//                 'type'    => 'segment',
//                 'options' => array(
//                     'route'    => '/:websiteId/live-event/[:controller][/:action][/:id]',
//                 	'constraints' => array(
//                 		'websiteId' => '[a-z0-9]{24}',
//                 		'id' => '[a-z0-9]+',
//                 	),
//                 	'defaults' => array(
//                 		'action' => 'index'
//                 	)
//                 ),
//             	'may_terminate' => true,
//             	'child_routes' => array(
// 					'wildcard' => array(
// 						'type' => 'wildcard'
// 					)
// 				)
//             ),
//         ),
//     ),
// 	'service_manager' => array(
// 		'invokables' => array(
// 			'live-event-index' => 'LiveEvent\Controller\IndexController'
// 		)
// 	),
	'view_manager' => array(
		'template_map' => array(
			'live-event/index/index'		=> __DIR__ . '/../view/index/index.phtml',
			'live-event/index/pre-event'	=> __DIR__ . '/../view/index/pre-event.phtml',
			'live-event/index/post-event'	=> __DIR__ . '/../view/index/post-event.phtml',
			'live-event/index/live-sign'	=> __DIR__ . '/../view/index/live-sign.phtml',
			'live-event/index/view-img'		=> __DIR__ . '/../view/index/view-img.phtml',
			
			'live-event/review/index'		=> __DIR__ . '/../view/assistance/index.phtml',
			'live-event/review/ending'		=> __DIR__ . '/../view/assistance/ending.phtml',
		)
	)
);