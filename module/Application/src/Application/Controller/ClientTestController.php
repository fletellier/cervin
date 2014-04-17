<?php

namespace Application\Controller;

use Zend\Soap\Client;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ClientTestController extends AbstractActionController {
	
	private $_WSDL_URI = '/export?wsdl';
 
	public function indexAction() {
 
		// Appel du WebService
		$serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'];
		$client = new Client($serverUrl.$this->_WSDL_URI);
		$result = $client->getParcours(1);
 
		// Passage des informations à la vue
		return new ViewModel( array(
			'result' => $result
		));
	}
	
}
?>