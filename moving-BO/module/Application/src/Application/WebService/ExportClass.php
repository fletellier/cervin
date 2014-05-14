<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Webservice;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManagerInterface;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;
use Parcours\Entity\Parcours;
use Parcours\Controller\ParcoursController;

class ExportClass
{
	
    /**
     * Dit bonjour!
     *
     *
     * @return string
     */
    public function helloWorld(){
    	return 'coucou';
    }
    
	/**
	 * Retourne le titre d'un parcours
	 * 
	 * @param integer $id
	 * @return array
	 */
    public function getParcours($id){
    	
        //$parcours = $this->getEntityManager()->getRepository('Parcours\Entity\Parcours')->findOneBy(array('id'=>$id));
        $parcoursCtrlr = new ParcoursController();
        $parcours = $parcoursCtrlr->getParcours($id);
    	
        return $parcours;
    }
}