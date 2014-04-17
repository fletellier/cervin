<?php

namespace Core;

return array(
    'controllers' => array(
        'invokables' => array(
            'typeElement' => 'Collection\Controller\TypeElementController',
            'Collection' => 'Collection\Controller\CollectionController',
        	'Element' => 'Collection\Controller\ElementController',
        	'Relation' => 'Collection\Controller\RelationController',
            'Semantique' => 'Collection\Controller\SemantiqueController',
            'Parcours' => 'Parcours\Controller\ParcoursController',
            'SemantiqueTransition' => 'Parcours\Controller\SemantiqueTransitionController',
            'Scene' => 'Parcours\Controller\SceneController',
            'Transition' => 'Parcours\Controller\TransitionController',
            'ChampSelect' => 'Collection\Controller\ChampSelectController',
        ),
    ),
    'router' => array(
        'routes' => array(
            
            'typeElement' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/typeElement',
                    'defaults' => array(
                        'controller' => 'typeElement',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/add[/:media-artefact]',
                            'constraints' => array(
                                'media-artefact'     => 'media|artefact',
                            ),
                            'defaults' => array(
                                'controller' => 'typeElement',
                                'action'     => 'add',
                            ),
                        ),
                    ),
                    'editTypeElementAjax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/editTypeElementAjax[/:id][/:idChamp]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'idChamp'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'typeElement',
                                'action'     => 'editTypeElementAjax',
                            ),
                        ),
                    ),
                ),
            ),

            'champSelect' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/champSelect',
                    'defaults' => array(
                        'controller' => 'ChampSelect',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajouter' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ajouter',
                            'defaults' => array(
                                'controller' => 'ChampSelect',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                    'modifier' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifier/[:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'ChampSelect',
                                'action'     => 'modifier',
                            ),
                        ),
                    ),
                    'modifierOptionAjax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifierOptionAjax/[:id][/:idOption]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'idOption'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'ChampSelect',
                                'action'     => 'modifierOptionAjax',
                            ),
                        ),
                    ),
                ),
            ),

            'collection' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/collection',
                    'defaults' => array(
                        'controller' => 'Collection',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'consulter' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/consulter',
                            'defaults' => array(
                                'controller' => 'Collection',
                                'action'     => 'consulter',
                            ),
                        ),
                    ),
                ),
            ),
            
            'relation' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/relation',
                    'defaults' => array(
                        'controller' => 'Relation',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                	'addRelationArtefactSemantique' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/addRelationArtefactSemantique/[:idOrigine]/[:idDestination]/[:idSemantique]',
                			'constraints' => array(
                				'idSemantique'  => '[0-9]+',
                				'idDestination' => '[0-9]+',
                				'idOrigine'     => '[0-9]+'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'addRelationArtefactSemantique',
                			),
                		),
                	),
                	'supprimerRelationArtefactSemantique' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/supprimerRelationArtefactSemantique/:idRelation',
                			'constraints' => array(
                				'idRelation'  => '[0-9]+'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'supprimerRelationArtefactSemantique',
                			),
                		),
                	),
                	'addRelationArtefactMedia' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/addRelationArtefactMedia/:idMedia',
                			'constraints' => array(
                				'idMedia' => '[0-9]+'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'addRelationArtefactMedia',
                			),
                		),
                	),
                	'addRelationMediaArtefact' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/addRelationMediaArtefact/:idArtefact',
                			'constraints' => array(
                				'idArtefact' => '[0-9]+'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'addRelationMediaArtefact',
                			),
                		),
                	),
                	'supprimerRelationMediaArtefact' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/supprimerRelationMediaArtefact/:idArtefact/:idMedia',
                			'constraints' => array(
                				'idArtefact' => '[0-9]+',
                				'idMedia' => '[0-9]+'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'supprimerRelationMediaArtefact',
                			),
                		),
                	),
                	'getAllArtefact' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/getAllArtefact/:type_origine',
                			'constraints' => array(
                				'type_origine' => 'media|artefact'
                			),
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'getAllArtefact',
                			),
                		),
                	),
                	'getAllMedia' => array(
                		'type' => 'Zend\Mvc\Router\Http\Literal',
                		'options' => array(
                			'route' => '/getAllMedia',
                			'defaults' => array(
                				'controller' => 'Relation',
                				'action'     => 'getAllMedia',
                			),
                		),
                	),
                ),
            ),

        	'element' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route' => '/element',
        			'defaults' => array(
        				'controller' => 'Element',
        				'action'     => 'index',
        			),
        		),
        		'may_terminate' => true,
        		'child_routes' => array(
        			'changerVisibilite' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '/changerVisibilite/:id/:return',
        					'constraints' => array(
        						'id'     => '[0-9]+',
        						'return' => 'editer|voir'
        					),
        					'defaults' => array(
        						'controller' => 'Element',
        						'action'     => 'changerVisibilite',
        					),
        				),
        			),
        			'ajouter' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '/ajouter/:type[/:type_element_id]',
        					'constraints' => array(
        						'type'				=> 'media|artefact',
        						'type_element_id' 	=> '[0-9]+'
        					),
        					'defaults' => array(
        						'controller' => 'Element',
        						'action'     => 'ajouter',
        					),
        				),
        			),
        			'voir' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '/voir/:id',
        					'constraints' => array(
        						'id'     => '[0-9]+',
        					),
        					'defaults' => array(
        						'controller' => 'Element',
        						'action'     => 'voir',
        					),
        				),
        			),
        			'editer' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '/editer/:id[/:idData]',
        					'constraints' => array(
        						'id'     => '[0-9]+',
        						'idData' => '([0-9]+|new)',
        					),
        					'defaults' => array(
        						'controller' => 'Element',
        						'action'     => 'editer',
        					),
        				),
        			),
        			'supprimer' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '/supprimer/:id',
        					'constraints' => array(
        						'id'     => '[0-9]+',
        					),
        					'defaults' => array(
        						'controller' => 'Element',
        						'action'     => 'supprimer',
        					),
        				),
        			),
        					
        		),
        	),
        		
            'semantique' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/semantique',
                    'defaults' => array(
                        'controller' => 'Semantique',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajouter' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/ajouter',
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                    'supprimer' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/supprimer/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'supprimer',
                            ),
                        ),
                    ),
                    'modifier' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifier/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Semantique',
                                'action'     => 'modifier',
                            ),
                        ),
                    ),
                ),
            ),

            'parcours' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/parcours',
                    'defaults' => array(
                        'controller' => 'Parcours',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'voir' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voir[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'voir',
                            ),
                        ),
                    ),
                	'voirParcourHalviz' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/voirParcourHalviz/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'voirParcourHalviz',
                			),
                		),
                	),
                    'ajouter' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ajouter',
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'ajouter',
                            ),
                        ),
                    ),
                	'supprimer' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/supprimer/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'supprimer',
                			),
                		),
                	),
                	'changerVisibilite' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/changerVisibilite/:id/:return',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                				'return' => 'index|voir'
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'changerVisibilite',
                			),
                		),
                	),
                    'modifierTransition' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifierTransition/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'modifierTransition',
                            ),
                        ),
                    ),
                	'supprimerTransitionSec' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/supprimerTransitionSec/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'supprimerTransitionSec',
                			),
                		),
                	),
                	'ajouterTransitionSec' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/ajouterTransitionSec',
                			'constraints' => array(
                				),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'ajouterTransitionSec',
                			),
                		),
                	),
                    'modifier' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/modifier/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'modifier',
                            ),
                        ),
                    ),
                    'voirParcourHalviz' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voirParcourHalviz[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'voirParcourHalviz',
                            ),
                        ),
                    ),
                    'ajouterSousParcours' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ajouterSousParcours/:type/:idsp',
                            'constraints' => array(
                                'type'     => 'ajAvant|ajApres',
                                'idsp'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Parcours',
                                'action'     => 'ajouterSousParcours',

                            ),
                        ),
                    ),
                	'supprimerSousParcours' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/supprimerSousParcours/:idsp',
                			'constraints' => array(
                				'idsp'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'supprimerSousParcours',
                			),
                		),
                	),
                	'editSousParcours' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/editSousParcours/:idsp',
                			'constraints' => array(
                				'idsp'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'editSousParcours',
                			),
                		),
                	),
                	'export' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/export/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Parcours',
                				'action'     => 'export',
                			),
                		),
                	),
                ),
            ),

            'semantiquetransition' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/semantiquetransition',
                        'defaults' => array(
                            'controller' => 'SemantiqueTransition',
                            'action'     => 'index',
                        ),
                    ),
                    'may_terminate' => true,
                    'child_routes' => array(
                        'ajouter' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route' => '/ajouter',
                                'defaults' => array(
                                    'controller' => 'SemantiqueTransition',
                                    'action'     => 'ajouter',
                                ),
                            ),
                        ),
                        'supprimer' => array(
                            'type' => 'segment',
                            'options' => array(
                                'route' => '/supprimer/:id',
                                'constraints' => array(
                                    'id'     => '[0-9]+',
                                ),
                                'defaults' => array(
                                    'controller' => 'SemantiqueTransition',
                                    'action'     => 'supprimer',
                                ),
                            ),
                        ),
                        'modifier' => array(
                            'type' => 'segment',
                            'options' => array(
                                'route' => '/modifier/:id',
                                'constraints' => array(
                                    'id'     => '[0-9]+',
                                ),
                                'defaults' => array(
                                    'controller' => 'SemantiqueTransition',
                                    'action'     => 'modifier',
                                ),
                            ),
                        ),
                    ),
                ),

            'scene' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/scene',
                    'defaults' => array(
                        'controller' => 'Scene',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'insererSceneRecommandee' => array(
                           	'type' => 'segment',
                           	'options' => array(
                                'route' => '/insererSceneRecommandee',
                                'defaults' => array(
                                    'controller' => 'Scene',
                                    'action'     => 'insererSceneRecommandee',
                                ),
                            ),
                        ),
                	'retirerSceneRecommandee' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/retirerSceneRecommandee/:id',
                			'constraints' => array(
                				'id'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Scene',
                				'action'     => 'retirerSceneRecommandee',
                			),
                		),
                	),
                    'voirScene' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/voir/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'voirScene',
                            ),
                        ),
                    ),
                	'creerSceneSecondaire' => array(
                		'type' => 'segment',
                		'options' => array(
                			'route' => '/creerSceneSecondaire/:idsp',
                			'constraints' => array(
                				'idsp'     => '[0-9]+',
                			),
                			'defaults' => array(
                				'controller' => 'Scene',
                				'action'     => 'creerSceneSecondaire',
                			),
                		),
                	),
                    'retirerSceneSecondaire' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/retirerSceneSecondaire/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'retirerSceneSecondaire',
                            ),
                        ),
                    ),
                    'editScene' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'editScene',
                            ),
                        ),
                    ),
                    'deleteElement' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/deleteElement/:idScene/:idElement',
                            'constraints' => array(
                                'idScene'     => '[0-9]+',
                                'idElement'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Scene',
                                'action'     => 'deleteElement',
                            ),
                        ),
                    ),
                	'getAllElement' => array(
                		'type' => 'Zend\Mvc\Router\Http\Literal',
                		'options' => array(
                				'route' => '/getAllElement',
                				'defaults' => array(
                						'controller' => 'Scene',
                						'action'     => 'getAllElement',
                				),
                		),
                	),
                	'addRelationSceneElement' => array(
                		'type' => 'segment',
                		'options' => array(
                				'route' => '/addRelationSceneElement[/:idElement]',
                				'constraints' => array(
                						'idElement' => '[0-9]+'
                				),
                				'defaults' => array(
                						'controller' => 'Scene',
                						'action'     => 'addRelationSceneElement',
                				),
                		),
                	),
                ),
            ),
        		
        		
        		'transition' => array(
        				'type' => 'Zend\Mvc\Router\Http\Literal',
        				'options' => array(
        						'route' => '/transition',
        						'defaults' => array(
        								'controller' => 'Transition',
        								'action'     => 'index',
        						),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        						'voir' => array(
        								'type' => 'segment',
        								'options' => array(
        										'route' => '/voir[/:id]',
        										'constraints' => array(
        												'id'     => '[0-9]+',
        										),
        										'defaults' => array(
        												'controller' => 'Transition',
        												'action'     => 'voir',
        										),
        								),
        						),
        						'modifier' => array(
        								'type' => 'segment',
        								'options' => array(
        										'route' => '/modifier/:id',
        										'constraints' => array(
        												'id'     => '[0-9]+',
        										),
        										'defaults' => array(
        												'controller' => 'Transition',
        												'action'     => 'modifier',
        										),
        								),
        						),
        						'supprimerTransitionSec' => array(
        								'type' => 'segment',
        								'options' => array(
        										'route' => '/supprimerTransitionSec/:id',
        										'constraints' => array(
        												'id'     => '[0-9]+',
        										),
        										'defaults' => array(
        												'controller' => 'Transition',
        												'action'     => 'supprimerTransitionSec',
        										),
        								),
        						),
        						'ajouterTransitionSec' => array(
        								'type' => 'segment',
        								'options' => array(
        										'route' => '/ajouterTransitionSec',
        										'constraints' => array(
        										),
        										'defaults' => array(
        												'controller' => 'Transition',
        												'action'     => 'ajouterTransitionSec',
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
            'parcours' => array(
                'label' => 'Parcours',
                'route' => 'page',
                'pages' => array(
                    'index' => array(
                        'label' => 'Liste',
                        'route' => 'parcours',
                    ),
                    'voir' => array(
                        'label' => 'Voir',
                        'route' => 'parcours/voir',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            
            'collection/collection/consulter'            => __DIR__ . '/../view/Collection/Collection/consulter.phtml',

            'collection/element/ajouter'                 => __DIR__ . '/../view/Collection/Element/ajouter.phtml',
            'collection/element/editer'                  => __DIR__ . '/../view/Collection/Element/editer.phtml',
            'collection/element/voir'                    => __DIR__ . '/../view/Collection/Element/voir.phtml',
                
            'collection/semantique/index'                => __DIR__ . '/../view/Collection/Semantique/index.phtml',
            'collection/semantique/ajouter'              => __DIR__ . '/../view/Collection/Semantique/ajouter.phtml',
            'collection/semantique/modifier'             => __DIR__ . '/../view/Collection/Semantique/modifier.phtml',
                
            'collection/type-element/index'              => __DIR__ . '/../view/Collection/Type-Element/index.phtml',
            'collection/type-element/add'                => __DIR__ . '/../view/Collection/Type-Element/add.phtml',
        		
            'collection/champ-select/index'              => __DIR__ . '/../view/Collection/Champ-Select/index.phtml',
            'collection/champ-select/modifierOptionAjax' => __DIR__ . '/../view/Collection/Champ-Select/modifierOptionAjax.phtml',

        	'parcours/semantique-transition/index'	     => __DIR__ . '/../view/Parcours/Semantique-Transition/index.phtml',
        	'parcours/semantique-transition/ajouter'     => __DIR__ . '/../view/Parcours/Semantique-Transition/ajouter.phtml',
        		
        	'parcours/parcours/index'		             => __DIR__ . '/../view/Parcours/Parcours/index.phtml',
        	'parcours/parcours/voir'		             => __DIR__ . '/../view/Parcours/Parcours/voir.phtml',
        	'parcours/parcours/ajouter'		             => __DIR__ . '/../view/Parcours/Parcours/ajouter.phtml',
        		
        	'parcours/scene/voir-scene'		             => __DIR__ . '/../view/Parcours/Scene/voir-scene.phtml',
        	'parcours/scene/edit-scene'		             => __DIR__ . '/../view/Parcours/Scene/edit-scene.phtml',
        	
        	'parcours/transition/voir'		             => __DIR__ . '/../view/Parcours/Transition/voir.phtml',
            'parcours/transition/modifier'               => __DIR__ . '/../view/Parcours/Transition/modifier.phtml',

        	'parcours/parcours/export'		             => __DIR__ . '/../view/Parcours/Parcours/export.phtml',
        ),
        'template_path_stack' => array(
            'Collection' => __DIR__ . '/../view',
        )
    ),
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            'Core_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                        __DIR__ . '/../src/Collection/Entity',
                        __DIR__ . '/../src/Parcours/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Collection\Entity' => 'Core_driver',
                    'Parcours\Entity' => 'Core_driver',
                )
            )
        )
    ),
    'data-fixture' => array(
            'Collection_fixture' => __DIR__ . '/../src/Collection/Fixture',
            'Parcours_fixture' => __DIR__ . '/../src/Parcours/Fixture'
    ),

);
