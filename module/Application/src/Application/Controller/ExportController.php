<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Zend\Soap\Server;
use Zend\Soap\AutoDiscover;

class ExportController extends AbstractActionController
{
	private $_options  = array('soap_version' => SOAP_1_2);
    private $_URI      = '/export';
    private $_WSDL_URI = '/export?wsdl';

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Return a EntityManager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if ($this->em === null) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->em;
	}

    public function indexAction() {

        if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }

        return $this->getResponse();
    }

    private function handleWSDL() {
        $serverUrl    = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
        $autodiscover = new AutoDiscover();

        $autodiscover->setClass('Application\WebService\ExportClass')
                     ->setUri($serverUrl.$this->_URI);

        $autodiscover->handle();
        //header("Content-Type: text/xml");
        //echo $autodiscover->toXml();
    }

    private function handleSOAP() {
    	$serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
        $soap      = new Server($serverUrl.$this->_WSDL_URI, $this->_options);

        $soap->setClass('Application\WebService\ExportClass');

        $soap->handle();
    }
    
}