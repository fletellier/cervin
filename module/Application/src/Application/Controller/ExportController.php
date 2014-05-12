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
use Application\Model\ModAutoDiscover;

class ExportController extends AbstractActionController
{
	private $_options  = array('soap_version' => SOAP_1_2);
    private $_URI      = '/export';
    private $_WSDL_URI = '/export?wsdl';

    public function indexAction() {

        if (isset($_GET['wsdl'])) {
            $this->handleWSDL();
        } else {
            $this->handleSOAP();
        }

        return $this->getResponse();
    }

    private function handleWSDL() {
    	
        $serverUrl    = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT']."/Moving-BO/public";
        $autodiscover = new ModAutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeComplex());

        $autodiscover->setClass('Application\Model\ExportModel')
                     ->setUri($serverUrl.$this->_URI);

        $autodiscover->handle();
    }

    private function handleSOAP() {
    	$exportModel = $this->getServiceLocator()->get('Application\Model\ExportModel');
    	$serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT']."/Moving-BO/public";
        $soap      = new Server($serverUrl.$this->_WSDL_URI, $this->_options);

        $soap->setClass('Application\Model\ExportModel');
        $soap->setObject($exportModel);
        $soap->handle();
    }
    
}