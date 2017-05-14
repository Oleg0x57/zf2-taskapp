<?php
return [
    'db' => [
        'driver' => 'Pdo_Pgsql',
        'username' => 'postgres',
        'password' => 'root',
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=yiitask',
        /*'driver_options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],*/
    ],
    'service_manager' => [
        'factories' => [
            'Task\Mapper\TaskMapperInterface' => 'Task\Factory\ZendDbSqlMapperFactory',
            'Task\Service\TaskServiceInterface' => 'Task\Factory\TaskServiceFactory',
            'Zend\Db\Adapter\AdapterInterface' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'task/index/index' => __DIR__ . '/../view/task/list/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            'Task\Controller\List' => 'Task\Factory\ListControllerFactory',
            'Task\Controller\Write' => 'Task\Factory\WriteControllerFactory',
            'Task\Controller\Delete' => 'Task\Factory\DeleteControllerFactory',
        ],
    ],
    'router' => [
        'routes' => [
            'task' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/task',
                    'defaults' => [
                        'controller' => 'Task\Controller\List',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'detail' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => 'Task\Controller\Write',
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'controller' => 'Task\Controller\Write',
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '\d+',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => 'Task\Controller\Delete',
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '\d+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];