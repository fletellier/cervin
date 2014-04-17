<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Parcours\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Parcours\Entity\Parcours;
use Parcours\Entity\SousParcours;
use Parcours\Form\ParcoursForm;
use Parcours\Entity\TransitionRecommandee;
use Parcours\Entity\SceneRecommandee;
use Zend\Json\Json;

/**
 * Controleur des transitions
 *
 * @property Doctrine\ORM\EntityManager $em Entity Manager
 */
class TransitionController extends AbstractActionController
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Initialisation de l'Entity Manager
	 *
	 * @param Doctrine\ORM\EntityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Retourne l'Entity Manager
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
	 * Affiche la liste des parcours
	 * 
	 */
    public function indexAction()
    {
        return new ViewModel();
    }


    /**
     * Affiche une transition
     * 
     * @return void|\Zend\View\Model\ViewModel
     */
    public function voirAction()
    {
    	$id = (int) $this->params('id', null);
    	$transition = $this->getEntityManager()
	    	->getRepository('Parcours\Entity\Transition')
	    	->findOneBy(array('id'=>$id));
    	if ($transition === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	return new ViewModel(array(
    		'transition' => $transition
    	));
    }

    /**  
     * Modifie la sémantique ou la narration d'une transition 
     */
    public function modifierAction()
    {
    	$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
    	$escapeHtml = $viewHelperManager->get('escapeHtml');
    	$id = (int) $this->params('id', null);
    	$Transition = $this->getEntityManager()
	    	->getRepository('Parcours\Entity\Transition')
	    	->findOneBy(array('id'=>$id));
    	if ($Transition === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	
    	if ($Transition->sous_parcours) {
	    	if ($Transition->sous_parcours->utilisateur != $this->zfcUserAuthentication()->getIdentity()) {
	    		$this->flashMessenger()->addErrorMessage(sprintf('Le sous-parcours <em>'. $escapeHtml($Transition->sous_parcours->titre) .'</em> doit faire partie de vos chantiers en cours pour que vous puissiez modifier cette transition.'));
	    		return $this->redirect()->toRoute('transition/voir', array('id'=>$Transition->id));
	    	}
    	}
    	
        if ($this->getRequest()->isXmlHttpRequest()) 
        {
            $request = $this->params()->fromPost();
            switch ($request['name']) {
                case 'semantique':
	                $SemantiqueTransition = $this->getEntityManager()
		                ->getRepository('Parcours\Entity\SemantiqueTransition')
		                ->findOneBy(array('id'=>$request['value']));
	                $Transition->semantique = $SemantiqueTransition;
	                $this->getEntityManager()->flush();
	                $this->flashMessenger()->addSuccessMessage(sprintf('La sémantique a bien été modifiée'));
	                return $this->getResponse()->setContent(Json::encode(true));
	                break;

                case 'narration':
	                $Transition->narration = $request['value'];
	                $this->getEntityManager()->flush();
	                return $this->getResponse()->setContent(Json::encode(true));
	                break;

                default:
                	$this->getResponse()->setStatusCode(404);
                	break;
            }
        } else {
        	$SemantiqueTransitions = $this->getEntityManager()
	        	->getRepository('Parcours\Entity\SemantiqueTransition')
	        	->findBy(array(), array('semantique'=>'asc'));
        	return new ViewModel(array(
        			'transition' => $Transition,
        			'SemantiqueTransitions' => $SemantiqueTransitions
        	));
        }
    }
    
    public function supprimerTransitionSecAction()
    {
    	$id = (int) $this->params('id', null);
    	$transition = $this->getEntityManager()
    		->getRepository('Parcours\Entity\Transition')
    		->findOneBy(array('id'=>$id));
    	if ($transition === null || $id === null) {
    		$this->getResponse()->setStatusCode(404);
    		return;
    	}
    	$this->getEntityManager()->remove($transition);
    	$this->getEntityManager()->flush();
    	$this->flashMessenger()->addSuccessMessage(sprintf('La transition a bien été supprimée.'));
    	return $this->getResponse()->setContent(Json::encode(true));
    }

    public function ajouterTransitionSecAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$request = $this->params()->fromPost();
    		
	    	$idSceneOrigine = $request['idSceneOrigine'];
	    	$sceneOrigine = $this->getEntityManager()
		    	->getRepository('Parcours\Entity\Scene')
		    	->findOneBy(array('id'=>$idSceneOrigine));
	    	if ($sceneOrigine === null || $idSceneOrigine === null ) {
	    		$this->getResponse()->setStatusCode(404);
	    		return;
	    	}
	    	
	    	$idSceneDestination = $request['idSceneDestination'];
	    	if ($idSceneDestination == 0) {
	    		// Pas de scène destination précisée pour la nouvelle transition secondaire
	    		// On doit en créer une
	    		$sceneDestination = new \Parcours\Entity\SceneSecondaire();
	    		$sceneDestination->titre = "Nouvelle scène secondaire";
	    		$sceneDestination->narration = "";
	    		$sceneDestination->elements = new \Doctrine\Common\Collections\ArrayCollection();
	    		$sceneOrigine->sous_parcours->addScene($sceneDestination);
	    		$this->getEntityManager()->persist($sceneDestination);
	    		//$manager->flush();
	    	} else {
	    		$sceneDestination = $this->getEntityManager()
	    			->getRepository('Parcours\Entity\Scene')
	    			->findOneBy(array('id'=>$idSceneDestination));
	    	}
	    	if ($sceneDestination === null || $idSceneDestination === null ) {
	    		$this->getResponse()->setStatusCode(404);
	    		return;
	    	}
	    	
	    	$transition = new \Parcours\Entity\TransitionSecondaire();
	    	$transition->narration = "Nouvelle transition";
	    	$transition->scene_origine = $sceneOrigine;
	    	$transition->scene_destination = $sceneDestination;
	    	
	    	$sceneOrigine->sous_parcours->addTransition($transition);
	    	$this->getEntityManager()->persist($transition);
	    	$this->getEntityManager()->flush();
	    	
	    	$this->flashMessenger()->addSuccessMessage(sprintf('La transition a bien été ajoutée.'));
	    	return $this->getResponse()->setContent(Json::encode(true));
    	} else {
    		$this->getResponse()->setStatusCode(404);
    	}
    }
    
}
