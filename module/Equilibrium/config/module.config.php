<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Equilibrium\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'equilibrium' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/equilibrium-index/:values[/:mode]',
                    'constraints' => array(
                        'values' => '[0-9a-zA-Z,\-]+', // this is on purpose o_O
//                        'values' => '(-?[0-9]+,?)+', // very strict route
                        'mode' => 'strict', // very strict route
                    ),
                    'defaults'    => array(
                        'controller' => 'Equilibrium\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => [
            'Equilibrium' => 'Equilibrium\Service\Equilibrium'
        ],
        'factories' => [
          'Test' => function($serviceLocator) {
              $router  = $serviceLocator->get('router');
              $request = $serviceLocator->get('request');

                // Get the router match
              $routerMatch = $router->match($request);
              $class = new stdClass();
              $class->slug = $routerMatch->getParam('values');

              return $class;
          }
        ],
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Equilibrium' => 'Equilibrium\Service\Equilibrium',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Equilibrium\Controller\Index' => 'Equilibrium\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'equilibrium/index/index' => __DIR__ . '/../view/equilibrium/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'equilibrium' => __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
