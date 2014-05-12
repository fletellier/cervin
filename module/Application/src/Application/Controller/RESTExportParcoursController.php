<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Parcours\Entity\Parcours;
use Doctrine\ORM\Query;

class RESTExportParcoursController extends AbstractRestfulController
{
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

	
	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{
		$params = $this->params()->fromQuery();
	
		$entityManager = $this->getEntityManager()
		->getRepository('Parcours\Entity\Parcours');
	
		$data = array();
		
		$listeParcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findAll();
		foreach ($listeParcours as $parcours){
		$data[] = $parcours->toArray();
		}
		
		return new JsonModel(array(
				'data' => $data,
				'success' => true,
		));
	}
	

	
	/**
	 * Return single resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function get($id)
	{
		$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
		
		//\Doctrine\Common\Util\Debug::dump($parcours);
		
		return new JsonModel(array(
				'data' => $parcours->toArray(),
				'succes' => true,
		));
		
	}
	
	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return json
	 */
	public function create($data)
	{
		
	}
	
	/**
	 * Update an existing resource
	 *
	 * @param int $id
	 * @param array $data
	 * @return json
	 */
	public function update($id, $data)
	{
		
	}
	
	/**
	 * Delete an existing resource
	 *
	 * @param  int $id
	 * @return json
	 */
	public function delete($id)
	{
		
	}
}