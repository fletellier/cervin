<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'zfcuser' => 'ZfcUser\Controller\UserController',
            'Admin' => 'Admin\Controller\AdminController',
        ),
    ),
    'bjyauthorize' => array(

        // set the 'Visiteur' role as default (must be defined in a role provider)
        'default_role' => 'Visiteur',

        'authenticated_role'    => 'Utilisateur',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'SamUser\Entity\Role',
            ),
        ),
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'Admin' => array(),
            	'Modeleur' => array(),
                'Parcours' => array(),
                'Collection' => array(),
                'Utilisateur' => array(),
                //'pants' => array(),
            ),
        ),
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    //array(array('guest', 'user'), 'pants', 'wear'),
                    array(array('Admin'), 'Admin'),
                    array(array('Modeleur'), 'Modeleur'),
                    array(array('Parcours'), 'Parcours'),
                    array(array('Collection'), 'Collection'),
                    array(array('Utilisateur'), 'Utilisateur'),
                ),

                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => array(
                    // ...
                ),
            ),
        ),
        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions unless they are specified here.
             * You may omit the 'action' index to allow access to the entire controller
             */
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'Album\Controller\Album',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Page',
                    'action' => 'index',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Page',
                    'action' => 'voir',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Page',
                    'roles' => array('Admin')
                ),

                array(
                    'controller' => 'Export',
                    'roles' => array('Visiteur')
                ),
                    
                array(
                    'controller' => 'ExportREST',
                    'roles' => array('Visiteur')
                ),
            		
            	array(
            		'controller' => 'ClientTest',
            		'roles' => array('Visiteur')
            	),
            		
            	array(
            		'controller' => 'Chantier',
            		'roles' => array('Collection')
            	),

                array(
                    'controller' => 'zfcuser',
                    'roles' => array()
                ),
                array(
                    'controller' => 'zfcuser',
                    'action' => 'register', 
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Admin',
                    'roles' => array('Admin')
                ),
                array(
                    'controller' => 'Admin',
                    'action' => 'demandeRole', 
                    'roles' => array('Utilisateur')
                ),

                array(
                    'controller' => 'Admin',
                    'action' => 'refueRole', 
                    'roles' => array('Admin')
                ),
            		
                array(
                    'controller' => 'typeElement',
                    'roles' => array('Modeleur')
                ),

                array(
                    'controller' => 'ChampSelect',
                    'roles' => array('Modeleur')
                ),

            	array(
            		'controller' => 'Collection',
            		'roles' => array('Visiteur')
            	),
            		
            	array(
            		'controller' => 'Element',
            		'roles' => array('Visiteur')
            	),
            		
            	array(
            		'controller' => 'Relation',
            		'roles' => array('Collection')
            	),
                
                array(
                    'controller' => 'Parcours',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Scene',
                    'roles' => array('Visiteur')
                ),
            		
            	array(
            		'controller' => 'Transition',
            		'roles' => array('Visiteur')
            	),

                array(
                    'controller' => 'fileupload_examples',
                    'roles' => array('Visiteur')
                ),
                array(
                    'controller' => 'fileupload_prgexamples',
                    'roles' => array('Visiteur')
                ),
                array(
                    'controller' => 'fileupload_progressexamples',
                    'roles' => array('Visiteur')
                ),

                array(
                    'controller' => 'Semantique',
                    'roles' => array('Modeleur')
                ),
            		
            	array(
            		'controller' => 'SemantiqueTransition',
            		'roles' => array('Admin')
            	),
            ),

            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'album', 'roles' => array('Visiteur')),

                array('route' => 'admin', 'roles' => array('Admin')),
                array('route' => 'admin/gestion-users', 'roles' => array('Admin')),
                array('route' => 'admin/changeUserAjax', 'roles' => array('Admin')),
				array('route' => 'admin/changeProfileInfosAjax', 'roles' => array('Utilisateur')),
                array('route' => 'admin/demandeRole', 'roles' => array('Utilisateur')),
                array('route' => 'admin/refueRole', 'roles' => array('Admin')),
                array('route' => 'admin/logs', 'roles' => array('Admin')),
                array('route' => 'admin/ajouter-utilisateur', 'roles' => array('Admin')),
                array('route' => 'admin/revert-object', 'roles' => array('Admin')),

                array('route' => 'page', 'roles' => array('Visiteur')),
                array('route' => 'page/voir', 'roles' => array('Visiteur')),
                array('route' => 'page/modifier', 'roles' => array('Admin')),

                //array('route' => 'export', 'roles' => array('Visiteur')),
                //array('route' => 'export/parcours', 'roles' => array('Visiteur')),
                //array('route' => 'client-test', 'roles' => array('Visiteur')),

                //array('route' => 'rest', 'roles' => array('Visiteur')),

            	array('route' => 'chantier', 'roles' => array('Collection')),
            	array('route' => 'chantier/admin', 'roles' => array('Admin')),
            	array('route' => 'chantier/demarrerChantierElement', 'roles' => array('Collection')),
            	array('route' => 'chantier/terminerChantierElement', 'roles' => array('Collection')),
            	array('route' => 'chantier/demarrerChantierSousParcours', 'roles' => array('Parcours')),
            	array('route' => 'chantier/terminerChantierSousParcours', 'roles' => array('Parcours')),
            		
                array('route' => 'zfcuser', 'roles' => array('Utilisateur')),
                array('route' => 'zfcuser/logout', 'roles' => array('Visiteur')),
                array('route' => 'zfcuser/login', 'roles' => array('Visiteur')),
                array('route' => 'zfcuser/register', 'roles' => array('Visiteur')),
                array('route' => 'zfcuser/changepassword', 'roles' => array('Utilisateur')),
                array('route' => 'zfcuser/changeemail', 'roles' => array('Utilisateur')),
                
                array('route' => 'typeElement', 'roles' => array('Modeleur')),
                array('route' => 'typeElement/add', 'roles' => array('Modeleur')),
                array('route' => 'typeElement/editTypeElementAjax', 'roles' => array('Modeleur')),

                array('route' => 'champSelect', 'roles' => array('Modeleur')),
                array('route' => 'champSelect/ajouter', 'roles' => array('Modeleur')),
                array('route' => 'champSelect/modifier', 'roles' => array('Modeleur')),
                array('route' => 'champSelect/modifierOptionAjax', 'roles' => array('Modeleur')),

            	array('route' => 'collection', 'roles' => array('Visiteur')),
				array('route' => 'collection/consulter', 'roles' => array('Visiteur')),
            		
				array('route' => 'element/changerVisibilite', 'roles' => array('Collection')),
				array('route' => 'element/ajouter', 'roles' => array('Collection')),
				array('route' => 'element/voir', 'roles' => array('Visiteur')),
				array('route' => 'element/editer', 'roles' => array('Collection')),
				array('route' => 'element/supprimer', 'roles' => array('Collection')),
            		
            	array('route' => 'relation/addRelationArtefactMedia', 'roles' => array('Collection')),
            	array('route' => 'relation/addRelationMediaArtefact', 'roles' => array('Collection')),
            	array('route' => 'relation/supprimerRelationMediaArtefact', 'roles' => array('Collection')),
            	array('route' => 'relation/addRelationArtefactSemantique', 'roles' => array('Collection')),
            	array('route' => 'relation/supprimerRelationArtefactSemantique', 'roles' => array('Collection')),
            	array('route' => 'relation/getAllArtefact', 'roles' => array('Collection')),
            	array('route' => 'relation/getAllMedia', 'roles' => array('Collection')),
            		
                array('route' => 'semantique', 'roles' => array('Modeleur')),
                array('route' => 'semantique/ajouter', 'roles' => array('Modeleur')),
                array('route' => 'semantique/supprimer', 'roles' => array('Modeleur')),
                array('route' => 'semantique/modifier', 'roles' => array('Modeleur')),

                array('route' => 'fileupload', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/single', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/success', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/multi-html5', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/collection', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/partial', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg/multi-html5', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/prg/fieldset', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session_partial', 'roles' => array('Visiteur')),
                array('route' => 'fileupload/progress/session-progress', 'roles' => array('Visiteur')),

                array('route' => 'parcours', 'roles' => array('Visiteur')),
                array('route' => 'parcours/voir', 'roles' => array('Visiteur')),
                array('route' => 'parcours/ajouter', 'roles' => array('Parcours')),
                array('route' => 'parcours/supprimer', 'roles' => array('Parcours')),
                array('route' => 'parcours/modifier', 'roles' => array('Parcours')),

                array('route' => 'parcours/voirParcourHalviz', 'roles' => array('Visiteur')),
                array('route' => 'parcours/ajouterSousParcours', 'roles' => array('Parcours')),
                array('route' => 'parcours/supprimerSousParcours', 'roles' => array('Parcours')),
                array('route' => 'parcours/editSousParcours', 'roles' => array('Parcours')),
                array('route' => 'parcours/changerVisibilite', 'roles' => array('Parcours')),
                array('route' => 'parcours/export', 'roles' => array('Parcours')),

            	array('route' => 'semantiquetransition', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/ajouter', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/modifier', 'roles' => array('Admin')),
            	array('route' => 'semantiquetransition/supprimer', 'roles' => array('Admin')),

                array('route' => 'scene', 'roles' => array('Visiteur')),
                array('route' => 'scene/voirScene', 'roles' => array('Visiteur')),
                array('route' => 'scene/retirerSceneSecondaire', 'roles' => array('Parcours')),
                array('route' => 'scene/removeScene', 'roles' => array('Parcours')),
                array('route' => 'scene/creerSceneSecondaire', 'roles' => array('Parcours')),
                array('route' => 'scene/insererSceneRecommandee', 'roles' => array('Parcours')),
                array('route' => 'scene/retirerSceneRecommandee', 'roles' => array('Parcours')),
                array('route' => 'scene/editScene', 'roles' => array('Parcours')),
                array('route' => 'scene/deleteElement', 'roles' => array('Parcours')),
                array('route' => 'scene/getAllElement', 'roles' => array('Parcours')),
                array('route' => 'scene/addRelationSceneElement', 'roles' => array('Parcours')),
            		
            	array('route' => 'transition/voir', 'roles' => array('Visiteur')),
            	array('route' => 'transition/modifier', 'roles' => array('Parcours')),
            	array('route' => 'transition/supprimerTransitionSec', 'roles' => array('Parcours')),
            	array('route' => 'transition/ajouterTransitionSec', 'roles' => array('Parcours')),
            ),
        ), 
    ),
);
