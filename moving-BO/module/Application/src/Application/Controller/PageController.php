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

class PageController extends AbstractActionController
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
     * Affichage d'une page
     * 
     **/
    public function voirAction()
    {
    	$slug =  $this->params()->fromRoute('slug');
    	$page = $this->getEntityManager()->getRepository('Application\Entity\Page')->findOneBy(array('slug'=>$slug));
    	if ($page === null or $slug === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
        return new ViewModel(array('page' => $page));
    }

    /**
     * Modification d'une page
     * 
     **/
    public function modifierAction()
    {
        $slug =  $this->params()->fromRoute('slug');
    	$page = $this->getEntityManager()->getRepository('Application\Entity\Page')->findOneBy(array('slug'=>$slug));
    	if ($page === null or $slug === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$request = $this->getRequest();
        if ($request->isPost())
        {
            //save new text
            $data = $this->getRequest()->getPost()->toArray();
            
            $text = $data["wysihtml5"];
            $page->texte = $text;
            $this->getEntityManager()->persist($page);
            $this->getEntityManager()->flush();
            return $this->redirect()->toRoute('page/voir',array('slug'=>$page->slug));
        }
        else
        {
            return new ViewModel(array('page' => $page));
        }
        
    }
}
