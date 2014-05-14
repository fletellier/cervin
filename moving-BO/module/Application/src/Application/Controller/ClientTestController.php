<?php

namespace Application\Controller;

use Zend\Soap\Client;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ClientTestController extends AbstractActionController {
	
	private $_WSDL_URI = '/export?wsdl';
 
	/**
	 * recast stdClass object to an object with type
	 *
	 * @param string $className
	 * @param stdClass $object
	 * @throws InvalidArgumentException
	 * @return mixed new, typed object
	 */
	function recast($className, \stdClass $object)
	{
	
	    $new = new $className();
	
	    foreach($object as $property => &$value)
	    {
	        $new->$property = &$value;
	        unset($object->$property);
	    }
	    unset($value);
	    $object = (unset) $object;
	    return $new;
	}
	
	public function indexAction() {
 
		// Appel du WebService
		$serverUrl = strtolower(dirname($_SERVER['SERVER_PROTOCOL']))."://".$_SERVER['HTTP_HOST']."/cervin/public";
		$client = new Client($serverUrl.$this->_WSDL_URI);
		$data = $client->getParcoursById(1);
		$types = $client->getTypes();

		
		// Passage des informations à la vue
		return new ViewModel( array(
			'data' => $data,
			'types' => $types
		));
	}
	
}
?>