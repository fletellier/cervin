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
use Application\Entity\Page;

class IndexController extends AbstractActionController
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

    public function indexAction()
    {
    	$page_accueil = $this->getEntityManager()->getRepository('Application\Entity\Page')->findOneBy(array('titre'=>'Accueil'));
        if($page_accueil == null){
        	$manager = $this->getEntityManager();
        	$page_accueil = new Page(
				'Accueil',
				'
					<h1>Moving-BO</h1>
					<h4>Prototype de Back-Office pour le projet Cervin</h4>
				'
			);
			$manager->persist($page_accueil);
			$manager->flush();
        }
        return new ViewModel(array('display' => $page_accueil->texte));
    }
}
