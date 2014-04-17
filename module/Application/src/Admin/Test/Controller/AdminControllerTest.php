<?php

namespace AdminTest\Controller;

use Zend;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller;
use Zend\Mvc\MvcEvent;
//use SamUser\Entity\User;
//use SamUser\Entity\Role;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Admin\Controller\AdminController;
use Doctrine\ORM\EntityManager;
use ZfcUser\Entity\UserInterface;
use ZfcUser\Entity\User;
use ZfcUser\Controller\Plugin\ZfcUserAuthentication;



class AdminControllerTest extends AbstractHttpControllerTestCase
{
	protected $traceError = true;

	protected $request;
	protected $bootstrap;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ .'/../../../../../../config/application.config.php'
        );
		
    	/*$di = new Di();
    	$di->instanceManager()->addTypePreference('Zend\ServiceManager\ServiceLocatorInterface', 'Zend\ServiceManager\ServiceManager');
    	$di->instanceManager()->addTypePreference('Zend\EventManager\EventManagerInterface', 'Zend\EventManager\EventManager');
    	$di->instanceManager()->addTypePreference('Zend\EventManager\SharedEventManagerInterface', 'Zend\EventManager\SharedEventManager');
    	$di->instanceManager()->addTypePreference('Zend\EventManager\SharedListenerAggregateInterface', 'Zend\EventManager\SharedListenerAggregate');
    	
        $this->setBootstrap(__DIR__ . '/../../../../../../tests/bootstrap.php');
        
        $application = require $this->bootstrap;
        $serviceManager = $application->getServiceManager();
        
        //$serviceManager = Bootstrap::getServiceManager();
        //$this->controller = new RegisterController();
        //$this->controller = $di->newInstance('Admin\Controller\AdminController');
        $this->controller = new AdminController();
        $this->request    = new Request();
       // $this->routeMatch = new RouteMatch(array('controller' => 'add'));
        $this->event      = new MvcEvent();
        //$config = $serviceManager->get('Config');
        //$routerConfig = isset($config['router']) ? $config['router'] : array();
        //$router = HttpRouter::factory($routerConfig);
        //$this->event->setRouter($router);
        //$this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $mockAuth = $this->getMock('ZfcUser\Entity\UserInterface');
        
        $ZfcUserMock = $this -> getMock('ZfcUser\Entity\User');
        
        $ZfcUserMock    -> expects($this->any())
        -> method('getId')
        -> will($this->returnValue('1'));
        
        $authMock = $this->getMock('ZfcUser\Controller\Plugin\ZfcUserAuthentication');
        
        $authMock   -> expects($this->any())
        -> method('hasIdentity')
        -> will($this->returnValue(true));

        $authMock   -> expects($this->any())
        -> method('zfcUserIdentity')
        -> will($this->returnValue(true));
        
        $authMock   -> expects($this->any())
        -> method('getIdentity')
        -> will($this->returnValue($ZfcUserMock));
        
        $this -> controller->getPluginManager()
        ->setService('zfcUserAuthentication', $authMock);*/

        parent::setUp();
    }
	
	public function testEditusersActionCanBeAccessed()
	{
		$postData = array(
							'identity' => 'adminlogin',
	  						'credential' => 'toto123'
						);

 		$this->dispatch('/user/login', 'POST', $postData);
 		$this->assertMatchedRouteName('zfcuser/login');
		//$this->assertResponseStatusCode(200);
		$this->assertRedirectTo('/');
		//$this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
		
		//$this->dispatch('/user/login');
		//$this->assertNotXpathQueryContentContains('/html/body/div[2]/div/form/fieldset/ul/li', 'Authentication failed. Please try again.');

		/*$this->dispatch('/admin/gestion-users');
		$this->assertResponseStatusCode(200);
		//$this->assertNotXpath( '//div[@id="errors"]' );
		//$this->assertRedirectTo('home');

		$this->assertModuleName('Admin');
		$this->assertControllerName('Admin');
		$this->assertControllerClass('AdminController');
		$this->assertMatchedRouteName('editusers');*/
	}
	
	/*public function testZfcUserIdentity(){

		
		$this->assertTrue($this->zfcUserAuthentication()->hasIdentity());
	}*/
	
	protected function setBootstrap($bootstrap)
	{
		$this->bootstrap = $bootstrap;
	
		return $this;
	}
}
