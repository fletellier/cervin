<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use SamUser\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\View\Helper\Notification;
use Application\View\Helper\demandeRole;
use Application\View\Helper\ConditionsGenerales;
use Zend\I18n\Translator\Translator;
use Zend\Validator\AbstractValidator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\Digits;

use Gedmo\Loggable\LoggableListener as LoggableListener;
//use Application\Library\TablePrefix;

class Module implements AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
        // standard annotation reader
        $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader;

        $app  = $e  ->getParam('application');
        $sm   = $e  ->getApplication()->getServiceManager();
        $em   = $sm ->get('doctrine.entitymanager.orm_default');
        $evm  = $em ->getEventManager();
        $evsm = $app->getEventManager()->getSharedManager(); 

        //$tablePrefix = new TablePrefix('mbo_');
        //$evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
      	
      	//  $evm = new \Doctrine\Common\EventManager();
        $auth = $sm->get('zfcuser_auth_service');

        $user = ($auth->getIdentity()) ? $auth->getIdentity()->id.' : '.$auth->getIdentity()->displayName : 'PUBLIC' ;
        
        $loggableListener = new LoggableListener;
        //$loggableListener->setAnnotationReader($cachedAnnotationReader);
        $loggableListener->setUsername($user);
        
        $evm->addEventSubscriber($loggableListener);

        $events = $e->getApplication()->getEventManager()->getSharedManager();

        $events->attach('ZfcUser\Form\Register','init', function($e) {
        	$form = $e->getTarget();
        	
        	//$form->get('email')->clearValidators();
        	
        	$form->add(array(
        			'name' => 'telephone',
        			'type' => 'Zend\Form\Element\Text',
        			'options' => array(
        					'label' => 'Téléphone',
        					'size'  => '12'
        			)
        	));
        	 
        	$form->add(array(
        		'name' => 'adresse',
        		'type' => 'Zend\Form\Element\Textarea',
        		'options' => array(
        				'label' => 'Adresse',
        				'size'  => '255'
        		)
        	));
        	
        	$form->add(array(
        		'name' => 'code_postal',
        		'type' => 'Zend\Form\Element\Text',
        		'options' => array(
        				'label' => 'Code Postal',
        				'size'  => '5'
        		)
        	));
        	
        	$form->add(array(
        		'name' => 'ville',
        		'type' => 'Zend\Form\Element\Text',
        		'options' => array(
        				'label' => 'Ville',
        				'size'  => '255'
        		)
        	));
        	
        	$form->add(array(
        		'name' => 'pays',
        		'type' => 'Zend\Form\Element\Text',
        		'options' => array(
        				'label' => 'Pays',
        				'size'  => '255'
        		)
        	));
        	
        	$form->add(array(
        		'name' => 'checkboxAgreement',
        		'type' => 'Zend\Form\Element\Checkbox',
        		'options' => array(
        				//'label' => "J'accepte les <a href='".$this->url('page/modifier',array('slug'=>'conditions-generales'))."'>conditions générales</a> du projet CERVIN",
        				'label' => 'J\'accepte les conditions générales du projet CERVIN',
        				'use_hidden_element' => true,
        				'checked_value' => 1,
                   		'unchecked_value' => 'no'
        		)
        	));
        	
        });
        
        $events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
        	$filter = $e->getTarget();
        	
        	/* On enlève le validator sur l'email de zfc-user 
			 * qui vérifie l'unicité de l'email
			 */ 
        	$filter->remove('email');
        	
        	$filter->add(array(
    			'name' => 'email',
    			'required' => true,
                'allowEmpty' => false,
    			'attributes' => array(
    				'type' => 'email'
    			),
        		'validators' => array(
        			array('name' => 'Zend\Validator\EmailAddress'),
        		),
        	));
        	
        	$filter->add(array(
    			'name'     => 'telephone',
                'required'   => true,
                'allowEmpty' => false,
    			'validators' => array(
					array(
						'name' => 'Regex',
						'break_chain_on_failure' => true,
						'options' => array(
								'pattern' => '#^0[1-68]([-. ]?\d{2}){4}$#'
						),
					),
    			),
        	));
        	
        	$filter->add(array(
    			'name'     => 'adresse',
    			'required'   => true,
    			'allowEmpty' => false,
    			'validators' => array(
					array(
						'name' => 'StringLength',
						'break_chain_on_failure' => true,
						'options' => array(
								'min' => 5,
								'max' => 255
						),
					),
    			),
        	));
        	
        	$filter->add(array(
    			'name'     => 'code_postal',
    			'required'   => true,
    			'allowEmpty' => false,
    			'validators' => array(
					array(
						'name' => 'PostCode',
						'break_chain_on_failure' => true,
						'options' => array(
								'locale' => 'fr_FR'
						),
					),
    			),
        	));
        	
        	$filter->add(array(
    			'name'     => 'ville',
    			'required'   => true,
    			'allowEmpty' => false,
    			'validators' => array(
					array(
						'name' => 'StringLength',
						'break_chain_on_failure' => true,
						'options' => array(
								'min' => 1,
								'max' => 255
						),
					),
    			),
        	));
        	
        	$filter->add(array(
    			'name'     => 'pays',
    			'required'   => true,
    			'allowEmpty' => false,
    			'validators' => array(
					array(
						'name' => 'StringLength',
						'break_chain_on_failure' => true,
						'options' => array(
								'min' => 1,
								'max' => 255
						),
					),
    			),
        	));
        	 
			$filter->add(array(
				'name'     => 'checkboxAgreement',
				'required'   => true,
				'allowEmpty' => false,
				'validators' => array(
					array(
						'name' => 'Digits',
						'break_chain_on_failure' => true,
						'options' => array(
							'messages' => array(
								Digits::NOT_DIGITS   => 'Vous devez accepter les conditions générales.',
							),
						),
					),
				),
			));
			
		});
        
        //$zfcServiceEvents  = $sm->get('zfcuser_user_service')->getEventManager();
        
        /*$zfcServiceEvents->attach('register', function($e) {
        	$form = $e->getParam('form');
        	//$user = $e->getParam('user');
        });*/

        // adding action for user login
        $evsm->attach('ZfcUser\Authentication\Adapter\AdapterChain', 'authenticate', function($e) use ($em) { 
            //$user = $e->getParam('user');  // User account object
            //$id = $user->getId(); // get user id

            if( $e->getIdentity() != null ){
                $user = $em->find('SamUser\Entity\User', $e->getIdentity());
                $user->setDerniereConnexion( new \DateTime('NOW') );
                $em->flush();
            }
        });
        
        /*$translator = new Translator();
        $translator->addTranslationFile(
         'phpArray',
         './vendor/zendframework/zendframework/resources/languages/fr/Zend_Validate.php',
         'default',
         'fr_FR'
        );
        $translate = new \Zend\I18n\Translator\Translator();
        AbstractValidator::setDefaultTranslator($translator);*/
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                /*'adminEmail' => function($sm) {
                    $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
                    return new adminEmail($locator->get('Doctrine\ORM\EntityManager'));
                },*/
                'Notification' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new Notification();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'demandeRole' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new demandeRole();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'flashMessages' => function($sm) {
                    $flashmessenger = $sm->getServiceLocator()
                        ->get('ControllerPluginManager')
                        ->get('flashmessenger');
 
                    $messages = new \Application\View\Helper\FlashMessages();
                    $messages->setFlashMessenger($flashmessenger);
 
                    return $messages;
                },
                'ConditionsGenerales' => function ($helperPluginManager) {
                	$serviceLocator = $helperPluginManager->getServiceLocator();
                	$viewHelper = new ConditionsGenerales();
                	$viewHelper->setServiceLocator($serviceLocator);
                	return $viewHelper;
                },
                'ExportClass' => function ($helperPluginManager) {
                	$serviceLocator = $helperPluginManager->getServiceLocator();
                	$classManager = new ExportClass();
                	$classManager->setServiceLocator($serviceLocator);
                	return $classManager;
                }
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'SamUser' => __DIR__ . '/src/SamUser',
                    'Admin' => __DIR__ . '/src/Admin',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'zfcuser_user_service' => 'SamUser\Service\User2',
            ),
            'factories' => array(

            )
        );
    }
}
