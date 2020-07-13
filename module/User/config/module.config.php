<?php

declare(strict_types=1);

namespace User;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use User\Controller\AlbumController;

return [ 
	'router' => [
		'routes' => [

			'home' => [
				'type' => Literal::class,
				'options' => [
					'route'    => '/',
					'defaults' => [
						'controller' => Controller\AlbumController::class,
						'action'     => 'index',
					],
				],
			],
			// this is a signup dummy page for practice.
			'signup' => [ 

				'type' => Literal::class, // /literal will help to make route /signup
				'options' => [
					'route' => '/signup',
					'defaults' => [
						'controller' => Controller\AuthController::class,
						'action' => 'create'
					],
				],

			],
			// this is Album route containing Create/Update/delete operations.
			'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
		],
	],

	'controllers' => [
		'factories' => [
        Controller\AuthController::class => InvokableFactory::class,
    	],

	],
	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => [
			'auth/create' => __DIR__. '/../view/user/auth/create.phtml',
			'album' => __DIR__. '/../view/user/album/index.phtml',
		],
		'template_path_stack' => [
			'user' => __DIR__ . '/../view'
        ]
	]
];

