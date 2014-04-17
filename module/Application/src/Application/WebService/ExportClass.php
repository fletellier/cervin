<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\WebService;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class ExportClass implements ServiceLocatorAwareInterface
{
	
	protected $em;
	protected $serviceLocator;
	
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) 
    { 
        $this->serviceLocator = $serviceLocator; 
        return $this; 
    }

    public function getServiceLocator()
    { 
        return $this->serviceLocator; 
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

	/**
	 * Retourne le titre d'un parcours
	 * 
	 * @param integer $id
	 * @return string
	 */
    public function getParcours($id){
       // $parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        return "coucou";
    }

}