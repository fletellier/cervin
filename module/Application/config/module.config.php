<?php
namespace Application;
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Page' => 'Application\Controller\PageController',
            'Admin' => 'Admin\Controller\AdminController',
        	'Chantier' => 'Application\Controller\ChantierController',
            'Export' => 'Application\Controller\ExportController',
            'ClientTest' => 'Application\Controller\ClientTestController',
        	'ExportClass' => 'Application\WebService\ExportClass',
            'ExportREST' => 'Application\Controller\ExportRESTController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'page' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                // 'priority' => 1000,
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Page',
                        'action'     => 'voir',
                        'slug'       => 'accueil',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'voir' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => ':slug',
                            'constraints' => array(
                                'slug'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Page',
                                'action'     => 'voir',
                            ),
                        ),
                    ),
                    'modifier' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => 'modifier/:slug',
                            'constraints' => array(
                                'slug'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Page',
                                'action'     => 'modifier',
                            ),
                        ),
                    ),
                ),
            ),

            'export' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/export',
                    'defaults' => array(
                        'controller' => 'Export',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'parcours' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/export',
                            'defaults' => array(
                                'controller' => 'Export',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),

            'rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ExportREST',
                    ),
                ),
            ),
            
            'client-test' => array(
            	'type' => 'Zend\Mvc\Router\Http\Literal',
            	'options' => array(
            		'route' => '/client-test',
            		'defaults' => array(
            			'controller' => 'ClientTest',
            			'action'     => 'index',
            		),
            	),
            	'may_terminate' => true,
           	),
            
            'chantier' => array(
            	'type' => 'Zend\Mvc\Router\Http\Literal',
            	'options' => array(
            		'route' => '/chantier',
            		'defaults' => array(
            			'controller' => 'Chantier',
            			'action'     => 'index',
            			'slug'       => 'chantier',
            		),
            	),
            	'may_terminate' => true,
            	'child_routes' => array(
            		'demarrerChantierElement' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '/demarrerChantierElement/:idElement/:idUser',
            				'constraints' => array(
            					'idElement'     => '[0-9]+',
            					'idUser'     	=> '[0-9]+',
            				),
            				'defaults' => array(
            					'controller' => 'Chantier',
            					'action'     => 'demarrerChantierElement',
            				),
            			),
            		),
            		'terminerChantierElement' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '/terminerChantierElement/:idElement/:idUser/:return',
            				'constraints' => array(
            					'idElement'     => '[0-9]+',
            					'idUser'     	=> '[0-9]+',
            					'return'     	=> 'perso|admin|element',
            				),
            				'defaults' => array(
            					'controller' => 'Chantier',
            					'action'     => 'terminerChantierElement',
            				),
            			),
            		),
            		'demarrerChantierSousParcours' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '/demarrerChantierSousParcours/:idSousParcours/:idUser/:return[/:idReturn]',
            				'constraints' => array(
            					'idSousParcours'    => '[0-9]+',
            					'idUser'     		=> '[0-9]+',
            				),
            				'defaults' => array(
            					'controller' => 'Chantier',
            					'action'     => 'demarrerChantierSousParcours',
            					'return'     => 'parcours|scene|transition',
            					'idReturn'	 => '[0-9]+'
            				),
            			),
            		),
            		'terminerChantierSousParcours' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '/terminerChantierSousParcours/:idSousParcours/:idUser/:return',
            				'constraints' => array(
            					'idSousParcours'    => '[0-9]+',
            					'idUser'    	 	=> '[0-9]+',
            					'return'     		=> 'perso|admin|sousparcours',
            				),
            				'defaults' => array(
            					'controller' => 'Chantier',
            					'action'     => 'terminerChantierSousParcours',
            				),
            			),
            		),
            		'admin' => array(
            			'type' => 'Segment',
            			'options' => array(
            				'route' => '/admin',
            				'defaults' => array(
            					'controller' => 'Chantier',
            					'action'     => 'admin',
            				),
            			),
            		),
            	),
            ),
            
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                // 'priority' => 1000,
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'gestion-users' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/gestion-users',
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'editusers',
                            ),
                        ),
                    ),
                    'changeUserAjax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/changeUserAjax[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'changeUserAjax',
                            ),
                        ),
                    ),
                    'changeProfileInfosAjax' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/changeProfileInfosAjax',
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'changeProfileInfosAjax',
                            ),
                        ),
                    ),
                    'demandeRole' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/demandeRole[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'demandeRole',
                            ),
                            
                        ),
                        
                    ),
                    'refueRole' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/refueRole[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin',
                                'action'     => 'refueRole',
                            ),
                            
                        ),
                        
                    ),
                    'logs' => array(
                    		'type' => 'Zend\Mvc\Router\Http\Literal',
                    		'options' => array(
                    				'route' => '/logs',
                    				'defaults' => array(
                    						'controller' => 'Admin',
                    						'action'     => 'showLogs',
                    				),
                    		),
                    ),
                    'ajouter-utilisateur' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                    'route' => '/ajouter-utilisateur',
                                    'defaults' => array(
                                            'controller' => 'Admin',
                                            'action'     => 'AjouterUtilisateur',
                                    ),
                            ),
                    ),                    
                    'revert-object' => array(
                    		'type' => 'Zend\Mvc\Router\Http\Literal',
                    		'options' => array(
                    				'route' => '/revert-object',
                    				'defaults' => array(
                    						'controller' => 'Admin',
                    						'action'     => 'RevertObjectAjax',
                    				),
                    		),
                    ),
                ),
            ),
            
        ),
    ),
    'navigation' => array(
        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(
            // And finally, here is where we define our page hierarchy
            'admin' => array(
                'label' => 'Admin',
                'route' => 'page',
                'pages' => array(
                    'home' => array(
                        'label' => 'Admin',
                        'route' => 'admin',
                    ),
                    'gestion-users' => array(
                        'label' => 'Gestion des utilisateurs',
                        'route' => 'admin/gestion-users',
                    ),
                    'logs' => array(
                        'label' => 'Gestion des logs',
                        'route' => 'admin/logs',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'                   => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'                       => __DIR__ . '/../view/error/404.phtml',
            'error/403'                       => __DIR__ . '/../view/error/403.phtml',
            'error/index'                     => __DIR__ . '/../view/error/index.phtml',
            'admin/admin/editusers'           => __DIR__ . '/../view/Admin/Admin/editusers.phtml',
            'admin/admin/ajouter-utilisateur' => __DIR__ . '/../view/Admin/Admin/ajouter-utilisateur.phtml',
            'admin/admin/show-logs'           => __DIR__ . '/../view/Admin/Admin/show-logs.phtml',
            'application/page/voir'           => __DIR__ . '/../view/application/page/voir.phtml',
            'application/page/modifier'       => __DIR__ . '/../view/application/page/modifier.phtml',
            'chantier'						  => __DIR__ . '/../view/application/chantier/index.phtml',
            'chantier/admin'				  => __DIR__ . '/../view/application/chantier/admin.phtml'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
            'Application' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(

                	// https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/zendframework2.md
                    // pick any listeners you need
                    //'Gedmo\Tree\TreeListener',
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\Sluggable\SluggableListener',
                    //'Gedmo\Loggable\LoggableListener',
                    //'Gedmo\Sortable\SortableListener'

                    // Listener pour le préfixe des tables ( constante dans la configuration globale )
    				'Application\Library\TablePrefix',
                ),
            ),
        ),
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/SamUser/Entity',
            ),
            'users_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/SamUser/Entity')
            ),
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                        __DIR__ . '/../src/Application/Entity',
                )
            ),
            'Loggable_driver' => array(
            		'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            		'cache' => 'array',
            		'paths' => array(
            				'vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity',
            		),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'SamUser\Entity' => 'zfcuser_entity',
                    'Application\Entity' => 'Application_driver',
                    'Gedmo\Loggable\Entity' => 'Loggable_driver',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'SamUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),
    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
    ),
    'data-fixture' => array(
        'Roles_fixture' => __DIR__ . '/../src/SamUser/Fixture',
        'Pages_fixture' => __DIR__ . '/../src/Application/Fixture',
    ),

);
