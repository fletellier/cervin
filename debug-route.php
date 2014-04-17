Configuration:
Array
(
    [ZFTool] => Array
        (
            [disableUsage] => 
        )

    [service_manager] => Array
        (
            [factories] => Array
                (
                    [translator] => Zend\I18n\Translator\TranslatorServiceFactory
                    [Navigation] => Zend\Navigation\Service\DefaultNavigationFactory
                )

            [aliases] => Array
                (
                    [zfcuser_zend_db_adapter] => Zend\Db\Adapter\Adapter
                )

        )

    [controllers] => Array
        (
            [invokables] => Array
                (
                    [ZFTool\Controller\Info] => ZFTool\Controller\InfoController
                    [ZFTool\Controller\Module] => ZFTool\Controller\ModuleController
                    [ZFTool\Controller\Classmap] => ZFTool\Controller\ClassmapController
                    [ZFTool\Controller\Create] => ZFTool\Controller\CreateController
                    [ZFTool\Controller\Install] => ZFTool\Controller\InstallController
                    [zfcuser] => ZfcUser\Controller\UserController
                    [Admin] => Admin\Controller\AdminController
                )

        )

    [console] => Array
        (
            [router] => Array
                (
                    [routes] => Array
                        (
                            [zftool-version] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => version
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Info
                                                    [action] => version
                                                )

                                        )

                                )

                            [zftool-version2] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => --version
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Info
                                                    [action] => version
                                                )

                                        )

                                )

                            [zftool-config-list] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => config [list]
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Info
                                                    [action] => config
                                                )

                                        )

                                )

                            [zftool-classmap-generate] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => classmap generate <directory> [<destination>] [--append|-a] [--overwrite|-w]
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Classmap
                                                    [action] => generate
                                                )

                                        )

                                )

                            [zftool-modules-list] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => modules [list]
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Module
                                                    [action] => list
                                                )

                                        )

                                )

                            [zftool-create-project] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => create project <path>
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Create
                                                    [action] => project
                                                )

                                        )

                                )

                            [zftool-create-module] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => create module <name> [<path>]
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Create
                                                    [action] => module
                                                )

                                        )

                                )

                            [zftool-install-zf] => Array
                                (
                                    [options] => Array
                                        (
                                            [route] => install zf <path> [<version>]
                                            [defaults] => Array
                                                (
                                                    [controller] => ZFTool\Controller\Install
                                                    [action] => zf
                                                )

                                        )

                                )

                        )

                )

        )

    [doctrine] => Array
        (
            [connection] => Array
                (
                    [orm_default] => Array
                        (
                            [driverClass] => Doctrine\DBAL\Driver\PDOMySql\Driver
                            [params] => Array
                                (
                                    [host] => localhost
                                    [port] => 3306
                                    [user] => root
                                    [password] => 
                                    [dbname] => cervin
                                )

                        )

                )

        )

    [asset_manager] => Array
        (
            [resolver_configs] => Array
                (
                    [collections] => Array
                        (
                            [js/bootstrap-all.js] => Array
                                (
                                    [0] => js/jquery.js
                                    [1] => js/bootstrap.js
                                )

                            [js/dataTables.js] => Array
                                (
                                    [0] => js/jquery.dataTables.js
                                    [1] => js/ResultSet.js
                                )

                            [css/bootstrap-all.css] => Array
                                (
                                    [0] => css/bootstrap.css
                                    [1] => css/bootstrap-responsive.css
                                )

                        )

                    [paths] => Array
                        (
                            [0] => C:\Program Files\EasyPHP-DevServer-13.1VC9\data\localweb\cervin\config\autoload/../../public
                        )

                    [map] => Array
                        (
                        )

                )

            [caching] => Array
                (
                    [default] => Array
                        (
                            [cache] => FilePath
                            [options] => Array
                                (
                                    [dir] => C:\Program Files\EasyPHP-DevServer-13.1VC9\data\localweb\cervin\config\autoload/../../data/cache
                                )

                        )

                )

            [filters] => Array
                (
                    [js/dataTables.js] => Array
                        (
                            [0] => Array
                                (
                                    [filter] => JSMin
                                )

                        )

                    [js/bootstrap-all.js] => Array
                        (
                            [0] => Array
                                (
                                    [filter] => JSMin
                                )

                        )

                )

        )

    [bjyauthorize] => Array
        (
            [default_role] => Visiteur
            [authenticated_role] => Utilisateur
            [identity_provider] => BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider
            [role_providers] => Array
                (
                    [BjyAuthorize\Provider\Role\ObjectRepositoryProvider] => Array
                        (
                            [object_manager] => doctrine.entitymanager.orm_default
                            [role_entity_class] => SamUser\Entity\Role
                        )

                )

            [resource_providers] => Array
                (
                    [BjyAuthorize\Provider\Resource\Config] => Array
                        (
                            [Admin] => Array
                                (
                                )

                            [Parcours] => Array
                                (
                                )

                            [Collection] => Array
                                (
                                )

                            [Utilisateur] => Array
                                (
                                )

                        )

                )

            [rule_providers] => Array
                (
                    [BjyAuthorize\Provider\Rule\Config] => Array
                        (
                            [allow] => Array
                                (
                                    [0] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [0] => Admin
                                                )

                                            [1] => Admin
                                        )

                                    [1] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [0] => Parcours
                                                )

                                            [1] => Parcours
                                        )

                                    [2] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [0] => Collection
                                                )

                                            [1] => Collection
                                        )

                                    [3] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [0] => Utilisateur
                                                )

                                            [1] => Utilisateur
                                        )

                                )

                            [deny] => Array
                                (
                                )

                        )

                )

            [guards] => Array
                (
                    [BjyAuthorize\Guard\Controller] => Array
                        (
                            [0] => Array
                                (
                                    [controller] => Album\Controller\Album
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [1] => Array
                                (
                                    [controller] => Page
                                    [action] => index
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [2] => Array
                                (
                                    [controller] => Page
                                    [action] => voir
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [3] => Array
                                (
                                    [controller] => Page
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [4] => Array
                                (
                                    [controller] => zfcuser
                                    [roles] => Array
                                        (
                                        )

                                )

                            [5] => Array
                                (
                                    [controller] => zfcuser
                                    [action] => register
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [6] => Array
                                (
                                    [controller] => Admin
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [7] => Array
                                (
                                    [controller] => Admin
                                    [action] => demandeRole
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [8] => Array
                                (
                                    [controller] => Admin
                                    [action] => refueRole
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [9] => Array
                                (
                                    [controller] => typeElement
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [10] => Array
                                (
                                    [controller] => Collection
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [11] => Array
                                (
                                    [controller] => Admin
                                    [action] => onLine
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [12] => Array
                                (
                                    [controller] => Artefact
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [13] => Array
                                (
                                    [controller] => Artefact
                                    [action] => voirArtefact
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [14] => Array
                                (
                                    [controller] => Media
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [15] => Array
                                (
                                    [controller] => Parcours
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [16] => Array
                                (
                                    [controller] => Scene
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [17] => Array
                                (
                                    [controller] => fileupload_examples
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [18] => Array
                                (
                                    [controller] => fileupload_prgexamples
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [19] => Array
                                (
                                    [controller] => fileupload_progressexamples
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [20] => Array
                                (
                                    [controller] => Semantique
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [21] => Array
                                (
                                    [controller] => SemantiqueTransition
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                        )

                    [BjyAuthorize\Guard\Route] => Array
                        (
                            [0] => Array
                                (
                                    [route] => album
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [1] => Array
                                (
                                    [route] => home
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [2] => Array
                                (
                                    [route] => admin
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [3] => Array
                                (
                                    [route] => admin/gestion-users
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [4] => Array
                                (
                                    [route] => admin/changeUserAjax
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [5] => Array
                                (
                                    [route] => admin/demandeRole
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [6] => Array
                                (
                                    [route] => admin/refueRole
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [7] => Array
                                (
                                    [route] => admin/logs
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [8] => Array
                                (
                                    [route] => page
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [9] => Array
                                (
                                    [route] => page/voir
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [10] => Array
                                (
                                    [route] => page/modifier
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [11] => Array
                                (
                                    [route] => zfcuser
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [12] => Array
                                (
                                    [route] => zfcuser/logout
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [13] => Array
                                (
                                    [route] => zfcuser/login
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [14] => Array
                                (
                                    [route] => zfcuser/register
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [15] => Array
                                (
                                    [route] => zfcuser/changepassword
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [16] => Array
                                (
                                    [route] => zfcuser/changeemail
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [17] => Array
                                (
                                    [route] => typeElement
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [18] => Array
                                (
                                    [route] => typeElement/add
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [19] => Array
                                (
                                    [route] => typeElement/editTypeElementAjax
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [20] => Array
                                (
                                    [route] => collection
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [21] => Array
                                (
                                    [route] => collection/consulter
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [22] => Array
                                (
                                    [route] => collection/onLine
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [23] => Array
                                (
                                    [route] => artefact
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [24] => Array
                                (
                                    [route] => artefact/ajouter
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [25] => Array
                                (
                                    [route] => artefact/voirArtefact
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [26] => Array
                                (
                                    [route] => artefact/editArtefact
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [27] => Array
                                (
                                    [route] => artefact/removeArtefact
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [28] => Array
                                (
                                    [route] => artefact/supprimerRelationArtefactSemantique
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [29] => Array
                                (
                                    [route] => artefact/addRelationArtefactSemantique
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [30] => Array
                                (
                                    [route] => artefact/getAllArtefact
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [31] => Array
                                (
                                    [route] => artefact/addRelationArtefactMedia
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [32] => Array
                                (
                                    [route] => artefact/getAllMedia
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [33] => Array
                                (
                                    [route] => media
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [34] => Array
                                (
                                    [route] => media/ajouter
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [35] => Array
                                (
                                    [route] => media/voirMedia
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [36] => Array
                                (
                                    [route] => media/editMedia
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [37] => Array
                                (
                                    [route] => media/removeMedia
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [38] => Array
                                (
                                    [route] => media/addRelationMediaArtefact
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [39] => Array
                                (
                                    [route] => media/supprimerRelationMediaArtefact
                                    [roles] => Array
                                        (
                                            [0] => Collection
                                        )

                                )

                            [40] => Array
                                (
                                    [route] => media/getAllArtefact
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [41] => Array
                                (
                                    [route] => semantique
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [42] => Array
                                (
                                    [route] => semantique/ajouter
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [43] => Array
                                (
                                    [route] => semantique/supprimer
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [44] => Array
                                (
                                    [route] => semantique/modifier
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [45] => Array
                                (
                                    [route] => fileupload
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [46] => Array
                                (
                                    [route] => fileupload/single
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [47] => Array
                                (
                                    [route] => fileupload/success
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [48] => Array
                                (
                                    [route] => fileupload/multi-html5
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [49] => Array
                                (
                                    [route] => fileupload/collection
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [50] => Array
                                (
                                    [route] => fileupload/partial
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [51] => Array
                                (
                                    [route] => fileupload/prg
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [52] => Array
                                (
                                    [route] => fileupload/prg/multi-html5
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [53] => Array
                                (
                                    [route] => fileupload/prg/fieldset
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [54] => Array
                                (
                                    [route] => fileupload/progress
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [55] => Array
                                (
                                    [route] => fileupload/progress/session
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [56] => Array
                                (
                                    [route] => fileupload/progress/session_partial
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [57] => Array
                                (
                                    [route] => fileupload/progress/session-progress
                                    [roles] => Array
                                        (
                                            [0] => Visiteur
                                        )

                                )

                            [58] => Array
                                (
                                    [route] => parcours
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [59] => Array
                                (
                                    [route] => parcours/voir
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [60] => Array
                                (
                                    [route] => parcours/ajouter
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [61] => Array
                                (
                                    [route] => parcours/supprimer
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [62] => Array
                                (
                                    [route] => parcours/modifierTransition
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [63] => Array
                                (
                                    [route] => parcours/supprimerTransitionSec
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [64] => Array
                                (
                                    [route] => parcours/ajouterTransitionSec
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [65] => Array
                                (
                                    [route] => parcours/modifier
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [66] => Array
                                (
                                    [route] => parcours/voirParcourHalviz
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [67] => Array
                                (
                                    [route] => parcours/ajouterSousParcours
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [68] => Array
                                (
                                    [route] => parcours/supprimerSousParcours
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [69] => Array
                                (
                                    [route] => parcours/editSousParcours
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [70] => Array
                                (
                                    [route] => semantiquetransition
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [71] => Array
                                (
                                    [route] => semantiquetransition/ajouter
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [72] => Array
                                (
                                    [route] => semantiquetransition/modifier
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [73] => Array
                                (
                                    [route] => semantiquetransition/supprimer
                                    [roles] => Array
                                        (
                                            [0] => Admin
                                        )

                                )

                            [74] => Array
                                (
                                    [route] => scene
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [75] => Array
                                (
                                    [route] => scene/voirScene
                                    [roles] => Array
                                        (
                                            [0] => Utilisateur
                                        )

                                )

                            [76] => Array
                                (
                                    [route] => scene/retirerSceneSecondaire
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [77] => Array
                                (
                                    [route] => scene/removeScene
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [78] => Array
                                (
                                    [route] => scene/creerSceneSecondaire
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [79] => Array
                                (
                                    [route] => scene/insererSceneRecommandee
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [80] => Array
                                (
                                    [route] => scene/retirerSceneRecommandee
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [81] => Array
                                (
                                    [route] => scene/editScene
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [82] => Array
                                (
                                    [route] => scene/deleteElement
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [83] => Array
                                (
                                    [route] => scene/getAllElement
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                            [84] => Array
                                (
                                    [route] => scene/addRelationSceneElement
                                    [roles] => Array
                                        (
                                            [0] => Parcours
                                        )

                                )

                        )

                )

        )

    [zfcuser] => Array
        (
            [enable_registration] => 1
            [enable_username] => 1
            [auth_adapters] => Array
                (
                    [100] => ZfcUser\Authentication\Adapter\Db
                )

            [enable_display_name] => 1
            [auth_identity_fields] => Array
                (
                    [0] => username
                )

            [login_after_registration] => 1
            [use_redirect_parameter_if_present] => 1
            [user_login_widget_view_template] => zfc-user/user/widgetLogin.phtml
            [login_redirect_route] => home
            [logout_redirect_route] => home
        )

    [router] => Array
        (
            [routes] => Array
                (
                    [zfcuser] => Array
                        (
                            [type] => Literal
                            [priority] => 1000
                            [options] => Array
                                (
                                    [route] => /user
                                    [defaults] => Array
                                        (
                                            [controller] => zfcuser
                                            [action] => index
                                        )

                                )

                            [may_terminate] => 1
                            [child_routes] => Array
                                (
                                    [login] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /login
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => login
                                                        )

                                                )

                                        )

                                    [authenticate] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /authenticate
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => authenticate
                                                        )

                                                )

                                        )

                                    [logout] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /logout
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => logout
                                                        )

                                                )

                                        )

                                    [register] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /register
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => register
                                                        )

                                                )

                                        )

                                    [changepassword] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /change-password
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => changepassword
                                                        )

                                                )

                                            [may_terminate] => 1
                                            [child_routes] => 
                                        )

                                    [changeemail] => Array
                                        (
                                            [type] => Literal
                                            [options] => Array
                                                (
                                                    [route] => /change-email
                                                    [defaults] => Array
                                                        (
                                                            [controller] => zfcuser
                                                            [action] => changeemail
                                                        )

                                                )

                                            [may_terminate] => 1
                                            [child_routes] => 
                                        )

                                )

                        )

                )

        )

    [navigation] => Array
        (
            [default] => Array
                (
                    [account] => Array
                        (
                            [label] => Account
                            [route] => zfcuser
                            [pages] => Array
                                (
                                    [home] => Array
                                        (
                                            [label] => Dashboard
                                            [route] => zfcuser
                                        )

                                    [login] => Array
                                        (
                                            [label] => Sign In
                                            [route] => zfcuser/login
                                        )

                                    [logout] => Array
                                        (
                                            [label] => Sign Out
                                            [route] => zfcuser/logout
                                        )

                                    [register] => Array
                                        (
                                            [label] => Register
                                            [route] => zfcuser/register
                                        )

                                )

                        )

                )

        )

    [zenddevelopertools] => Array
        (
            [profiler] => Array
                (
                    [enabled] => 
                    [strict] => 
                    [flush_early] => 
                    [cache_dir] => data/cache
                    [matcher] => Array
                        (
                        )

                    [collectors] => Array
                        (
                        )

                )

            [toolbar] => Array
                (
                    [enabled] => 1
                    [auto_hide] => 
                    [position] => bottom
                    [version_check] => 1
                    [entries] => Array
                        (
                        )

                )

        )

)
