<?php
return array(
	'controllers' => array(
        'invokables' => array(
        	'le-index'			=> 'LiveEvent\Controller\IndexController',
        	'le-applicant'		=> 'LiveEvent\Controller\ApplicantController',
        	'le-vote-candidate'	=> 'LiveEvent\Controller\VoteCandidateController',
        	
        	'lers-applicant'		=> 'LiveEventRest\Controller\ApplicantController',
        	'lers-vote-candidate'	=> 'LiveEventRest\Controller\VoteCandidateController',
        	'lers-vote-ticket'		=> 'LiveEventRest\Controller\VoteTicketController'
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
			'live-event/index/sign-button'	=> __DIR__ . '/../view/index/view-sign-up-button.phtml',
			'live-event/index/sign-up'		=> __DIR__ . '/../view/index/sign-up.phtml',
			'live-event/index/success'		=> __DIR__ . '/../view/index/success.phtml',
			'live-event/index/apply'		=> __DIR__ . '/../view/index/apply.phtml',
			
//			'live-event/review/index'		=> __DIR__ . '/../view/assistance/index.phtml',
//			'live-event/review/ending'		=> __DIR__ . '/../view/assistance/ending.phtml',
			
			'live-event/applicant/index'		=> __DIR__ . '/../view/applicant/index.phtml',
			'live-event/applicant/success'		=> __DIR__ . '/../view/applicant/success.phtml',
			'live-event/applicant/wait-approve'	=> __DIR__ . '/../view/applicant/wait-approve.phtml',
			
			'live-event/vote-candidate/edit'	=> __DIR__ . '/../view/vote-candidate/edit.phtml',
		)
	)
);