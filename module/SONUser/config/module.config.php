<?php
    namespace SONUser;

    return array(
        'router' => array(
            'routes' => array(
                'home' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/',
                        'defaults' => array(
                            '__NAMESPACE__' => 'SONUser\Controller',
                            'controller' => 'Index',
                            'action' => 'index',
                        )
                    )
                ),
                'create-user' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/user/create',
                        'defaults' => array(
                            '__NAMESPACE__' => 'SONUser\Controller',
                            'controller' => 'Index',
                            'action' => 'create',
                        )
                    )
                ),
                'list-user' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/user/list',
                        'defaults' => array(
                            '__NAMESPACE__' => 'SONUser\Controller',
                            'controller' => 'Index',
                            'action' => 'list'
                        )
                    )
                ),
                'change-user' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route'    => '/user/[:action]/[:id]',
                        'defaults' => array(
                            '__NAMESPACE__' => 'SONUser\Controller',
                            'controller' => 'Index'
                        )
                    )
                )
            )
        ),
        'controllers' => array(
            'invokables' => array(
                'SONUser\Controller\Index' => 'SONUser\Controller\IndexController',
            )
        ),
        'view_manager' => array(
            'display_not_found_reason' => true,
            'display_exceptions' => true,
            'doctype' => 'HTML5',
            'not_found_template' => 'error/404',
            'exception_template' => 'error/index',
            'template_map' => array(
                'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                'error/404' => __DIR__ . '/../view/error/404.phtml',
                'error/index' => __DIR__ . '/../view/error/index.phtml',
            ),
            'template_path_stack' => array(
                __DIR__ . '/../view',
            ),
        ),
        'doctrine' => array(
            'driver' => array(
                __NAMESPACE__ . '_driver' => array(
                    'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => array(
                        __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                    )
                ),
                'orm_default' => array(
                    'drivers' => array(
                        __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                    )
                )
            ),
            'fixture' => array(
                'SONUser_fixture' => __DIR__ . '/../src/SONUser/Fixture',
            )
        )
    );