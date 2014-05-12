<?php 
namespace Application\Model;

use Doctrine\ORM\EntityManager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManagerInterface;

class ExportModel implements ServiceLocatorAwareInterface
{
	
	
	/**
	 * @notAutoDiscoverable
	 */
	protected $services;
	
	/**
	 * @notAutoDiscoverable
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->services = $serviceLocator;
	}
	
	/**
	 * @notAutoDiscoverable
	 */
	public function getServiceLocator()
	{
		return $this->services;
	}
	
	/**
	 * @notAutoDiscoverable
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	/**
	 * Initialisation de l'Entity Manager
	 * @notAutoDiscoverable
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	
	/**
	 * Retourne l'Entity Manager
	 * @notAutoDiscoverable
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
	 * Retourne les parcours
	 *
	 * 
	 * @return Parcours\Entity\Parcours[]
	 */
	public function getAllParcours()
	{
		$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findAll();
		return $parcours;
	}
	
	
	/**
	 * Retourne les elements
	 *
	 *
	 * @return Collection\Entity\Element[]
	 */
	public function getAllElements()
	{
		$parcours = $this->getEntityManager()->getRepository('Collection\Entity\Element')->findAll();
		return $parcours;
	}
	
	/**
	 * Retourne un parcours par son ID
	 *
	 * @param integer $id
	 * @return Parcours\Entity\Parcours
	 */
	public function getParcoursById($id){
		 
		$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
		return $parcours;
	}
	
	/**
	 * Retourne les Datas
	 *
	 * 
	 * @return Collection\Entity\Data[]
	 */
	public function getAllDatas(){
		
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\Data')->findAll();
		return $datas;
		
	}
	
	/**
	 * Retourne les DataDates
	 *
	 *
	 * @return Collection\Entity\DataDate[]
	 */
	public function getAllDataDates(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataDate')->findAll();
		return $datas;
	
	}
	
	/**
	 * Retourne les DataFichiers
	 *
	 *
	 * @return Collection\Entity\DataFichier[]
	 */
	public function getAllDataFichiers(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataFichier')->findAll();
		return $datas;
	
	}
	
	/**
	 * Retourne les DataGeopositions
	 *
	 *
	 * @return Collection\Entity\DataGeoposition[]
	 */
	public function getAllDataGeopositions(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataGeoposition')->findAll();
		return $datas;
	
	}
	
	/**
	 * Retourne les DataNombres
	 *
	 * @return Collection\Entity\DataGeoposition[]
	 */
	public function getAllDataNombres(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataNombre')->findAll();
		return $datas;
	
	}
	
	/**
	 * Retourne les DataSelects
	 *
	 * @return Collection\Entity\DataSelect[]
	 */
	public function getAllDataSelects(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataSelect')->findAll();
		return $datas;
	
	}
	
	
	/**
	 * Retourne les DataTextareas
	 *
	 * @return Collection\Entity\DataTextarea[]
	 */
	public function getAllDataTextareas(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataTextarea')->findAll();
		return $datas;
	
	}
	

	/**
	 * Retourne les DataTextes
	 *
	 * @return Collection\Entity\DataTexte[]
	 */
	public function getAllDataTextes(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataTexte')->findAll();
		return $datas;
	
	}
	
	/**
	 * Retourne les DataUrl
	 *
	 * @return Collection\Entity\DataUrl[]
	 */
	public function getAllDataUrl(){
	
		$datas = $this->getEntityManager()->getRepository('Collection\Entity\DataUrl')->findAll();
		return $datas;
	
	}
}